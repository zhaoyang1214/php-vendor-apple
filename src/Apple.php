<?php

namespace Snow\Apple;

use Firebase\JWT\JWT;
use Snow\Technology\AuthInterface;
use Snow\Technology\Oauth2Token;
use Snow\Technology\TechnologyInterface;

class Apple implements AppleInterface
{
    private $privateKey;

    private $publicKey;

    private $clientId;

    private $teamId;

    private $keyId;

    private $audience;

    private $alg;

    protected $jwt;

    protected $issuedAtTimestamp;

    protected $expirationTimestamp;

    /** @var Oauth2Token */
    protected $auth;

    /** @var TechnologyInterface[] */
    protected $technologies = [];

    protected $storage = [];

    public function __construct(
        string $privateKey,
        string $publicKey,
        string $clientId,
        string $teamId,
        string $keyId,
        string $audience,
        string $alg
    )
    {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
        $this->clientId = $clientId;
        $this->teamId = $teamId;
        $this->keyId = $keyId;
        $this->audience = $audience;
        $this->alg = $alg;
        $this->auth = new Oauth2Token($this);
    }

    public function getJwt(int $expirationTimestamp = null, bool $force = false): string
    {
        if ($force || is_null($this->jwt) || $this->expirationTimestamp >= time()) {
            $this->issuedAtTimestamp = time();
            $this->expirationTimestamp = $expirationTimestamp ?: $this->issuedAtTimestamp + 86400 * 180;
            $headers = [
                'alg' => $this->alg,
                'kid' => $this->keyId,
            ];

            $payload = [
                'sub' => $this->clientId,
                'aud' => $this->audience,
                'iat' => $this->issuedAtTimestamp,
                'exp' => $this->expirationTimestamp,
                'iss' => $this->teamId,
            ];
            $this->jwt = JWT::encode($payload, $this->privateKey, $this->alg, null, $headers);
        }
        return $this->jwt;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function setAuth(AuthInterface $auth)
    {
        $this->auth = $auth;
        return $this;
    }

    public function getAuth(): AuthInterface
    {
        return $this->auth;
    }

    public function technology(string $technology, array $option = [])
    {
        if (!isset($this->technologies[$technology])) {
            if (!class_exists($technology)) {
                throw new AppleException("类 {$technology} 没有找到。");
            }
            $t = new $technology($option);
            if (!($t instanceof TechnologyInterface)) {
                throw new AppleException("类 {$technology} 必须 implements " . TechnologyInterface::class);
            }
            $t->setApple($this);
            if (method_exists($t, 'init')) {
                $t->{'init'}();
            }
            $this->technologies[$technology] = $t;
        }
        return $this->technologies[$technology];
    }

    public function execute(string $technology, ...$params)
    {
        return $this->technology($technology)->execute(...$params);
    }

    public function storage(string $key, $value = null)
    {
        if (!is_null($value)) {
            $this->storage[$key] = $value;
        }
        return $this->storage[$key] ?? null;
    }
}