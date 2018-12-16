<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Log;
class WebSocket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
//            'user_ids' => $this->user_ids,
            'data' => $this->data,
        ];
        $this->request($data);
    }

    public  function request($data, $method = 'post')
    {
        $url = 'http://47.94.149.55:9505';
//        $url = config('saas.web_socket_url');
        Log::info('web_socket',[$url,__METHOD__]);
        $response = Curl::to($url)->withData($data)->$method();
        Log::info('web_socket',[$response,__METHOD__]);
        return $response;
    }
}
