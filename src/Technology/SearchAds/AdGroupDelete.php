<?php


namespace Snow\Apple\Technology\SearchAds;


class AdGroupDelete extends SearchAds
{
    private $url = 'https://api.searchads.apple.com/api/v4/campaigns/%d/adgroups/%d';

    /**
     * Notes: Delete an AdGroup
     * @param int $campaignId
     * @param int $adGroupId
     * @param mixed ...$params
     * @return mixed
     * @throws SearchAdsException
     */
    public function execute($campaignId = null, $adGroupId = null, ...$params)
    {
        return $this->parseResponse($this->quickClient()->delete(sprintf($this->url, $campaignId, $adGroupId)));
    }
}