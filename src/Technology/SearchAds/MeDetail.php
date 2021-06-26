<?php


namespace Snow\Technology\SearchAds;


use Snow\Apple\AppleInterface;
use Snow\Apple\TraitGuzzleRetry;

class MeDetail
{
    use TraitGuzzleRetry;

    private $userId;

    private $parentOrgId;

    private $url = 'https://api.searchads.apple.com/api/v4/me';

    /** @var AppleInterface */
    private $apple;

    public function __construct(AppleInterface $apple)
    {
        $this->apple = $apple;
    }

    protected function request()
    {
        try {
            $response = $this->getHttpClient(['verify' => false, 'timeout' => 3])->get($this->url, [
                'headers' => ['Authorization' => $this->apple->getAuth()->getAuthorization()]
            ]);
            if ($response->getStatusCode() != 200) {
                throw new SearchAdsException($response->getBody()->getContents(), $response->getStatusCode());
            }
            $data = json_decode($response->getBody()->getContents(), true);
            if (empty($data['data']['userId']) || empty($data['data']['parentOrgId'])) {
                throw new SearchAdsException($this->url . '接口数据解析失败');
            }
            $this->userId = $data['data']['userId'];
            $this->parentOrgId = $data['data']['parentOrgId'];
        } catch (\Throwable $t) {
            throw new SearchAdsException($t->getMessage(), $t->getCode());
        }
    }

    public function getUserId()
    {
        if (is_null($this->userId)) {
            $this->request();
        }
        return $this->userId;
    }

    public function getParentOrgId()
    {
        if (is_null($this->parentOrgId)) {
            $this->request();
        }
        return $this->parentOrgId;
    }

}