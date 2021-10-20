<?php

namespace App\Jobs;

use App\Events\FileCreated;
use App\Services\HttpRequest;
use App\Services\JsonType;
use App\Services\XmlType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $endpoints = $config[$environment]['endpoints'] ?? [];
        foreach ($endpoints as $url) {
            if($config['payload_type'] == 'xml') {
                $type = new XmlType(['FileUrl' => $file->file_path]);
            }else {
                $type = new JsonType(['file_url' => $file->file_path]);
            }
            $service = new HttpRequest($type, $url);
            $service->post();
        }
    }
}
