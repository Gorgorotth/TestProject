<?php

namespace App\Services;

interface WebhookInterface
{
    public function __construct(array $data);

    public function prepare(array $data): array;

    public function getHeaders(): array;

    public function getData(): array;
}
