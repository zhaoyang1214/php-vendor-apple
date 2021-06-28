<?php


namespace Snow\Apple\Technology;


interface AuthInterface
{
    public function getAuthorization(bool $force = false);
}