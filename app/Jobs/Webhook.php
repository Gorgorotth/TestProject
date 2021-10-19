<?php

namespace App\Jobs;

use App\Events\FileCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class Webhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FileCreated $event)
    {
        $file = $event->file;
        $config = config('webhook');
        $environment = env('APP_ENV');
        if ($environment == 'local' || $environment == 'production') {
            $type = $config['payload_type'];
            $endpoints = $config[$environment]['endpoints'];
            if ($type == 'xml') {
                $headers = [
                    'Content-Type' => 'text/xml; charset=UTF8'
                ];
                $body = $this->typeXml($file);
                foreach ($endpoints as $url) {
                    Http::withHeaders($headers)->post($url, [
                        'body' => $body
                    ]);
                }
            } elseif ($type == 'json') {
                $headers = [
                    'Content-Type' => 'application/json; charset=UTF8'
                ];
                $body = $file->file_path;
                foreach ($endpoints as $url) {
                    Http::withHeaders($headers)->post($url, [
                        'file_url' => $body
                    ]);
                }
            }
        }
    }

    /**
     * @param $file
     * @return string
     */
    public function typeXml($file): string
    {
        $path = $file->file_path;
        return '
                <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                    <Body>
                        <FileUrl>
                            ' . $path . '
                        </FileUrl>
                    </Body>
                </Envelope>
        ';
    }
}
