<?php
namespace App\Console\Commands;

//use App\Message;
//use App\Room;
//use App\RoomJoin;
//use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
//use phpDocumentor\Reflection\Types\Null_;
class Swoole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'swoole:action {action}';
    protected $signature = 'swoole:action {action}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'swoole command';
    //作用在于 $this->server->on('request');
    protected $server;
    /**
     * @var Message
     */
//    protected $message;
    /**
     * @var User
     */
//    protected $user;
    /**
     * @var Room
     */
//    protected $room;
    /**
     * Swoole constructor.
     * @param Message $message
     * @param User $user
     * @param RoomJoin $room
     */
    public function __construct()
    {
        parent::__construct();
//        $this->message = $message;
//        $this->user = $user;
//        $this->room = $room;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');
        switch ($action) {
            case 'start':
                $this->start();
                break;
            case 'stop':
                $this->stop();
                break;
            case 'restart':
                $this->restart();
                break;
        }
    }
    /**
     * 开启websocket
     */
    private function start()
    {

        echo '建立链接了吗？？？';
//        $server = new \swoole_websocket_server("ws://qymblog.com", 9505); //若此处为‘0.0.0.0’，9505 则接受所有ip端口号为9505的消息
        $this->server = $server = new \swoole_websocket_server("0.0.0.0", 9505); //若此处为‘0.0.0.0’，9505 则接受所有ip端口号为9505的消息
//       var_dump($server);
        $this->server->on('open', function ( $server, $request) {
            echo "建立链接: {$request->fd}\n";
            Log::info('建立链接',['hhhh']);
            Redis::sadd('blog',$request->fd);
        });
        $this->server->on('message', function ($server, $frame) {
            $data = $frame->data;
            echo "发送的消息: {$data}\n";
            foreach($this->server->connections as $fd) {
                Log::info('链接时',[$fd]);
                //实现推送，关键是此步$server->push($fd, $data);

                $this->server->push($fd, $data);
            }
        });

        $this->server->on('request', function ($request,$response) {
            $postData = $request->post;
            Log::notice('请求参数', [$postData, __METHOD__]);
//            $userIds = isset($postData['user_ids']) ? $postData['user_ids'] : [];
            $data = isset($postData['data']) ? $postData['data'] : [];
//            Log::notice('$userIds', [$userIds, __METHOD__]);
//            $userIdsPre = [];
//            foreach ($userIds as &$v) {
//                $v = hashidsDecode($v);
//                $userIdsPre[] = $this->prefix . $v;
//            }
//            Log::notice('$userIdsPre', [$userIdsPre, __METHOD__]);
//
//            $userFds = Redis::sunion($userIdsPre);
//            Log::notice('$userFds', [$userFds, __METHOD__]);
//            $activeFds = [];
//            //将存活的fds 单独取出，用于和用户fds qu
//            foreach ($this->server->connections as $fd) {
//                $activeFds[] = $fd;
//            }
//            Log::notice('$activeFds', [$activeFds, __METHOD__]);
////            计算数组的交集array_intersect（）
//            $pushFds = array_intersect($userFds,$activeFds);
            $fds = Redis::sunion('blog');
            Log::notice('redis中取出链接时的fd',[$fds]);
            $ff = [];
            foreach ($this->server->connections as $fdd){
//                Log::info('是否有效',[$this->server->connection_info['websocket_status']]);
//                if($this->server->connection_info['websocket_status']){
               $ff[] =$fdd;

            }
            Log::info('活着的fd',[$ff]);
            $ffdd = array_intersect($fds,$ff);
            foreach($ffdd as $fd){
                
                Log::info('发送时的fd',[$fd]);
                /*此处$data无需json_encode(),laravel中会自动转换*/
                $this->server->push($fd,$data);

            }
            //不可放在遍历内
            $response->end("success成功啦！！！");

        });


        $this->server->on('close', function ($ser, $fd) {
            echo "client {$fd} closed\n";
        });
        $this->server->start();




//        $ws = new \swoole_websocket_server(config('swoole.host'), config('swoole.port'));
//        $ws->on('open', function ($ws, $request) {
//// todo something
//        });
////监听WebSocket消息事件
//        $ws->on('message', function ($ws, $frame) {
//            $data = json_decode($frame->data, true);
//            switch ($data['type']) {
//                case 'connect':
//                    Redis::zadd("room:{$data['room_id']}", intval($data['user_id']), $frame->fd);
//// 同时使用hash标识fd在哪个房间
//                    Redis::hset('room', $frame->fd, $data['room_id']);
//// 加入房间提示
//// 获取这个房间的用户总数
//// +1 是代表群主
//                    $memberInfo = [
//                        'online' => Redis::zcard("room:{$data['room_id']}"),
//                        'all' => $this->room->where(['room_id' => $data['room_id'], 'status' => 0])->count() + 1
//                    ];
//                    $this->sendAll($ws, $data['room_id'], $data['user_id'], $memberInfo,
//                        'join');
//                    break;
//                case 'message':
//// 入库
//                    $message = [
//                        'content' => $data['message'],
//                        'user_id' => $data['user_id'],
//                        'room_id' => $data['room_id'],
//                        'created_at' => time()
//                    ];
//// $this->message->fill($message)->save();
//                    Message::create($message);
//                    $this->sendAll($ws, $data['room_id'], $data['user_id'], $data['message']);
//                    break;
//                case 'close':
//// 移除
//                    Redis::zrem("room:{$data['room_id']}", $frame->fd);
//                    break;
//            }
//        });
//        $ws->on('close', function ($ws, $fd) {
//// 获取fd所对应的房间号
//            $room_id = Redis::hget('room', $fd);
//            $user_id = intval(Redis::zscore("room:{$room_id}", $fd));
//            Redis::zrem("room:{$room_id}", $fd);
//            $memberInfo = [
//                'online' => Redis::zcard("room:{$room_id}"),
//                'all' => $this->room->where(['room_id' => $room_id, 'status' => 0])->count() + 1
//            ];
//            $this->sendAll($ws, $room_id, $user_id, $memberInfo,
//                'leave');
//        });
//        $ws->start();
    }
    /**
     * 停止websocket
     */
    private function stop()
    {
    }
    /**
     * 重启
     */
    private function restart()
    {
    }
    /**
     * @param $ws
     * @param $room_id
     * @param string $user_id
     * @param string $message
     * @param string $type
     * @return bool
     */
    private function sendAll($ws, $room_id, $user_id = null, $message = null, $type = 'message')
    {
        $user = $this->user->find($user_id, ['id', 'name']);
        if (!$user) {
            return false;
        }
        $message = json_encode([
            'message' => is_string($message) ? nl2br($message) : $message,
            'type' => $type,
            'user' => $user
        ]);
        $members = Redis::zrange("room:{$room_id}" , 0 , -1);
        foreach ($members as $fd) {
            $ws->push($fd, $message);
        }
    }
}