<?php


namespace Snow\Apple\Technology\SearchAds;


class CampaignNegativeKeywordsDelete extends SearchAds
{

    private $url = 'https://api.searchads.apple.com/api/v4/campaigns/%d/negativekeywords/delete/bulk';

    /**
     * Notes: Delete Campaign Negative Keywords
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