<?php
class UploadImage{
		var $image_width;
		var $image_height;
		var $thumb_width='300';
		var $thumb_height='300';
		var $fix_aspect='both';
		var $prefix="thumb";
		var $type;
		var $attribute;
		var $image_name;
		var $image_full_path;
		var $error_msg;
		var $restrict_image_size=true;
		var $restricted_width='800';
		var $restricted_height='800';
		var $allowed_extension=array('jpg','png','gif','jpeg','webp');
		var $allowed_file_extension=array('jpg','png','gif','jpeg','tiff','eps','ai','pdf','doc','docx','xls','txt','zip','mp4','mov','webp');

		function __construct(){}
		
		function upload_image($source,$destination,$name='',$prefix="yes"){
			$default_name=$source['name'];
			$source_path=$source['tmp_name'];
			list($width,$height,$type,$attr)=getimagesize($source['tmp_name']);
			
			$info=pathinfo($default_name);
			$ext=$info['extension'];
			if (in_array(strtolower($ext),$this->allowed_extension)){
				if (@move_uploaded_file($source_path,$destination.$default_name)){
					$this->correctImageOrientation($destination.$default_name);//Code to fix images rotation
					$img_info=pathinfo($destination.$default_name);
					if ($name!=''){
						$name=$name.'.'.strtolower($img_info['extension']);
						rename($destination.$default_name,$destination.$name);	
					}
					else{
						$name=$default_name;
					}
					if ($this->restrict_image_size==true){
						if ($width>=$this->restricted_width){
							$img_info=pathinfo($destination.$name);
							if (strtolower($img_info['extension'])=='jpg' || strtolower($img_info['extension'])=='jpeg')
								$source_image=imagecreatefromjpeg($destination.$name);
							else if (strtolower($img_info['extension'])=='png')
								$source_image=imagecreatefrompng($destination.$name);
							else if (strtolower($img_info['extension'])=='gif')
								$source_image=imagecreatefromgif($destination.$name);
							else{
								$this->error_msg="Invalid File Format. Only jpg, png, gif images are allowed";
								return false;
							}
							$src_width=imagesx($source_image);
							$src_height=imagesy($source_image);
							$this->restricted_height=floor(($this->restricted_width/$src_width)*$src_height);
							$virtual_image=imagecreatetruecolor($this->restricted_width,$this->restricted_height);
							imagefilledrectangle($virtual_image, 0, 0, $this->restricted_width, $this->restricted_height, imagecolorallocate($virtual_image, 255, 255, 255));
							imagecopyresampled($virtual_image,$source_image,0,0,0,0,$this->restricted_width,$this->restricted_height,$src_width,$src_height);
							$resized_name="resized_".$name;
							if (strtolower($img_info['extension'])=='jpg' || strtolower($img_info['extension'])=='jpeg'){
								imagejpeg($virtual_image,$destination.$resized_name,80);
							}else if (strtolower($img_info['extension'])=='png'){
								imagepng($virtual_image,$destination.$resized_name,9,PNG_ALL_FILTERS);
							}else if (strtolower($img_info['extension'])=='gif'){
								imagegif($virtual_image,$destination.$resized_name);
							}
							@unlink($destination.$name);
							rename($destination.$resized_name,$destination.$name);
						}
					}
					list($width,$height,$type,$attr)=getimagesize($destination.$name);
					$this->image_width=$width;
					$this->image_height=$height;
					$this->type=$type;
					$this->attribute=$attr;
					$this->image_full_path=$destination.$name;
					$this->image_name=$name;
					return true;
				}
				else{
					$this->error_msg="Image not found on given source \"$source_path\" ";	
					return false;
				}
			}
			else{
				echo "You Uploaded the file named <b>'$default_name'</b><br>Allowed extensions are ";
				foreach($this->allowed_extension as $img)
					echo $img.', ';
				die('');
			}
		}
		function upload_files($source,$destination,$name=''){
			$default_name=$source['name'];
			$source_path=$source['tmp_name'];			
			$info=pathinfo($default_name);
			$ext=$info['extension'];
			if (in_array(strtolower($ext),$this->allowed_file_extension)){
				if (@move_uploaded_file($source_path,$destination.$default_name)){
					$img_info=pathinfo($destination.$default_name);
					if ($name!=''){
						$name=$name.'.'.$img_info['extension'];
						rename($destination.$default_name,$destination.$name);	
					}
					else{
						$name=$default_name;
					}
					list($width,$height,$type,$attr)=getimagesize($destination.$name);
					$this->image_width=$width;
					$this->image_height=$height;
					$this->type=$type;
					$this->attribute=$attr;
					$this->image_full_path=$destination.$name;
					$this->image_name=$name;
					return true;
				}
				else{
					$this->error_msg="Image not found on given source \"$source_path\" ";	
					return false;
				}
			}
			else{
				echo "You Uploaded the file named <b>'$default_name'</b> is not allowed.<br>Allowed extensions are ";
				foreach($this->allowed_file_extension as $img)
					echo $img.', ';
				die('');
			}
		}
		function upload_video($source,$destination,$name=''){
			$default_name=$source['name'];
			$source_path=$source['tmp_name'];			
			$info=pathinfo($default_name);
			$ext=$info['extension'];
			if (in_array(strtolower($ext),$this->allowed_file_extension)){
				if (@move_uploaded_file($source_path,$destination.$default_name)){
					$img_info=pathinfo($destination.$default_name);
					if ($name!=''){
						$name=$name.'.'.$img_info['extension'];
						rename($destination.$default_name,$destination.$name);	
					}
					else{
						$name=$default_name;
					}
					$this->image_full_path=$destination.$name;
					$this->image_name=$name;
					return true;
				}
				else{
					$this->error_msg="Image not found on given source \"$source_path\" ";	
					return false;
				}
			}
			else{
				echo "You Uploaded the file named <b>'$default_name'</b> is not allowed.<br>Allowed extensions are ";
				foreach($this->allowed_file_extension as $img)
					echo $img.', ';
				die('');
			}
		}
		function upload_image_with_thumbnail($source,$destination,$name='',$width=300,$height=300,$fix_aspect="both",$prefix="thumb"){
			if ($this->upload_image($source,$destination,$name)){
				$this->set_thumb_settings($width,$height,$fix_aspect,$prefix);
				if ($this->create_thumbnail($this->image_full_path,$destination))
					return true;
				else{
					$this->error_msg="Error Creating Thumb";
					return false;
				}
			}
			else{
				$this->error_msg="Error Uploading Image";
				return false;
			}
		}
		
