<?php /* Smarty version Smarty-3.1.14, created on 2014-11-06 13:12:15
         compiled from "D:\AppServ\www\mymvc\view\template\default\editor.html" */ ?>
<?php /*%%SmartyHeaderCode:6564545b5f51114804-03048448%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6790b5be9b1fd0b33a327dd813d316f703def727' => 
    array (
      0 => 'D:\\AppServ\\www\\mymvc\\view\\template\\default\\editor.html',
      1 => 1415279526,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6564545b5f51114804-03048448',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_545b5f511bb1e9_00122257',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_545b5f511bb1e9_00122257')) {function content_545b5f511bb1e9_00122257($_smarty_tpl) {?><html>
    <head>
        <title>editor</title>
    </head>
    <body>
        <link rel="stylesheet" href="<?php echo @constant('KINDEDITOR');?>
themes/simple/simple.css" />
        <script charset="utf-8" src="<?php echo @constant('KINDEDITOR');?>
kindeditor.js"></script>
        <script charset="utf-8" src="<?php echo @constant('KINDEDITOR');?>
lang/zh_CN.js"></script>
        <script>
            KindEditor.ready(function(K) {
                editor = K.create('#editor_id', {
                    basePath : '<?php echo @constant('KINDEDITOR');?>
',
                    urlType : 'domain',
                    uploadJson : '<?php echo @constant('WEBROOT');?>
?url=home/ajaxuploadimg',
                    cssPath : [
                        '<?php echo @constant('KINDEDITOR');?>
plugins/code/prettify.css'
                    ],
                    themeType : 'simple',
                    width : 360,
                    height : 200,
                    resizeType : 0,
                    items : [
                        'source', 'bold', 'fontname', 'fontsize', 'forecolor',
                        'image', 'flash', 'code', 'baidumap', 'clearhtml', 'link',
                        'unlink', 'emoticons', 'pagebreak'
                    ],
                    allowFlashUpload : false
                });
            });
        </script>
        <form action="<?php echo @constant('WEBROOT');?>
?url=home/index" method="post">
            <textarea id="editor_id" name="content" rows="10" cols="30"></textarea>
        </form>
    </body>
</html><?php }} ?>