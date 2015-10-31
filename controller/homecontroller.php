<?php

class HomeController extends Controller
{
    public function Index()
    {
        $tpl = Template::GetTemplate();
        $tpl->render('editor.html');
    }
    
    // for test
    public function Ajaxuploadimg()
    {
        $img = Image::GetImage();
        $img->kindeditorUpload();
    }
}