		function upload_fixed_size_image($source,$destination,$name='',$width=100,$height=100,$fix_aspect="both"){
			if ($this->upload_image_with_thumbnail($source,$destination,$name,$width,$height,$fix_aspect)){
				unlink($this->image_full_path);
				rename($destination.$this->prefix.'-'.$this->image_name,$destination.$this->image_name);
				return true;
			}
			else{
				$this->error_msg="Error Uploading Image";
				return false;	
			}
		}
		function correctImageOrientation($filename) {
			if (function_exists('exif_read_data')) {
				$exif = exif_read_data($filename);
				if($exif && isset($exif['Orientation'])) {
					$orientation = $exif['Orientation'];
					if($orientation != 1){
						$img = imagecreatefromjpeg($filename);
						$deg = 0;
						switch ($orientation) {
							case 3:
								$deg = 180;
								break;
							case 6:
								$deg = 270;
								break;
							case 8:
								$deg = 90;
								break;
						}
						if ($deg) {
							$img = imagerotate($img, $deg, 0);
						}
						// then rewrite the rotated image back to the disk as $filename 
						imagejpeg($img, $filename, 95);
					}// if there is some rotation necessary
				}// if have the exif orientation info
			}// if function exists      
		}
		function set_thumb_settings($width=100,$height=100,$fix_aspect="both",$prefix="thumb"){
			if ($fix_aspect=='both'){
				$this->thumb_width=$width;
				$this->thumb_height=$height;	
			}
			else if ($fix_aspect=='width'){
				$this->thumb_width=$width;
				$this->thumb_height=floor(($width/$this->image_width)*$this->image_height);
			}
			else if ($fix_aspect=='height'){
				$this->thumb_height=$height;
				$this->thumb_width=floor(($height/$this->image_height)*$this->image_width);
			}
			$this->prefix=$prefix;
		}
		
		function restrict_image_size($width,$height){
			$this->restrict_image_size=true;
			$this->restricted_width=$width;
			$this->restricted_height=$height;
		}
		
		function create_thumbnail($source,$destination){
			$img_info=pathinfo($source);
			if (strtolower($img_info['extension'])=='jpg' || strtolower($img_info['extension'])=='jpeg'){
				$source_image=imagecreatefromjpeg($source);
			}
			else if (strtolower($img_info['extension'])=='png'){
				$source_image=imagecreatefrompng($source);
			}
			else if (strtolower($img_info['extension'])=='gif'){
				$source_image=imagecreatefromgif($source);
			}
			else{
				$this->error_msg="Invalid File Format. Only jpg,png,gif images are allowed";
				return false;
			}
			$src_width=imagesx($source_image);
			$src_height=imagesy($source_image);
			$virtual_image=imagecreatetruecolor($this->thumb_width,$this->thumb_height);
			imagefilledrectangle($virtual_image, 0, 0, $this->thumb_width, $this->thumb_height, imagecolorallocate($virtual_image, 255, 255, 255));
			//imagecopyresized($virtual_image,$source_image,0,0,0,0,$this->thumb_width,$this->thumb_height,$src_width,$src_height);
			imagecopyresampled($virtual_image,$source_image,0,0,0,0,$this->thumb_width,$this->thumb_height,$src_width,$src_height);
			$thumb_name=$this->prefix.'-'.$this->image_name;
			if (strtolower($img_info['extension'])=='jpg' || strtolower($img_info['extension'])=='jpeg'){
				imagejpeg($virtual_image,$destination.$thumb_name,90);
			}
			else if (strtolower($img_info['extension'])=='png'){
				imagepng($virtual_image,$destination.$thumb_name,9,PNG_ALL_FILTERS);
			}
			else if (strtolower($img_info['extension'])=='gif'){
				imagegif($virtual_image,$destination.$thumb_name);
			}
			return true;			
		}
		function filter_name($filename){
			return substr(substr(str_replace('~\x{00a0}~',"-",str_replace(' ',"-",strip_tags($filename))),0,-4),0,90);
		}
		function get_image_name(){
			return $this->image_name;	
		}
		
		function get_image_full_path(){
			return $this->image_full_path;	
		}
		
		function get_error(){
			return $this->error_msg;	
		}
	}
	$upload_img=new UploadImage();
?>