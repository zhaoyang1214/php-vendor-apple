<?php


namespace Snow\Technology;


interface AuthInterface
{
    public function getAuthorization(bool $force = false);
}