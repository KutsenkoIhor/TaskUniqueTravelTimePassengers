<?php

interface HandlerInterface
{
    public function set(int $idDriver, int $timePickup, int $timeDropOff): void;
    public function run(): void;
    public function get(): array;
}