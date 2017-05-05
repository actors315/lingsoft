<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/5/4
 * Time: 20:46
 */

namespace lingyin\profile\sync\channel;


class ActiveMQ implements SyncInterface
{

    /**
     * @return mixed
     */
    public function connect()
    {

    }

    /**
     * @param array $message
     * @return mixed
     */
    public function syncMessage($message = [])
    {

    }
}