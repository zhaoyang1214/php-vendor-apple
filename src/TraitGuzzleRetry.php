<?php


namespace Snow\Apple;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Snow\Technology\Technology;

trait TraitGuzzleRetry
{
    /** @var []Client */
    private $httpClient;

    private $httpMaxRetries = 2;

    /**
     * Notes: 设置http请求重试最大次数
     * @param int $httpMaxRetries
     * @return $this
     */
    public function setHttpMaxRetries(int $httpMaxRetries)
    {
        $this->httpMaxRetries = $httpMaxRetries;
        return $this;
    }

    /**
     * Notes: 获取http请求重试最大次数
     * @return int
     */
    public function getHttpMaxRetries()
    {
        return $this->httpMaxRetries;
    }

    /**
     * Notes：返回一个匿名函数, 匿名函数若返回false 表示不重试，反之则表示继续重试
     *
     * @return \Closure
     */
    protected function retryDecider()
    {
        return function ($retries, Request $request, Response $response = null, RequestException $exception = null) {
            if ($retries >= $this->getHttpMaxRetries()) {
                return false;
            }
            if (!is_null($exception)) {
                return true;
            }
            if ($response && $response->getStatusCode() >= 500) {
                return true;
            }
            return false;
        };
    }

    /**
     * Notes：重试间隔
     *
     * @return \Closure
     */
    protected function retryDelay()
    {
        return function ($numberOfRetries) {
            return 1000 * $numberOfRetries;
        };
    }

    /**
     * Notes: 获取http客户端
     * @param array $config
     * @param bool $share
     * @return Client
     */
    public function getHttpClient(array $config = [], $share = true): Client
    {
        $cf = md5(serialize($config));
        if ($share && isset($this->httpClient[$cf])) {
            return $this->httpClient[$cf];
        }
        $handlerStack = HandlerStack::create(new CurlHandler());
        $handlerStack->push(Middleware::retry($this->retryDecider(), $this->retryDelay()));
        $client = new Client(array_merge(['handler' => $handlerStack], $config));
        $share && $this->httpClient[$cf] = $client;
        return $client;
    }
}