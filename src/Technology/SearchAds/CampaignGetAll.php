<?php


namespace Snow\Apple\Technology\SearchAds;


class CampaignGetAll extends SearchAds
{
    const OPT_LIMIT = 'limit';

    private $url = 'https://api.searchads.apple.com/api/v4/campaigns?limit=%d&offset=%d';

    /**
     * Notes: Get all Campaigns
     * @param int $offset
     * @param int|null $limit
     * @param mixed ...$params
     * @return mixed
     * @throws SearchAdsException
     */
    public function execute($offset = 0, $limit = null, ...$params)
    {
        $limit = $this->getOption(self::OPT_LIMIT, $limit) ?: 20;
        return $this->parseResponse($this->quickClient()->get(sprintf($this->url, $limit, $offset)));
    }
}