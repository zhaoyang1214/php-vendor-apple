<?php


namespace Snow\Apple\Technology\SearchAds;


class CampaignGetOne extends SearchAds
{
    private $url = 'https://api.searchads.apple.com/api/v4/campaigns/%d';

    /**
     * Notes: Get a Campaign
     * @param int $campaignId
     * @param mixed ...$params
     * @return mixed
     * @throws SearchAdsException
     */
    public function execute($campaignId = null, ...$params)
    {
        return $this->parseResponse($this->quickClient()->get(sprintf($this->url, $campaignId)));
    }
}