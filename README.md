# php-vendor-apple
这是一个Apple SDK.

## 基本使用：
***请求数据与Apple Search Ads各接口数据一致***

```php
use Snow\Apple\Apple;
use Snow\Apple\Technology\SearchAds\CampaignGetAll;
use Snow\Apple\Technology\SearchAds\AdGroupLevelReports;

$privateKey = 'xxx';
$publicKey = 'xxxx';
$clientId = 'xxx';
$teamId = 'xxxx';
$keyId = 'xxx';
$audience = 'xxx';
$alg = 'ES256';

$app = new Apple($privateKey, $publicKey, $clientId, $teamId, $keyId, $audience, $alg);

// 获取数据，分页默认limit 10, offset 0
$data = $app->execute(CampaignGetAll::class);

// 分页
$data = $app->execute(CampaignGetAll::class, 0, 1000);

$campaignId = 100000;
$data = $app->execute(AdGroupLevelReports::class, $campaignId, [
            'selector' => [
                'orderBy' => [
                    [
                        'field' => 'installs',
                        'sortOrder' => 'ASCENDING',
                    ]
                ]
            ],
            'granularity' => 'DAILY',
            'startTime' => '2021-06-22',
            'endTime' => '2021-06-28',
        ]);
```