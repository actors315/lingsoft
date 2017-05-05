<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/5/4
 * Time: 21:09
 */

namespace lingyin\profile\sync\channel;


class Http implements SyncInterface
{
    private $instance = null;

    private $url = 'http://profile.lingyin99.com/api/import';

    public function __construct($config = [])
    {
        isset($config['url']) && $this->url = $config['url'];
    }

    /**
     * @return mixed
     */
    public function connect()
    {
        try {
            $this->instance = curl_init($this->url);
        } catch (\Exception $e) {
            $this->connect();
        }
    }

    /**
     * @param array $message
     * @return mixed
     */
    public function syncMessage($message = [])
    {
        if (empty($message)) return false;

        try {
            $this->connect();
        } catch (\Exception $e) {

        }

        try {
            curl_setopt_array($this->instance, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => ['data' => gzcompress(json_encode($message))],
                CURLOPT_TIMEOUT => 5,
                CURLOPT_CONNECTTIMEOUT => 3,
            ]);
            curl_exec($this->instance);
            curl_close($this->instance);
        } catch (\Exception $e) {

            return false;
        }

        return true;
    }
}