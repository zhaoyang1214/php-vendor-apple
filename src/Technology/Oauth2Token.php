<?php


namespace Snow\Technology;


use Snow\Apple\AppleInterface;
use Snow\Apple\TraitGuzzleRetry;

class Oauth2Token implements AuthInterface
{
    use TraitGuzzleRetry;

    private $accessToken;

    private $tokenType;

    private $expiresIn;

    private $timestamp;

    private $url = 'https://appleid.apple.com/auth/oauth2/token';

    private $apple;

    private $option = [
        'grant_type' => 'client_credentials',
        'scope' => 'searchadsorg',
        'verify' => false,
        'timeout' => 3,
    ];

    public function __construct(AppleInterface $apple, array $option = [])
    {
        $this->apple = $apple;
        if (isset($option['auth_url'])) {
            $this->url = $option['auth_url'];
            unset($option['auth_url']);
        }
        $option && $this->option = array_merge($this->option, $option);
    }

    public function getAuthorization(bool $force = false)
    {
        if ($force || is_null($this->accessToken) || time() - $this->timestamp >= $this->expiresIn) {
            try {
                $params = [
                    'grant_type' => $this->option['grant_type'],
                    'scope' => $this->option['scope'],
                    'client_id' => $this->apple->getClientId(),
                    'client_secret' => $this->apple->getJwt(),
                ];
                $url = $this->url . '?' . http_build_query($params);
                $this->timestamp = time();
                $response = $this->getHttpClient(['verify' => $this->option['verify'], 'timeout' => $this->option['timeout']])
                    ->post($url);
                if ($response->getStatusCode() != 200) {
                    throw new AuthException($response->getBody()->getContents(), $response->getStatusCode());
                }
                $data = json_decode($response->getBody()->getContents(), true);
                $this->accessToken = $data['access_token'];
                $this->tokenType = $data['token_type'];
                $this->expiresIn = $data['expires_in'];
            } catch (\Throwable $t) {
                throw new AuthException($t->getMessage(), $t->getCode());
            }
        }
        return $this->tokenType . ' ' . $this->accessToken;
    }
}