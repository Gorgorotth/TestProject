<?php

namespace App\Services;

use Spatie\ArrayToXml\ArrayToXml;

class XmlType implements WebhookInterface
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
        return ['Content-Type' => 'text/xml; charset=UTF8'];
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
        return $this->toXml($data);
    }

    /**
     * @param array $data
     * @return array
     */
    private function toXml(array $data): array
    {
        $xml = [
            'rootElementName' => 'Envelope',
            '_attributes' => [
                'xmlns' => "http://schemas.xmlsoap.org/soap/envelope/",
                'type' => 'string',
            ],
        ];
        return ['body' => ArrayToXml::convert($data, $xml)];
    }
}