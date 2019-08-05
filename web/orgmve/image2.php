<?php 
include("./inc/mysql.inc.php");
$PHP_SELF = $_SERVER['PHP_SELF'];
$db = new CMySQL;
$lp=$_GET['cln'];
$title=$_GET['title'];
$edit=$_GET["edit"];
$ID=$_GET["ID"];

if ($edit != "1") {
$sql = "SELECT `photo_id`, `no`, `photo_alttext`, `photo_src`, `photo_desc`, `photo_filename`, `photo_filesize`, `photo_filetype` FROM `staffphotos` WHERE `no`=$lp  LIMIT 1";

}
else {
$sql = "SELECT `photo_alttext`, `photo_src`, `photo_desc`, `photo_filename`, `photo_filesize`, `photo_filetype` FROM `temp_nombers` WHERE `ID`=$ID  LIMIT 1";

}


$sql = "SELECT `photo_id`, `no`, `photo_alttext`, `photo_src`, `photo_desc`, `photo_filename`, `photo_filesize`, `photo_filetype` FROM `staffphotos` WHERE `no`='1879'  LIMIT 1";


if (!$db->Open()) $db->Kill();

          if ($db->Query($sql)) 
            {
				 while ($r=$db->Row())
			     {
			     
			     echo "SSS";
			        print_r(gd_info());
			      echo "TTT";
			     $source_pic = 'images/dial.gif';
$destination_pic = 'images/dial2.gif';
$max_width = 500;
$max_height = 500;

$src = imagecreatefromjpeg($source_pic);
list($width,$height)=getimagesize($source_pic);

$x_ratio = $max_width / $width;
$y_ratio = $max_height / $height;

if( ($width <= $max_width) && ($height <= $max_height) ){
    $tn_width = $width;
    $tn_height = $height;
    }elseif (($x_ratio * $height) < $max_height){
        $tn_height = ceil($x_ratio * $height);
        $tn_width = $max_width;
    }else{
        $tn_width = ceil($y_ratio * $width);
        $tn_height = $max_height;
}

$tmp=imagecreatetruecolor($tn_width,$tn_height);
imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);

imagejpeg($tmp,$destination_pic,100);
imagedestroy($src);
imagedestroy($tmp);
           echo "fff";
			     			     
			     
			  
 /*
$im = new Imagick();
$im->readImage("test.eps");
$im->setImageResolution(72,72);
$im->resampleImage  (144,144,imagick::FILTER_UNDEFINED,1);
$im->setImageFormat("jpg");
header("Content-Type: image/png");
echo $im;
*/

					flush(); 
				}

			} else {
			echo " 
			  <tr>
			   <td class='DataTD'></td>
			    <td class='DataTD' colspan='3'>No photos</td>
			  </tr>";
			 $db->Kill();
			}
			
/*

$im = new Imagick();
$im->readImage("/path/to/image.svg");
$res = $im->getImageResolution();
$x_ratio = $res['x'] / $im->getImageWidth();
$y_ratio = $res['y'] / $im->getImageHeight();
$im->removeImage();
$im->setResolution($width_in_pixels * $x_ratio, $height_in_pixels * $y_ratio);
$im->readImage("/path/to/image.svg");
// Now you can do anything with the image, such as convert to a raster image and output it to the browser:
$im->setImageFormat("png");
header("Content-Type: image/png");
echo $im;


*/			
			
?> 
