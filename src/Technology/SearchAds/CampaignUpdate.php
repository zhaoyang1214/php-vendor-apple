<?php


namespace Snow\Apple\Technology\SearchAds;


class CampaignUpdate extends SearchAds
{

    private $url = 'https://api.searchads.apple.com/api/v4/campaigns/%d';

    /**
     * Notes: Update a Campaign
     * @param int $campaignId
     * @param array $data
     * @param mixed ...$params
     * @return mixed
     * @throws SearchAdsException
     */
    public function execute($campaignId = null, $data = [], ...$params)
    {
        return $this->parseResponse($this->quickClient()->put(sprintf($this->url, $campaignId), ['json' => $data]));
    }
}