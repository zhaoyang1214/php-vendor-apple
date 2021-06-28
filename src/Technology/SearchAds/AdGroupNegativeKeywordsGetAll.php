<?php


namespace Snow\Apple\Technology\SearchAds;


class AdGroupNegativeKeywordsGetAll extends SearchAds
{
    const OPT_LIMIT = 'limit';

    private $url = 'https://api.searchads.apple.com/api/v4/campaigns/%d/adgroups/%d/negativekeywords?limit=%d&offset=%d';

    /**
     * Notes: Get all Ad Group Negative Keywords
     * @param int $campaignId
     * @param int $adGroupId
     * @param int $offset
     * @param int|null $limit
     * @param mixed ...$params
     * @return mixed|string
     * @throws SearchAdsException
     */
    public function execute($campaignId = null, $adGroupId = null, $offset = 0, $limit = null, ...$params)
    {
        $limit = $this->getOption(self::OPT_LIMIT, $limit) ?: 20;
        return $this->parseResponse($this->quickClient()->get(sprintf($this->url, $campaignId, $adGroupId, $limit, $offset)));    }
}