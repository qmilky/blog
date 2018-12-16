<?php
namespace App\Services\Vendor;

use Illuminate\Support\Facades\Log;

class Sequence
{
    const EPOCH = 1000000;

    const TIME_BITS  = 41;
    const NODE_BITS  = 10;
    const COUNT_BITS = 10;

    private $node = 0;

    private $ttl = 10;

    public function __construct($node)
    {
        $max = $this->max(self::NODE_BITS);

        if (is_int($node) === false || $node > $max || $node < 0) {
            throw new \InvalidArgumentException('node');
        }
        $this->node = $node;
    }

    public function generate($time = null)
    {
        /*所有表中的主键id生成器，和app/Providers/AppServiceProvider.php中的boot（）有关,模型中use SequenceTrait;则启动，否则不启动*/
        return time();
        if ($time === null) {
            $time = (int) (microtime(true) * 1000);
        }

        return ($this->time($time) << (self::NODE_BITS + self::COUNT_BITS)) |
               ($this->node << self::COUNT_BITS) |
               ($this->count($time));
    }

    public function generateOrderNo()
    {
        return date('ymdHis', time()) . random_int(100000, 999999);
    }

    public function restore($id)
    {
        $binary = decbin($id);

        $position = -(self::NODE_BITS + self::COUNT_BITS);

        return [
            'time'  => bindec(substr($binary, 0, $position)) + self::EPOCH,
            'node'  => bindec(substr($binary, $position, -self::COUNT_BITS)),
            'count' => bindec(substr($binary, -self::COUNT_BITS)),
        ];
    }

    public function setTTL($ttl)
    {
        $this->ttl = $ttl;
    }

    private function time($time)
    {
        $time -= self::EPOCH;

        $max = $this->max(self::TIME_BITS);

        Log::info($max);
        Log::info($time);
        if (is_int($time) === false || $time > $max || $time < 0) {
//            throw new \InvalidArgumentException('time');
        }

        return $time;
    }

    private function count($time)
    {
        $key = "seq:count:" . ($time % ($this->ttl * 1000));

        if (extension_loaded('shmcache')) {
            $shm = new \ShmCache("/etc/libshmcache.conf");
            while (!$count = $shm->incr($key, mt_rand(0, 9), $this->ttl)) {
            }
        } else {
            while (!$count = apcu_inc($key)) {
                apcu_add($key, mt_rand(0, 9), $this->ttl);
            }
        }

        $max = $this->max(self::COUNT_BITS);

        if ($count > $max) {
            throw new \UnexpectedValueException('count');
        }

        return $count;
    }

    private function max($bits)
    {
        return -1 ^ (-1 << $bits);
    }
}
