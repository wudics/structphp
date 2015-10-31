<?php

class Image
{
    private static $image = null;
    private $msg;
    private $path;
    private $url;
    private $ext;
    private $maxsize;
    
    public static function GetImage()
    {
        if (self::$image == null)
        {
            self::$image = new Image();
        }
        return self::$image;
    }
    
    public function __construct()
    {
        $this->msg = '';
        $this->path = IMG_UPLOAD_PATH;
        $this->url = IMG_UPLOAD_URL;
        $this->ext = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
        $this->maxsize = 1048576;
    }
    
    // 处理图片上传
    public function procceedUpload($filefield = 'imgFile')
    {
        if (!empty($_FILES[$filefield]['error']))
        {
            switch ($_FILES[$filefield]['error'])
            {
                case '1':
                    $this->msg = '超过php.ini允许的大小。';
                    break;
        		case '2':
        			$this->msg = '超过表单允许的大小。';
        			break;
        		case '3':
        			$this->msg = '图片只有部分被上传。';
        			break;
        		case '4':
        			$this->msg = '请选择图片。';
        			break;
        		case '6':
        			$this->msg = '找不到临时目录。';
        			break;
        		case '7':
        			$this->msg = '写文件到硬盘出错。';
        			break;
        		case '8':
        			$this->msg = 'File upload stopped by extension。';
        			break;
        		case '999':
        		default:
        			$this->msg = '未知错误。';
            }
            return false;
        }
        
        $file_name = $_FILES[$filefield]['name'];
        $tmp_name = $_FILES[$filefield]['tmp_name'];
        $file_size = $_FILES[$filefield]['size'];
        
        if (!$file_name)
        {
            $this->msg = "请选择文件";
            return false;
        }
        
        if (@is_dir($this->path) === false)
        {
            $this->msg = "上传目录不存在";
            return false;
        }
        
        if (@is_writable($this->path) === false)
        {
            $this->msg = "上传目录没有写入权限";
            return false;
        }
        
        if (@is_uploaded_file($tmp_name) === false)
        {
            $this->msg = "上传失败";
            return false;
        }
        
        if ($file_size > $this->maxsize)
        {
            $this->msg = "上传文件大小超过限制";
            return false;
        }
        
        // 获得文件扩展名
        $temp_arr = explode(".", $file_name);
        $file_ext = array_pop($temp_arr);
        $file_ext = trim($file_ext);
        $file_ext = strtolower($file_ext);
        
        if (in_array($file_ext, $this->ext) === false)
        {
            $this->msg = "文件扩展名仅允许：" . implode(",", $this->ext);
            return false;
        }
        
        $ymd = date("Ymd");
        
        $this->path .= $ymd . "\\";
        $this->url .= $ymd . "/";
        
        if (!file_exists($this->path))
        {
            mkdir($this->path);
        }
        
        $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
        
        $file_path = $this->path . $new_file_name;
        
        if (move_uploaded_file($tmp_name, $file_path) === false)
        {
            $this->msg = "上传失败";
            return false;
        }
        
        @chmod($file_path, 0644);
        
        $file_url = $this->url . $new_file_name;
        
        $this->msg = $file_url;
        
        return true;
    }
    
    public function kindeditorUpload()
    {
        if ($this->procceedUpload("imgFile"))
        {
            header('Content-type: text/html; charset=UTF-8');
            echo json_encode(array('error' => 0, 'url' => $this->msg));
        }
        else
        {
            header('Content-type: text/html; charset=UTF-8');
            echo json_encode(array('error' => 1, 'message' => $this->msg));
        }
    }
    
    public function GetMSG()
    {
        return $this->msg;
    }
}
















