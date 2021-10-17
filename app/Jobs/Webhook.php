<?php

namespace App\Jobs;

use App\Events\FileCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
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
    public function typeXml($file){

        $path = storage_path('app/public/archive/' . $file->name);
       return '
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <FileUrl>
            '. $path .'
        </FileUrl>
    </Body>
</Envelope>
';
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FileCreated $event)
    {
        $file = $event->file;

        $config = require config_path('webhook.php');

        $environment = env('APP_ENV');

        if ($environment == 'local' || $environment == 'production'){

            $type = $config[$environment]['type'];

            if ($type == 'json'){

                $headers = [

                    'Content-Type' => 'text/json; charset=UTF8'

                ];
                $body = storage_path('app/public/archive/' . $file->name);

            }elseif ($type == 'xml') {

                $headers = [

                    'Content-Type' => 'text/xml; charset=UTF8'

                ];
                $body = $this->typeXml($file);
            }
            $endpoints = $config[$environment]['endpoints'];

            foreach ($endpoints as $url){

            Http::withHeaders($headers)->post($url, [

                'body' => $body
            ]);
        }
        }


    }
}
