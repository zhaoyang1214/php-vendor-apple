<?php


namespace Snow\Apple\Technology\SearchAds;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Snow\Apple\Technology\Technology;

abstract class SearchAds extends Technology implements SearchAdsInterface
{
    /** @var string 设置请求时验证SSL证书行为，默认false */
    const OPT_VERIFY = 'verify';

    /** @var string 设置请求超时的秒数，默认为10s */
    const OPT_TIMEOUT = 'timeout';

    /**
     * Notes: 初始化
     */
    public function init()
    {
        // 初始化MeDetail服务，ASA接口都需要orgId
        $this->getApple()->storage(MeDetail::class, new MeDetail($this->getApple()));
    }

    /**
     * Notes: 获取ASA http client
     * @return Client
     */
    protected function quickClient()
    {
        return $this->getHttpClient([
            'verify' => $this->getOption(self::OPT_VERIFY, false),
            'timeout' => $this->getOption(self::OPT_TIMEOUT, 10),
            'headers' => [
                'Authorization' => $this->getApple()->getAuth()->getAuthorization(),
                'X-AP-Context' => 'orgId=' . $this->getApple()->storage(MeDetail::class)->getParentOrgId(),
            ],
        ]);
    }

    /**
     * Notes: 解析response
     * @param ResponseInterface $response
     * @return mixed|string
     * @throws SearchAdsException
     */
    protected function parseResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() != 200) {
            throw new SearchAdsException($response->getBody()->getContents(), $response->getStatusCode());
        }
        $data = json_decode($response->getBody()->getContents(), true);
        return json_last_error() ? $response->getBody()->getContents() : $data;
    }
}