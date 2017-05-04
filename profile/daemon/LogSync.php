<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/5/1
 * Time: 20:06
 */

namespace lingyin\profile\daemon;


class LogSync
{
    protected $message;
    private $begin;

    private $config = [];

    private $_adapter = 'Redis';
    private $_driver = null;

    private $cmd;
    private $args;
    private $file_pointer = 0;

    private $up_sync_second = 5;
    private $up_sync_memory = 2 * 1024 * 1024;

    /**
     * 初始化
     *
     * @param array $cfg
     * @return $this
     */
    public function handler(array $cfg = [])
    {
        $key = ['listen::', 'status::'];
        $opt = getopt('', $key);
        $this->cmd = 'listen';
        foreach ($key as $v) {
            $v = str_replace('::', '', $v);
            if (isset($opt[$v])) {
                $this->cmd = $v;
                $this->args = $opt[$v];
                break;
            }
        }

        isset($cfg['up_sync_second']) && $this->up_sync_memory = $cfg['up_sync_second'];
        isset($cfg['up_sync_memory']) && $this->up_sync_memory = $cfg['up_sync_memory'];

        if (isset($cfg['adapter']) && in_array($cfg['adapter'], ['Redis', 'ActiveMQ'])) {
            $this->_adapter = $cfg['adapter'];
            unset($cfg['adapter']);
        }

        isset($cfg['driver']) && $this->config = $cfg['driver'];

        $this->initDriver();
        return $this;
    }

    public function run()
    {
        $cmd = $this->cmd;
        $this->$cmd($this->args);
    }

    public function listen()
    {
        $this->begin = time();
        if ($this->args) {
            //读文件方式同步
            while (true) {
                if (!file_exists($this->args)) {
                    sleep(10);
                    continue;
                }

                $handle = fopen($this->args, 'r');
                if ($handle) {
                    if (fseek($handle, $this->file_pointer) === -1) {
                        rewind($handle);
                    }
                    while ($line = trim(fgets($handle))) {
                        $this->message[] = $line;
                    }
                    $this->file_pointer = ftell($handle);
                    $this->upAgent();
                    fclose($handle);
                    sleep(1);
                } else {
                    $this->file_pointer = 0;
                }
            }
        } else {

        }
    }

    private function initDriver()
    {
        $class_name = "lingyin\\profile\\daemon\\channel\\{$this->_adapter}";
        $this->_driver = new $class_name($this->config);
    }

    /**
     * 日志同步逻辑
     */
    private function upAgent()
    {
        if ((memory_get_usage() > $this->up_sync_memory) or ($this->begin + $this->up_sync_second < time())) {
            if ($result = $this->_driver->syncMessage($this->message)) {
                $this->begin = time();
                $this->message = [];
            }
        }
    }
}