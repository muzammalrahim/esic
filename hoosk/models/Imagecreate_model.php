<?php

class Imagecreate_model extends CI_Model
{
    function __construct(){
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        parent::__construct();
        $this->load->helper('cookie');  
    } 
    public function createimage($filewithpath){
        if($filewithpath){
          $ext = $this->Get_file_extension($filewithpath);
          $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filewithpath);
          $this->Resize_image(1024, 1024, 80, $filewithpath, $withoutExt.'_big_1024.'.$ext);// for big
          $this->Resize_image(1024, 1024, 80, $filewithpath, $withoutExt.'_norml_512.'.$ext);// for big
          $this->Resize_image(300, 300, 80, $filewithpath, $withoutExt.'_thumbnail_300.'.$ext);// for thumbnails
          $this->Resize_image(100, 100, 80, $filewithpath, $withoutExt.'_thumb_small_100.'.$ext);// for thumbnails
          $this->Resize_image(60, 60, 80, $filewithpath, $withoutExt.'_icon_60.'.$ext); // for icons
        }
    }
    public function Resize_image($width = 0, $height = 0, $quality = 80, $filename_in = null, $filename_out = null){
      $this->Filename = $filename_in;
      $this->Extension = strtolower($this->Get_file_extension($this->Filename));

      $size = getimagesize($this->Filename);
      $ratio = $size[0] / $size[1];
      if ($ratio >= 1){
          $scale = $width / $size[0];
      } else {
          $scale = $height / $size[1];
      }
      // make sure its not smaller to begin with!
      if ($width >= $size[0] && $height >= $size[1]){
          $scale = 1;
      }

        $image_mime = image_type_to_mime_type(exif_imagetype($this->Filename));
        //Updating the Switch Statement.
        switch ($image_mime) {
            case "image/gif":
                $im_in = imagecreatefromgif($this->Filename);
                $im_out = imagecreatetruecolor($size[0] * $scale, $size[1] * $scale);
                imagecopyresampled($im_out, $im_in, 0, 0, 0, 0, $size[0] * $scale, $size[1] * $scale, $size[0], $size[1]);
                if($this->Extension !== 'gif'){
                    //We Need to reassign the extention as well.
                    $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename_in);
                    $filename_out = $withoutExt.'.gif';
                }
                imagegif($im_out, $filename_out, $quality);
                break;
            case "image/jpeg":
                $im_in = imagecreatefromjpeg($this->Filename);
                $im_out = imagecreatetruecolor($size[0] * $scale, $size[1] * $scale);
                $boolJPEGResult = imagecopyresampled($im_out, $im_in, 0, 0, 0, 0, $size[0] * $scale, $size[1] * $scale, $size[0], $size[1]);
                if($this->Extension !== 'jpg' and $this->Extension !== 'jpeg'){
                    //We Need to reassign the extention as well.
                    $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename_in);
                    $filename_out = $withoutExt.'.jpeg';
                }
                $boolJPEGOutputResult = imagejpeg($im_out, $filename_out, $quality);
                break;
            case "image/png":
                $im_in = imagecreatefrompng($this->Filename);
                $im_out = imagecreatetruecolor($size[0] * $scale, $size[1] * $scale);
                imagealphablending($im_out, false); // setting alpha blending on
                imagesavealpha($im_out, true); // save alphablending setting (important)
                $transparent = imagecolorallocatealpha($im_out, 255, 255, 255, 127);
                imagefilledrectangle($im_out, 0, 0, $size[0] * $scale, $size[1] * $scale, $transparent);
                imagecopyresampled($im_out, $im_in, 0, 0, 0, 0, $size[0] * $scale, $size[1] * $scale, $size[0], $size[1]);
                if($this->Extension !== 'png'){
                    //We Need to reassign the extention as well.
                    $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename_in);
                    $filename_out = $withoutExt.'.png';
                }
                imagepng($im_out, $filename_out, 9);
                break;
            /*case "image/bmp":
                echo "Image is a bmp";
                break;*/
            default:
                echo "Extention :". $this->Extention . "<br />";
                echo "File :". $this->Filename . "<br />";
                echo "Mime :". $image_mime . "<br />";
                return;
        }
      imagedestroy($im_out);
      imagedestroy($im_in);
      
    }
    public function Get_file_extension($filename){
       $filename = strtolower($filename) ;
       $exts = explode(".", $filename) ;
       $n = count($exts)-1;
       $exts = $exts[$n];
       return $exts;
    }
}
