<?php

namespace App\Services;

class JsonType implements WebhookInterface
{
    /**
     * @var array
     */
    public $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return ['Content-Type' => 'application/json; charset=UTF8'];
    }

    /**
     * @return array
     */
    public function getData(): array
    {

        return $this->prepare($this->data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function prepare(array $data): array
    {
        return $data;
    }
}