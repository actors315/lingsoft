<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/5/2
 * Time: 22:19
 */

namespace lingyin\profile\daemon\channel;


class Redis implements SyncInterface
{
    private $instance = null;

    private $config = [];

    private $queue = 'profile:log';

    /**
     * Redis constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = $config + [
                'host' => '115.29.49.123',
                'port' => '6380',
                'auth' => 'profileLogStash',
                'timeout' => 60
            ];

        $this->connect();
    }

    /**
     * 创建redis长连接
     */
    public function connect()
    {
        try {
            $this->instance = new \Redis();
            $this->instance->pconnect($this->config['host'], $this->config['port'], $this->config['timeout']);
            if (!empty($this->config['auth'])) $this->instance->auth($this->config['auth']);
        } catch (\Exception $e) {

        }
    }

    public function syncMessage($message)
    {
        if (empty($message)) return false;

        try {
            $this->instance->ping();
        } catch (\Exception $e) {
            $this->connect();
        }

        try {
            $pipe = $this->instance->multi(\Redis::PIPELINE);
            foreach ($message as $pack) {
                $pipe->lPush($this->queue, gzcompress($pack));
            }
            $pipe->exec();
        } catch (\Exception $e) {

            return false;
        }

        return true;
    }
}