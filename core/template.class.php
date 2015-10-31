<?php

class Template
{
    private static $template = null;
    private $smarty = null;
    
    public static function GetTemplate()
    {
        if (self::$template == null)
        {
            self::$template = new Template();
        }
        return self::$template;
    }
    
    public function __construct()
    {
        require_once(SMARTY_FILE);
        spl_autoload_register('__autoload');
        
        $this->smarty = new Smarty();
        $this->smarty->template_dir = SMARTY_TPL_DIR;
        $this->smarty->compile_dir = SMARTY_CPL_DIR;
        $this->smarty->config_dir = SMARTY_CFG_DIR;
        $this->smarty->cache_dir = SMARTY_CAC_DIR;
    }
    
    public function set($fields, $vals)
    {
        $this->smarty->assign($fields, $vals);
    }
    
    public function render($template)
    {
        $this->smarty->display($template);
    }
}