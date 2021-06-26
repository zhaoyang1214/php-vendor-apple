<?php


namespace Snow\Apple;


use Snow\Technology\AuthInterface;

interface AppleInterface
{
    public function getJwt(int $expirationTimestamp = null, bool $force = false): string;

    public function getClientId(): string;

    public function setAuth(AuthInterface $auth);

    public function getAuth(): AuthInterface;

    public function technology(string $technology, array $option = []);

    public function storage(string $key, $value = null);

    public function execute(string $technology, ...$params);
}