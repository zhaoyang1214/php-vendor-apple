<?php

namespace Snow\Apple\Tests\Technology\SearchAds;

use Snow\Apple\Apple;
use Snow\Apple\Technology\SearchAds\CampaignGetOne;
use Snow\Apple\Technology\SearchAds\CampaignUpdate;
use PHPUnit\Framework\TestCase;
use Snow\Apple\Tests\Config;

class CampaignUpdateTest extends TestCase
{

    public function testExecute()
    {
        $app = new Apple(
            Config::PRIVATE_KEY,
            Config::PUBLIC_KEY,
            Config::CLIENT_ID,
            Config::TEAM_ID,
            Config::KEY_ID,
            Config::AUDIENCE,
            Config::ALG
        );
        $data = $app->execute(CampaignGetOne::class, Config::CAMPAIGN_ID);
        $campaign = $data['data'];
        unset($campaign['modificationTime']);
        $updateData = [
            'campaign' => [
                'dailyBudgetAmount' => [
                    'currency' => 'USD',
                    'amount' => '0.02',
                ],
            ],
        ];
        $app->execute(CampaignUpdate::class, Config::CAMPAIGN_ID, $updateData);
        $data2 = $app->execute(CampaignGetOne::class, Config::CAMPAIGN_ID);
        unset($data2['data']['modificationTime']);
        $this->assertEquals(array_merge($campaign, $updateData['campaign']), $data2['data']);
    }
}
