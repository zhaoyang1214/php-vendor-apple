<?php


namespace Snow\Apple\Technology\SearchAds;


class SearchTermLevelReports extends SearchAds
{
    private $url = 'https://api.searchads.apple.com/api/v4/reports/campaigns/%d/searchterms';

    /**
     * Notes: Get Campaign-Level Reports
     * @param int $campaignId
     * @param array $reportingRequest
     * @param mixed ...$params
     * @return mixed|string
     * @throws SearchAdsException
     */
    public function execute($campaignId = null, $reportingRequest = [], ...$params)
    {
        return $this->parseResponse($this->quickClient()->post(sprintf($this->url, $campaignId), ['json' => $reportingRequest]));
    }
}