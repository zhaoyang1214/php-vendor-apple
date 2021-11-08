<?php


namespace Snow\Apple\Technology;


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
        'timeout' => 30,
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

    /**
     * Notes: 获取Access Token
     * @param bool $force
     * @return string
     * @throws AuthException
     */
    public function getAuthorization(bool $force = false)
    {
        if ($force || is_null($this->accessToken) || time() - $this->timestamp >= $this->expiresIn - 600) {
            $params = [
                'grant_type' => $this->option['grant_type'],
                'scope' => $this->option['scope'],
                'client_id' => $this->apple->getClientId(),
                'client_secret' => $this->apple->getJwt(),
            ];
            $url = $this->url . '?' . http_build_query($params);
            $response = $this->getHttpClient(['verify' => $this->option['verify'], 'timeout' => $this->option['timeout']])
                ->post($url);
            $this->timestamp = time();
            if ($response->getStatusCode() != 200) {
                throw new AuthException($response->getBody()->getContents(), $response->getStatusCode());
            }
            $data = json_decode($response->getBody()->getContents(), true);
            if (json_last_error()) {
                throw new AuthException('解析Authorization数据失败：' . json_last_error_msg());
            }
            $this->accessToken = $data['access_token'];
            $this->tokenType = $data['token_type'];
            $this->expiresIn = $data['expires_in'];
        }
        return $this->tokenType . ' ' . $this->accessToken;
    }
}