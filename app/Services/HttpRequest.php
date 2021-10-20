<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HttpRequest
{
    /**
     * @var WebhookInterface
     */
    public $strategy;
    /**
     * @var
     */
    public $url;

    /**
     * @param WebhookInterface $strategy
     * @param $url
     */
    public function __construct(WebhookInterface $strategy, $url)
    {
        $this->strategy = $strategy;
        $this->url = $url;
    }

    /**
     *
     */
    public function post(): void
    {
        $headers = $this->strategy->getHeaders();
        Http::withHeaders($headers)->post($this->url, $this->strategy->getData());
    }
}