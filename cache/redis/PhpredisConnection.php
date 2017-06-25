<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/6/25
 * Time: 10:24
 */

namespace lingyin\cache\redis;


class PhpredisConnection extends Connection
{

    public $persistent = false;

    /**
     * @param $name
     * @param array $params
     * @return mixed
     */
    function executeCommand($name, $params = [])
    {
        $this->open();

        return call_user_func_array([$this->_socket, $name], $params);
    }

    /**
     * @return mixed
     */
    function open()
    {
        if ($this->_socket !== false) {
            return;
        }

        $this->_socket = new \Redis();
        $func = $this->persistent ? 'pconnect' : 'connect';
        $this->_socket->$func($this->hostname, $this->port, $this->timeout);
        if ($this->password !== null) {
            $this->executeCommand('AUTH', [$this->password]);
        }
        $this->executeCommand('SELECT', [$this->database]);
    }
}