<?php


namespace Snow\Technology\SearchAds;


use Snow\Technology\Technology;

abstract class SearchAds extends Technology implements SearchAdsInterface
{
    public function init()
    {
        $this->getApple()->storage(MeDetail::class, new MeDetail($this->getApple()));
    }

    protected function quickClient()
    {
        return $this->getHttpClient([
            'verify' => $this->getOption('verify', false),
            'timeout' => $this->getOption('timeout', 3),
            'headers' => [
                'Authorization' => $this->getApple()->getAuth()->getAuthorization(),
                'X-AP-Context' => 'orgId=' . $this->getApple()->storage(MeDetail::class)->getParentOrgId(),
            ],
        ]);
    }
}