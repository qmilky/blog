<?php

namespace App\Listeners;

use App\Events\TestEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\WebSocket;
use Illuminate\Support\Facades\Log;
//添加implements ShouldQueue后会添加到job队列。
class TestEventListener implements ShouldQueue
//class TestEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TestEvent  $event
     * @return void
     */
    public function handle(TestEvent $event)
    {
        $datas=$event->data;
        Log::info('此处是listeners',[$datas]);
        $job = (new WebSocket($datas))->onQueue(config('queue.queue_default'));
        $res = dispatch($job);
        Log::info('发送返回数据',[$res]);
        //此处跳转无用的，需要在控制器中完成
//        if($res){
//            return back();
//            return redirect('vue');
//        };
    }
}
