<?php
//usage:
//$tb=new SimpleThumbnail($destDir, $imagePath);
////$tb->setDestinationDir($destDir);
////$tb->setOriginal($imagePath);
////$tb->setMaxSize(300); // default thumbnail with and height max size is 200px
//$tb->create(300, 200) // or $tb->create();

class SimpleThumbnail
{
    protected $_original;
    protected $_originalWidth;
    protected $_originalHeight;
    protected $_thumbWidth;
    protected $_thumbHeight;
	protected $_thumbName;
    protected $_destinationDir;
    protected $_maxSize=200;
    protected $_imageType='';
    protected $_suffix='_thb';
    protected $_imageName='';
    protected $_canProcess=false;
    protected $_messages=array();
    protected $_imageMimeTypes=array('image/jpeg','image/jpg','image/gif','image/png');

    private function _extractImageType($mime)
    {
        if(in_array($mime, $this->_imageMimeTypes))
        {
            $this->_imageType=substr($mime,strrpos($mime,'/')+1);
            //or substr($mime,6);image/=>6 chars
            return true;
        }
        return false;
    }

    // no extision name, just file name
    private function _extractImageName($path)
    {
        //$exts=array('/\.jpg$/i','/\.jpeg$/i','/\.gif$/i','/\.png$/i');
        $exts=array();
        foreach($this->_imageMimeTypes as $mime)
        {
            $exts[]='/\.'.substr($mime,strrpos($mime,'/')+1).'$/i';
        }
        $this->_imageName=preg_replace($exts,'',basename($path));
        return true;
    }

    private function _createImageSource()
    {
        switch($this->_imageType)
        {
            case 'jpeg':
            case 'jpg':
                return imagecreatefromjpeg($this->_original);
            case 'png':
                return imagecreatefrompng($this->_original);
            case 'gif':
                return imagecreatefromgif($this->_original);
        }
    }
    
    private function _createThumbnail($width, $height)
    {
        $this->_calculateThumbnailSize($width, $height);

        $source=$this->_createImageSource();
        $thumb=imagecreatetruecolor($this->_thumbWidth,$this->_thumbHeight);
        imagecopyresampled($thumb,
                           $source,
                           0,
                           0,
                           0,
                           0,
                           $this->_thumbWidth,
                           $this->_thumbHeight,
                           $this->_originalWidth,
                           $this->_originalHeight);

        $filename=$this->_imageName.$this->_suffix.'.'.$this->_imageType;
        switch($this->_imageType)
        {
            case 'jpeg':
            case 'jpg':
                $ok=imagejpeg($thumb,$this->_destinationDir.$filename,100);
                break;
            case 'png':
                $ok=imagepng($thumb,$this->_destinationDir.$filename,0);
                break;
            case 'gif':
                $ok=imagegif($thumb,$this->_destinationDir.$filename);
                break;
        }

        if($ok)
        {
            $this->_thumbName=$filename;
            $this->_messages[]="$filename created successfully.";
        }
        else
        {
            $this->_messages[]="Could't create a thumbnail for ".basename($this->_original);
        }
        
        imagedestroy($source);
        imagedestroy($thumb);
    }

    private function _calculateThumbnailSize($width,$height)
    {
        if($width<$this->_maxSize && $hieght<$this->_maxSize)
        {
            $zoom=1;
        }
        elseif($width>$height)
        {
            $zoom=$this->_maxSize/$width;
        }
        else
        {
            $zoom=$this->_maxSize/$height;
        }

        $this->_thumbWidth=round($zoom*$width);
        $this->_thumbHeight=round($zoom*$height);
        return true;
    }
    
    public function __construct($destPath='', $imagePath='')
    {
        if($destPath)
        {
            $this->setDestinationDir($destPath);
        }
        if($imagePath)
        {
            $this->setOriginal($imagePath);
        }

    }

    public function setDestinationDir($path)
    {
        if(is_dir($path) && is_writable($path))
        {
            if(substr($path,-1)!=DIRECTORY_SEPARATOR)
            {
                $path.=DIRECTORY_SEPARATOR;
            }
            $this->_destinationDir=$path;
            return true;
        }
        
        $this->_messages[]="Destination directory $path is invalid or cannot writable.";
        return false;
    }

	public function setOriginal($imagePath)
	{
        if(is_file($imagePath)&&is_readable($imagePath))
        {
            $details=getimagesize($imagePath);
            if($details)
            {
                $this->_original=$imagePath;
                $this->_originalWidth=$details[0];
                $this->_originalHeight=$details[1];
                $mime=$details['mime'];
                if($this->_extractImageType($mime) &&
                    $this->_extractImageName($imagePath))
                {
                    return true;
                }
                else
                {
                    $this->_messages[]="Image type $mime is not supported.";
                }
            }
            else
            {
                $this->_messages[]="The file $imagePath is not a image file.";
            }
        }
        else
        {
            $this->_messages[]="The image file $imagePath cannot be opened.";
        }
        return false;
	}

    public function setMaxSize($size)
    {
        if(is_numeric($size))
        {
            $this->_maxSize=(int)abs($size);
            return true;
        }

        $this->_messages[]="$size is not a validated number,so max size is default $this->_maxSize";
        return false;
    }

    public function setSuffix($suffix)
    {
        if(preg_match('/^\w+$/',$suffix))
        {
            if(strpos($suffix,'_')!==0)
            {
                $suffix='_'.$suffix;
            }
            $this->_suffix=$suffix;
            return true;
        }
        return false;
    }

    public function getMessages()
    {
        return $this->_messages;
    }


    public function create($tbWidth='',$tbHeight='')
    {
        if(!empty($this->_messages))
        {
            return false;
        }

		$width=$this->_originalWidth;
		$height=$this->_originalHeight;
		if(!empty($tbWidth) && !empty($tbHeight))
		{
			$width=$tbWidth;
			$height=$tbHeight;
		}
        // if($this->_originalWidth==0)
        // {
        //     $this->_messages[]="Cannot determine size of $this->_original.";
        // }

        $this->_createThumbnail($width, $height);
        return $this->_thumbName;
    }

	private function test()
    {
        $mystr="";
        $mystr.='orignal file   '.$this->_original.'<br/>';
        $mystr.='orignal width  '.$this->_originalWidth.'<br/>';
        $mystr.='orignal height '.$this->_originalHeight.'<br/>';
        $mystr.='thumb width    '.$this->_thumbWidth.'<br/>';
        $mystr.='thumb height   '.$this->_thumbHeight.'<br/>';
        $mystr.='image type '.$this->_imageType.'<br/>';
        $mystr.='destination    '.$this->_destinationDir.'<br/>';
        $mystr.='max size   '.$this->_maxSize.'<br/>';
        $mystr.='suffix '.$this->_suffix.'<br/>';
        $mystr.='filename '.$this->_name.'<br/>';
        echo $mystr;
        if(!empty($this->_messages))
        {
            print_r($this->_messages);
        }
    }
    
}
?>