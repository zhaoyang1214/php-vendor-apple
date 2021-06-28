<?php

namespace Snow\Apple\Technology;

use Snow\Apple\AppleInterface;

interface TechnologyInterface
{
    /**
     * Notes: 设置Apple基础服务
     * @param AppleInterface $apple
     * @return mixed
     */
    public function setApple(AppleInterface $apple);

    /**
     * Notes: 获取Apple基础服务
     * @return AppleInterface
     */
    public function getApple(): AppleInterface;

    /**
     * Notes: 设置选项
     * @param array $option
     * @return mixed
     */
    public function setOption(array $option);

    /**
     * Notes: 获取选项
     * @param string|null $key
     * @param null $default
     * @return mixed
     */
    public function getOption(string $key = null, $default = null);

    /**
     * Notes: 执行服务
     * @param mixed ...$params
     * @return mixed
     */
    public function execute(...$params);
}