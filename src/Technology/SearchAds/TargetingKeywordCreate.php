<?php


namespace Snow\Apple\Technology\SearchAds;


class TargetingKeywordCreate extends SearchAds
{
    private $url = 'https://api.searchads.apple.com/api/v4/campaigns/%d/adgroups/%d/targetingkeywords/bulk';

    /**
     * Notes: Create Targeting Keywords
     * @param null $campaignId
     * @param null $adGroupId
     * @param array $data
     * @param mixed ...$params
     * @return mixed|string
     * @throws SearchAdsException
     */
    public function execute($campaignId = null, $adGroupId = null, $data = [], ...$params)
    {
        return $this->parseResponse($this->quickClient()->post(sprintf($this->url, $campaignId, $adGroupId), ['json' => $data]));
    }
}