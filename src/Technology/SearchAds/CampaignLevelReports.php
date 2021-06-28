<?php


namespace Snow\Apple\Technology\SearchAds;


class CampaignLevelReports extends SearchAds
{
    private $url = 'https://api.searchads.apple.com/api/v4/reports/campaigns';

    /**
     * Notes: Get Campaign-Level Reports
     * @param array $reportingRequest
     * @param mixed ...$params
     * @return mixed|string
     * @throws SearchAdsException
     */
    public function execute($reportingRequest = [], ...$params)
    {
        return $this->parseResponse($this->quickClient()->post($this->url, ['json' => $reportingRequest]));
    }
}