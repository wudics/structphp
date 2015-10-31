<?php

    /* CONST */
    
    // MYSQL
    define(DB_HOST, 'localhost');
    define(DB_PORT, '3306');
    define(DB_USER, 'root');
    define(DB_PASS, '123456');
    define(DB_BASE, 'myblog');
    define(DB_SET, 'GBK');
    
    // SMARTY
    define(SMARTY_FILE, ROOT . DS . 'unit' . DS . 'smarty' . DS . 'Smarty.class.php');
    define(SMARTY_TPL_DIR, ROOT . DS . 'view' . DS . 'template' . DS . 'default' . DS);
    define(SMARTY_CPL_DIR, ROOT . DS . 'view' . DS . 'compile' . DS);
    define(SMARTY_CFG_DIR, ROOT . DS . 'view' . DS . 'config' . DS);
    define(SMARTY_CAC_DIR, ROOT . DS . 'view' . DS . 'cache' . DS);
    
    // WEB ROOT RES UNIT
    define(DOMAIN, 'localhost');
    define(WEBROOT, 'http://' . DOMAIN . rtrim(dirname($_SERVER['PHP_SELF']), '\\') . '/');
    define(WEBIMG,  WEBROOT . 'res/img/');
    define(WEBJS, WEBROOT . 'res/js/');
    define(WEBCSS, WEBROOT . 'res/css/');
    define(WEBFONT, WEBROOT . 'res/font/');
    
    // KINDEDITOR
    define(KINDEDITOR, WEBROOT . 'unit/kindeditor/');
    
    // UPLOAD IMG
    define(IMG_UPLOAD_PATH, ROOT . DS . 'res' . DS . 'img' . DS . 'upload' . DS);
    define(IMG_UPLOAD_URL, WEBIMG . 'upload/');
    
    /* GLOBAL VARIABLES */
    $url = $_GET['url'];
    
    $default['controller'] = 'home';
    $default['action'] = 'index';