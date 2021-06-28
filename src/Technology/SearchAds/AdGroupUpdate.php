<?php


namespace Snow\Apple\Technology\SearchAds;


class AdGroupUpdate extends SearchAds
{
    private $url = 'https://api.searchads.apple.com/api/v4/campaigns/%d/adgroups/%d';

    /**
     * Notes: Update an Ad Group
     * @param int $campaignId
     * @param int $adGroupId
     * @param array $data
     * @param mixed ...$params
     * @return mixed|string
     * @throws SearchAdsException
     */
    public function execute($campaignId = null, $adGroupId = null, $data = [], ...$params)
    {
        return $this->parseResponse($this->quickClient()->put(sprintf($this->url, $campaignId, $adGroupId), ['json' => $data]));
    }
}