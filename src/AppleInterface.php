<?php


namespace Snow\Apple;


use Snow\Apple\Technology\AuthInterface;

interface AppleInterface
{
    public function getJwt(int $expirationTimestamp = null, bool $force = false): string;

    public function getClientId(): string;

    /**
     * Notes: 设置鉴权
     * @param AuthInterface $auth
     * @return mixed
     */
    public function setAuth(AuthInterface $auth);

    /**
     * Notes: 获取鉴权
     * @return AuthInterface
     */
    public function getAuth(): AuthInterface;

    /**
     * Notes: 注册ASA服务
     * @param string $technology
     * @param array $option
     * @return mixed
     */
    public function technology(string $technology, array $option = []);

    /**
     * Notes: 存取全局数据
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function storage(string $key, $value = null);

    /**
     * Notes: 快速执行ASA服务
     * @param string $technology
     * @param mixed ...$params
     * @return mixed
     */
    public function execute(string $technology, ...$params);
}