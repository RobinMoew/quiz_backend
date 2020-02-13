<?php

namespace App\Services;


class SessionUtility
{
    public $id;
    public $sessionInstance;

    function __construct($session, $request)
    {
        $sessionId = $request->get("sessionId");

        if (!empty($sessionId)) {
            $session->setId($sessionId);
        } else {
            $session->start();
        }

        $this->id = $session->getId();
        $this->sessionInstance = $session;
    }

    public function get($key)
    {
        return $this->sessionInstance->get($key);
    }

    public function set($key, $value)
    {
        return $this->sessionInstance->set($key, $value);
    }

    public function close()
    {
        $this->sessionInstance->invalidate();
    }

    public function getId()
    {
        return $this->id;
    }
}
