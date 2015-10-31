<?php

class Controller
{
    protected $controller;
    protected $action;
    
    public function __construct($controller, $action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }
    
    public function Index()
    {
        echo "Base Index.";
    }
}