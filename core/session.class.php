<?php

class Session
{
    private static $session = null;
    private $sessionId = 0;
    
    public static function GetSession()
    {
        if (self::$session == null)
        {
            self::$session = new Session();
        }
        return self::$session;
    }
    
    public function __construct()
    {
        $this->sessionId = session_id();
    }
    
    public function GetSessionId()
    {
        return $this->sessionId;
    }
    
    public function destroy()
    {
        session_destroy();
    }
    
    public function UnSet($key)
    {
        unset($_SESSION[$key]);
        if (isset($_SESSION[$key]))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function GetData($key)
    {
        return $_SESSION[$key];
    }
    
    public function SetData($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}