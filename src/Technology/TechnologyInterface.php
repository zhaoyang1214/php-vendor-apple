<?php

namespace Snow\Technology;

use Snow\Apple\AppleInterface;

interface TechnologyInterface
{
    public function setApple(AppleInterface $apple);

    public function getApple(): AppleInterface;

    public function setOption(array $option);

    public function getOption(string $key = null, $default = null);

    public function execute(...$params);
}