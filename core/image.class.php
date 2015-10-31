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
    
    // ����ͼƬ�ϴ�
    public function procceedUpload($filefield = 'imgFile')
    {
        if (!empty($_FILES[$filefield]['error']))
        {
            switch ($_FILES[$filefield]['error'])
            {
                case '1':
                    $this->msg = '����php.ini����Ĵ�С��';
                    break;
        		case '2':
        			$this->msg = '����������Ĵ�С��';
        			break;
        		case '3':
        			$this->msg = 'ͼƬֻ�в��ֱ��ϴ���';
        			break;
        		case '4':
        			$this->msg = '��ѡ��ͼƬ��';
        			break;
        		case '6':
        			$this->msg = '�Ҳ�����ʱĿ¼��';
        			break;
        		case '7':
        			$this->msg = 'д�ļ���Ӳ�̳���';
        			break;
        		case '8':
        			$this->msg = 'File upload stopped by extension��';
        			break;
        		case '999':
        		default:
        			$this->msg = 'δ֪����';
            }
            return false;
        }
        
        $file_name = $_FILES[$filefield]['name'];
        $tmp_name = $_FILES[$filefield]['tmp_name'];
        $file_size = $_FILES[$filefield]['size'];
        
        if (!$file_name)
        {
            $this->msg = "��ѡ���ļ�";
            return false;
        }
        
        if (@is_dir($this->path) === false)
        {
            $this->msg = "�ϴ�Ŀ¼������";
            return false;
        }
        
        if (@is_writable($this->path) === false)
        {
            $this->msg = "�ϴ�Ŀ¼û��д��Ȩ��";
            return false;
        }
        
        if (@is_uploaded_file($tmp_name) === false)
        {
            $this->msg = "�ϴ�ʧ��";
            return false;
        }
        
        if ($file_size > $this->maxsize)
        {
            $this->msg = "�ϴ��ļ���С��������";
            return false;
        }
        
        // ����ļ���չ��
        $temp_arr = explode(".", $file_name);
        $file_ext = array_pop($temp_arr);
        $file_ext = trim($file_ext);
        $file_ext = strtolower($file_ext);
        
        if (in_array($file_ext, $this->ext) === false)
        {
            $this->msg = "�ļ���չ��������" . implode(",", $this->ext);
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
            $this->msg = "�ϴ�ʧ��";
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
















