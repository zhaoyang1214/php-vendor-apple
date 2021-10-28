<?php

declare(strict_types=1);

namespace Snow\Apple\Technology\SearchAds;


class CampaignFind extends SearchAds
{
    private $url = 'https://api.searchads.apple.com/api/v4/campaigns/find';

    /**
     * Notes: Fetches campaigns with selector operators.
     * @param array $Selector
     * @param mixed ...$params
     * @return mixed|string
     * @throws SearchAdsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute($Selector = null, ...$params)
    {
        return $this->parseResponse($this->quickClient()->post($this->url, ['json' => $Selector]));
    }
}