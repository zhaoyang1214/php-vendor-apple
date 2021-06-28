<?php


namespace Snow\Apple\Technology\SearchAds;


class CampaignDelete extends SearchAds
{
    private $url = 'https://api.searchads.apple.com/api/v4/campaigns/%d';

    /**
     * Notes: Delete a Campaign
     * @param int $campaignId
     * @param mixed ...$params
     * @return mixed
     * @throws SearchAdsException
     */
    public function execute($campaignId = null, ...$params)
    {
        return $this->parseResponse($this->quickClient()->delete(sprintf($this->url, $campaignId)));
    }
}