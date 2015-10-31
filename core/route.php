<?php
    
    function callHook()
    {
        global $url;
        global $default;
        
        $param = array();
        $urlArr = @explode("/", rtrim($url, "/"));
        $controller = @array_shift($urlArr);
        $action = @array_shift($urlArr);
        $param = $urlArr;
        
        if ($controller == "")
        {
            $controller = $default['controller'];
            $action = $default['action'];
        }
        
        if ($action == "")
        {
            $action = $default['action'];
        }
        
        $controllerName = ucfirst($controller).'Controller';
        $dispatch = new $controllerName($controller, $action);
        
        if (method_exists($dispatch, ucfirst($action)))
        {
            call_user_func_array(array($dispatch, ucfirst($action)), $param);
        }
        else
        {
            die('method not exitsts : ' . $controllerName . '->' . ucfirst($action));
        }
    }
    
    function __autoload($classname)
    {
        $file1 = ROOT . DS . 'core' . DS . strtolower($classname) . '.class.php';
        $file2 = ROOT . DS . 'controller' . DS . strtolower($classname) . '.php';
        $file3 = ROOT . DS . 'model' . DS . strtolower($classname) . '.php';
        if (file_exists($file1))
        {
            require_once($file1);
        }
        else if (file_exists($file2))
        {
            require_once($file2);
        }
        else if (file_exists($file3))
        {
            require_once($file3);
        }
        else
        {
            die('not found class : ' . $classname);
        }
    }
    
    
    callHook();
    