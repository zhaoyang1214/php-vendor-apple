<?php


namespace Snow\Apple\Technology\SearchAds;


class CampaignNegativeKeywordsCreate extends SearchAds
{

    private $url = 'https://api.searchads.apple.com/api/v4/campaigns/%d/negativekeywords/bulk';

    /**
     * Notes: Create Campaign Negative Keywords
     * @param int $campaignId
     * @param array $data
     * @param mixed ...$params
     * @return mixed|string
     * @throws SearchAdsException
     */
    public function execute($campaignId = null, $data = [], ...$params)
    {
        return $this->parseResponse($this->quickClient()->post(sprintf($this->url, $campaignId), ['json' => $data]));
    }
}