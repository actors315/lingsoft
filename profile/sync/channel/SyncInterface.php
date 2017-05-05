<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/5/4
 * Time: 20:50
 */

namespace lingyin\profile\sync\channel;


interface SyncInterface
{

    /**
     * 创建同步连接
     *
     * @return mixed
     */
    public function connect();

    /**
     * 同步消息
     *
     * @param array $message
     * @return mixed
     */
    public function syncMessage($message = []);

}