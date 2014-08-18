<?php
class SimpleUpload
{
    protected $_uploadedFiles=array();
    protected $_allowedFileMaxSize=5242880; // 5242880=5*1024*1024, 5MB
    protected $_destinationDir='';  // put uploaded files into this directory 
    protected $_rename=true;  // whether allow uploaded file to rename
    protected $_renamed=false;  // whether had renamed
    protected $_debug=true;  // NOTICE: in production, must turn off
    protected $_messages=array();
    // allowed upload file types
    protected $_allowedMimeTypes=array('image/jpeg','image/png','image/pjpeg','image/gif');
    // all of supported file types
    protected $_allMimeTypes=array('image/jpeg',
                                    'image/png',
                                    'image/pjpeg',
                                    'image/gif', 
                                    'application/pdf',
                                    'image/tiff',
                                    'text/css',
                                    'text/plain',
                                    'text/rtf');
    protected $_language='en';
    protected $_translate=array('_checkUploadError12'=>array(
                                    'en'=>'%s exceeds maximum size: %s',
                                    'cn'=>'%s 文件大小超过了上限：%s'),
                                '_checkUploadError3'=>array(
                                    'en'=>'Error uploading %s, please try again.',
                                    'cn'=>'文件 %s 上传过程出错，请重试'),
                                '_checkUploadError4'=>array(
                                    'en'=>'No file selected.',
                                    'cn'=>'没有指定要上传的文件'),
                                '_checkUploadError5'=>array(
                                    'en'=>'system error, please try again later.',
                                    'cn'=>'系统出错，请稍候重试'),
                                '_checkFileSize'=>array(
                                    'en'=>'%s exceeds maximum size: %s.',
                                    'cn'=>'%s 文件大小超过了上限：%s'),
                                '_checkFileSize0'=>array(
                                    'en'=>'%s size is unknow.',
                                    'cn'=>'%s 文件大小未知'),
                                '_checkFileType'=>array(
                                    'en'=>'cannot upload the %s type of file.',
                                    'cn'=>'不能上传 %s 类型的文件'),
                                '_processFileUpload-s'=>array(
                                    'en'=>'%s upload successlly!',
                                    'cn'=>'%s 上传成功！'),
                                '_processFileUpload-r'=>array(
                                    'en'=>'%s rename to %s',
                                    'cn'=>'上传的文件 %s 重命名为 %s'),
                                '_processFileUpload-e'=>array(
                                    'en'=>'system error, please try again later.',
                                    'cn'=>'系统出错，请稍候重试'));

    
    // PRIVATE
    private function _isValidMime($types)
    {
        foreach($types as $type)
        {
            if(!in_array($type,$this->_allMimeTypes))
            {
                throw new Exception("$type is a not supported MIME Type.");
            }
        }
    }

    private function _checkUploadError($filename,$error)
    {
        if($error==0){
            return true;
        }
        switch($error)
        {
            case 1:
            case 2:
                $this->_messages[]=sprintf($this->_translate['_checkUploadError12'][$this->_language], 
                                          $filename, 
                                          $this->getAllowedFileMaxSize('M').'MB');
                break;
            case 3:
                $this->_messages[]=sprintf($this->_translate['_checkUploadError3'][$this->_language],
                                          $filename);
                break;
            case 4:
                $this->_messages[]=sprintf($this->_translate['_checkUploadError4'][$this->_language]);
                break;
            default:
                $this->_messages[]=sprintf($this->_translate['_checkUploadError5'][$this->_language],
                                          $filename);
                break;
        }
        return false;
    }

    private function _checkFileSize($filename,$size)
    {
        if($size==0){
            $this->_messages[]=sprintf($this->_translate['_checkFileSize0'][$this->_language],
                                       $filename);
            return false;
        }

        if($size>$this->_allowedFileMaxSize)
        {
            $this->_messages[]=sprintf($this->_translate['_checkFileSize'][$this->_language], 
                                          $filename, 
                                          $this->getAllowedFileMaxSize('M').'MB');
            return false;
        }
        return true;
    }

    private function _checkFileType($filename,$type)
    {
        if(!in_array($type,$this->_allowedMimeTypes))
        {
            $this->_message[]=sprintf($this->_translate['_checkFileType'][$this->_language], $type);
            return false;
        }
        else
        {
            return true;
        }
    }

    private function _adjustFileName($filename)
    {
        // replace spaces in filename with _
        $nospaces=str_replace(' ','_',$filename);
        if($nospaces!=$filename)
        {
            $this->_renamed=true;
            $filename=$nospaces;
        }

        // fetch unique filename
        if($this->_rename)
        {
            $lsdir=scandir($this->_destinationDir);
            if(in_array($filename, $lsdir))
            {
                $this->_renamed=true;
                $components=explode('.', $filename);
                if(count($components)==1)
                {
                    $extname='';
                }
                else
                {
                    $extname=array_pop($components);
                    $filename=join('.', $components);
                }

                $i=0;
                do
                {
                    $newname=join('', array($filename,
                                            '_',
                                            $i,
                                            '.',
                                            $extname));
                    $i += 1;
                }while(in_array($newname, $lsdir)); // donot forget do-while endswith ;
                return $newname;
            }
            return $filename;
        }
        else
        {
            return $filename;
        }
    }

