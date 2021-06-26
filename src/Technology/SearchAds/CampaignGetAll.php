<?php


namespace Snow\Technology\SearchAds;


class CampaignGetAll extends SearchAds
{
    private $url = 'https://api.searchads.apple.com/api/v4/campaigns';

    public function execute($offset = 0, $limit = 20, ...$params)
    {
        try {
            $url = sprintf("%s?limit=%s&offset=%s", $this->url, $limit, $offset);
            $response = $this->quickClient()->get($url);
            if ($response->getStatusCode() != 200) {
                throw new SearchAdsException($response->getBody()->getContents(), $response->getStatusCode());
            }
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Throwable $t) {
            throw new SearchAdsException($t->getMessage(), $t->getCode());
        }
    }
}