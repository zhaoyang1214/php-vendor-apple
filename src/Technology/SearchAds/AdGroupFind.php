<?php

declare(strict_types=1);

namespace Snow\Apple\Technology\SearchAds;


class AdGroupFind extends SearchAds
{
    private $url = 'https://api.searchads.apple.com/api/v4/campaigns/%d/adgroups/find';

    /**
     * Notes: Fetches campaigns with selector operators.
     * @param int $Selector
     * @param array $Selector
     * @param mixed ...$params
     * @return mixed|string
     * @throws SearchAdsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute($campaignId = null, $Selector = [], ...$params)
    {
        return $this->parseResponse($this->quickClient()->post(sprintf($this->url, $campaignId), ['json' => $Selector]));
    }
}