    private function _processFileUpload($file)
    {
        $this->_renamed=false;
        if($this->_checkUploadError($file['name'], $file['error']))
        {
            if($this->_checkFileType($file['name'], $file['type']))
            {
                if($this->_checkFileSize($file['name'], $file['size']))
                {
                    $filename=$this->_adjustFileName($file['name']);
                    if(move_uploaded_file($file['tmp_name'], join('', array($this->_destinationDir, $filename))))
                    {
                        $this->_messages[]=sprintf($this->_translate['_processFileUpload-s'][$this->_language],
                                                  $file['name']);
                        if($this->_debug && $this->_renamed){
                            $this->_messages[]=sprintf($this->_translate['_processFileUpload-r'][$this->_language],
                                                      $file['name'], $filename);
                        }
                    }
                    else
                    {
                        $this->_messages[]=sprintf($this->_translate['_processFileUpload-e'][$this->_language]);
                    }
                }
            }
        }
    }



    // PUBLIC
    public function __construct($path)
    {
        try {
            $this->setDestinationDir($path);
            $this->_uploadedFiles=$_FILES;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function setAllowedFileMaxSize($size)
    {
        if(is_numeric($size))
        {
            $size=abs((int)$size);
            $this->_allowedFileMaxSize=$size;
            return true;
        }
        return false;
    }

    // $by_what allow, 'b' ,'B', 'M', default is 'b'
    public function getAllowedFileMaxSize($by_what='b')
    {
        if(in_array($by_what, array('B', 'M')))
        {
            if($by_what=='B')
            {
                // by Byte
                return number_format($this->_allowedFileMaxSize/1024, 1);
            }
            if($by_what=='M')
            {
                // by MB
                return number_format($this->_allowedFileMaxSize/(1024*1024), 1);
            }
        }
        else
        {
            // by bit
            return $this->_allowedFileMaxSize;
        }
    }

    public function setDestinationDir($path)
    {
        $path=trim($path);
        if(is_dir($path) && is_writable($path))
        {
            if($path[mb_strlen($path)-1]!=DIRECTORY_SEPARATOR)
            {
                $path.=DIRECTORY_SEPARATOR;
            }
            $this->_destinationDir=$path;
        }
        else
        {
            throw new Exception("$path must be a valid, and writable directory.");
        }   
    }

    public function getDestinationDir()
    {
        return $this->_destinationDir;
    }

    public function getMessages()
    {
        return $this->_messages;
    }

    // $types can be a single type string, or a string array
    public function addMimeTypes($types)
    {
        $types=(array)$types;
        $this->_isValidMime($types);
        $this->_allowedMimeTypes=array_unique(array_merge($this->_allowedMimeTypes, $types));
    }

    // $types can be a single type string, or a string array
    public function setMimeTypes($types)
    {
        $types=(array)$types;
        $this->_isValidMime($types);
        $this->_allowedMimeTypes=$types;
    }

    public function getMimeTypes()
    {
        return $this->_allowedMimeTypes;
    }

    // default rename filename, if not rename filename
    // the uploaded same name file will be overrided
    public function setRename($flag)
    {
        $this->_rename=$flag?true:false;
        return true;
    }

    // set feedback language, $lg can be 'en' or 'cn'
    public function setLanguage($lg)
    {
        if(in_array($lg, array('en', 'cn')))
        {
            $this->_language=$lg;
            return true;
        }
        return false;
    }

    public function move()
    {
        // if upload multiple file
        // $_FILES['name'] is an array
        $file=current($this->_uploadedFiles);
        if(is_array($file['name']))
        {
            foreach($file['name'] as $index=>$filename)
            {
                $this->_processFileUpload(array(
                    'name'=>$filename,
                    'type'=>$file['type'][$index],
                    'size'=>$file['size'][$index],
                    'error'=>$file['error'][$index],
                    'tmp_name'=>$file['tmp_name'][$index]
                ));
            }
        }
        else
        {
            $this->_processFileUpload(array(
                'name'=>$filename,
                'type'=>$file['type'],
                'size'=>$file['size'],
                'error'=>$file['error'],
                'tmp_name'=>$file['tmp_name']
            ));
        }
    }


    // Test Interface
    public function _test()
    {
        if($this->_debug)
        {
            $up = new SimpleUpload('.');
            // size
            $up->setAllowedFileMaxSize(333333);
            echo $up->getAllowedFileMaxSize();
            echo '<br/>';
            echo $up->getAllowedFileMaxSize('b');
            echo '<br/>';
            echo $up->getAllowedFileMaxSize('B');
            echo '<br/>';
            echo $up->getAllowedFileMaxSize('M');
            echo '<br/>';
            // destination directory
            echo $up->getDestinationDir();
            echo '<br/>';
            $up->setDestinationDir('..');
            echo $up->getDestinationDir();
            echo '<br/>';
            //  mime types
            echo '<pre>';
            print_r($up->getMimeTypes());
            echo '</pre>';
            $up->addMimeTypes('image/jpeg');  // existed
            $up->addMimeTypes('application/pdf');  // not existed
            //$up->addMimeTypes('application/x-icon'); // not support
            echo '<pre>';
            print_r($up->getMimeTypes());
            echo '</pre>';
            $up->setMimeTypes(array('image/jpeg', 'image/png'));
            echo '<pre>';
            print_r($up->getMimeTypes());
            echo '</pre>';
        }
    }
}
?>