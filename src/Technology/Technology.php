<?php


namespace Snow\Apple\Technology;


use Snow\Apple\AppleInterface;
use Snow\Apple\TraitGuzzleRetry;
use Snow\Apple\Technology\SearchAds\MeDetail;

abstract class Technology implements TechnologyInterface
{

    use TraitGuzzleRetry;

    private $apple;

    private $option;

    public function __construct(array $option = [])
    {
        $this->option = $option;
    }

    public function setApple(AppleInterface $apple)
    {
        $this->apple = $apple;
    }

    public function getApple(): AppleInterface
    {
        return $this->apple;
    }

    public function getOption(string $key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->option;
        }
        $option = $this->option;
        if (is_array($option) && isset($option[$key])) {
            $value = $option[$key];
        } elseif (is_object($option) && isset($option->{$key})) {
            $value = $option->{$key};
        }
        if (!isset($value)) {
            $key = trim($key, '.');
            if (strpos($key, '.')) {
                $keyArr = explode('.', $key);
                $value = $option;
                foreach ($keyArr as $v) {
                    if (isset($value[$v])) {
                        $value = $value[$v];
                    } elseif (isset($value->{$v})) {
                        $value = $value->{$v};
                    } else {
                        $value = null;
                        break;
                    }
                }
            }
        }
        return $value ?? ($default ?? null);
    }

    public function setOption(array $option)
    {
        $this->option = array_merge($this->option, $option);
    }

    abstract public function execute(...$params);
}