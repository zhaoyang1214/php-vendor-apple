<?php

declare(strict_types=1);

namespace Snow\Apple\Technology\SearchAds;


class CampaignCreate extends SearchAds
{

    private $url = 'https://api.searchads.apple.com/api/v4/campaigns';

    /**
     * Notes: Creates a campaign to promote an app
     * @param array $campaign
     * @param mixed ...$params
     * @return mixed|string
     * @throws SearchAdsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute($campaign = [], ...$params)
    {
        return $this->parseResponse($this->quickClient()->post($this->url, ['json' => $campaign]));
    }
}