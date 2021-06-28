<?php

namespace Snow\Apple\Tests\Technology\SearchAds;

use Snow\Apple\Apple;
use PHPUnit\Framework\TestCase;
use Snow\Apple\Technology\SearchAds\CampaignGetAll;
use Snow\Apple\Tests\Config;

class CampaignGetAllTest extends TestCase
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

        $data1 = $app->execute(CampaignGetAll::class);
        $data2 = $app->execute(CampaignGetAll::class, 0, 1);
        $data3 = $app->execute(CampaignGetAll::class, 1, 1);
        $this->assertEquals($data1['data'][0], $data2['data'][0]);
        $this->assertEquals($data1['data'][1], $data3['data'][0]);
    }
}
