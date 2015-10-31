<?php

class UserModel
{
    private $_username;
    private $_password;
    
    public function __construct()
    {
        $this->_username = 'wudics';
        $this->_password = '7758258';
    }
    
    public function getUserName()
    {
        return $this->_username;
    }
    
    public function getPassWord()
    {
        return $this->_password;
    }
}