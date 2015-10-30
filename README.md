# Crop-Resize-Image-PHP
Crop and resize images function with PHP GD Library.

###Required 

- PHP GD Library

Simple easy to use function to resize your images and crop them, saving you memory from large images been uploaded.

**What you need to do**: 

- Set your resize and crop dimensions for width and height. (Or you can leave them to what I have set.)
- Set the file location you want the images to upload to. (I have set it to '**uploads**'.)

And you’re all set to go. Feel free to use this snippet.

###Example of resize function

```php
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
```
