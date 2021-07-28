<?php

namespace Snow\Apple;

use Firebase\JWT\JWT;
use Snow\Apple\Technology\AuthInterface;
use Snow\Apple\Technology\Oauth2Token;
use Snow\Apple\Technology\TechnologyInterface;

class Apple implements AppleInterface
{
    /**
     * @var string
     */
    private $privateKey;

    /**
     * @var string
     */
    private $publicKey;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $teamId;

    /**
     * @var string
     */
    private $keyId;

    /**
     * @var string
     */
    private $audience;

    /**
     * @var string
     */
    private $alg;

    /**
     * @var string
     */
    protected $jwt;

    /**
     * @var int
     */
    protected $issuedAtTimestamp;

    /**
     * @var int
     */
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

    /**
     * Notes: 获取JWT
     * @param int|null $expirationTimestamp
     * @param bool $force
     * @return string
     */
    public function getJwt(int $expirationTimestamp = null, bool $force = false): string
    {
        if ($force || is_null($this->jwt) || $this->expirationTimestamp - 100 >= time()) {
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

    /**
     * Notes: 注册ASA服务
     * @param string $technology
     * @param array $option
     * @return mixed|TechnologyInterface
     * @throws AppleException
     */
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

    /**
     * Notes: 快速执行ASA服务
     * @param string $technology
     * @param mixed ...$params
     * @return mixed
     * @throws AppleException
     */
    public function execute(string $technology, ...$params)
    {
        return $this->technology($technology)->execute(...$params);
    }

    /**
     * Notes: 快速存取全局数据
     * @param string $key
     * @param mixed $value
     * @return mixed|null
     */
    public function storage(string $key, $value = null)
    {
        if (!is_null($value)) {
            $this->storage[$key] = $value;
        }
        return $this->storage[$key] ?? null;
    }
}