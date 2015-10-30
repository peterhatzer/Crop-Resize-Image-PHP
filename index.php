
<?php
	
	if(isset($_POST['submit'])){
	
		$file = $_FILES['file'];

		$file_name = $file['name'];
		$file_type = $file['type'];
		$file_size = $file['size'];
		$file_tmp = $file['tmp_name'];
		$file_error = $file['error'];


		$file_ext = explode('.', $file_name);
		$file_ext = strtolower(end($file_ext));

		$allowed = array('jpg', 'png');

		if (in_array($file_ext, $allowed)) {
			if ($file_error === 0) {
				if ($file_size <= 2097152) { 
						$file_destination = 'uploads/' . $file_name;
						move_uploaded_file($file_tmp, $file_destination); // Original file location been uploaded to. Mine is called uploads.
					
				}
			}
		}

		// Resize image
		
		function resizeImage($target, $resize, $w_thumb, $h_thumb, $ext){
			
			list($w_original, $h_original) = getimagesize($target);
			$scale_ratio = $w_original / $h_original;
			if(($w_thumb / $h_thumb) > $scale_ratio){
				$w_thumb = $h_thumb * $scale_ratio;
			} else {
				$h_thumb = $w_thumb / $scale_ratio;
			}

			$img = "";

			if ($ext == 'png') {
				$img = imagecreatefrompng($target);
			} else {
				$img = imagecreatefromjpeg($target);
			}

			$tci = imagecreatetruecolor($w_thumb, $h_thumb);
			imagecopyresampled($tci, $img, 0, 0, 0, 0, $w_thumb, $h_thumb, $w_original, $h_original);

			if($file_ext == 'png'){
				imagepng($tci, $resize);
			} else {
				imagejpeg($tci, $resize, 90);
			}
		}

		$target_file = "uploads/".$file_name; // Target file you want to resize. Mine is called uploads.
		$resize_image = "uploads/resized_".$file_name; // File location you are uploading resized image too.
		$width_thumb = 200; // Width of the image you want to resize too.
		$height_thumb = 200; // Height of the image you want to resize too.

		resizeImage($target_file, $resize_image, $width_thumb, $height_thumb, $file_ext );

		// Crop image

		function cropImage($target, $thumb, $w_thumb, $h_thumb, $ext ){
			
			list($w_original, $h_original) = getimagesize($target);
			$src_x = ($w_original / 2) - ($w_thumb / 2);
			$src_y = ($h_original / 2) - ($h_thumb / 2);

			$img = "";

			if ($ext == 'png') {
				$img = imagecreatefrompng($target);
			} else {
				$img = imagecreatefromjpeg($target);
			}

			$tci = imagecreatetruecolor($w_thumb, $h_thumb);
			imagecopyresampled($tci, $img, 0, 0, $src_x, $src_y, $w_thumb, $h_thumb, $w_thumb, $h_thumb);

			if($file_ext == 'png'){
				imagepng($tci, $thumb);
			} else {
				imagejpeg($tci, $thumb, 90);
			}
		}

		$target_file = "uploads/resized_".$file_name; // Target file you want to crop. Mine is called uploads.
		$thumbnail = "uploads/thumb_".$file_name; // File location you are uploading thumbnail image to to.
		$width_thumb = 150; // Width of the thumb you want to crop.
		$height_thumb = 150; // Height of the thumb you want to crop.

		cropImage($target_file, $thumbnail, $width_thumb, $height_thumb, $file_ext );

		
	}

?>
<html>

<body>

	<div id="main">

		<h2>Resize and Crop image</h2>

		<form action="index.php" method="POST" enctype="multipart/form-data">

			<label>Image</label>
			<input type="file" name="file">

			<input type="submit" name="submit" value="upload">

			

		</form>
		<img src="<?php echo $resize_image ;?>">
		<img src="<?php echo $thumbnail ;?>">

	</div>


</body>

</html>