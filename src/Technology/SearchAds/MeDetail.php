<?php


namespace Snow\Apple\Technology\SearchAds;


use GuzzleHttp\Exception\GuzzleException;
use Snow\Apple\AppleInterface;
use Snow\Apple\TraitGuzzleRetry;

class MeDetail
{
    use TraitGuzzleRetry;

    protected $userId;

    protected $parentOrgId;

    protected $url = 'https://api.searchads.apple.com/api/v4/me';

    /** @var AppleInterface */
    protected $apple;

    /**
     * @var array
     */
    protected $option = [];

    public function __construct(AppleInterface $apple, array $option = [])
    {
        $this->apple = $apple;
        $this->option = $option;
    }

    /**
     * Notes: 发送请求
     * @throws SearchAdsException
     */
    protected function request()
    {
        try {
            $response = $this->getHttpClient(array_merge(['verify' => false, 'timeout' => 30], $this->option))->get($this->url, [
                'headers' => ['Authorization' => $this->apple->getAuth()->getAuthorization()]
            ]);
        } catch (GuzzleException $e) {
            throw new SearchAdsException($e->getMessage(), $e->getCode());
        }

        if ($response->getStatusCode() != 200) {
            throw new SearchAdsException($response->getBody()->getContents(), $response->getStatusCode());
        }
        $data = json_decode($response->getBody()->getContents(), true);
        if (json_last_error()) {
            throw new SearchAdsException($this->url . '接口数据解析失败:' . json_last_error_msg());
        }
        $this->userId = $data['data']['userId'];
        $this->parentOrgId = $data['data']['parentOrgId'];
    }

    /**
     * Notes: 获取userId
     * @return mixed
     * @throws SearchAdsException
     */
    public function getUserId()
    {
        if (is_null($this->userId)) {
            $this->request();
        }
        return $this->userId;
    }

    /**
     * Notes: 获取parentOrgId
     * @return mixed
     * @throws SearchAdsException
     */
    public function getParentOrgId()
    {
        if (is_null($this->parentOrgId)) {
            $this->request();
        }
        return $this->parentOrgId;
    }

}