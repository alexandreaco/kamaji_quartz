<?php


		//Create a blank image.
		$image = imagecreate(250, 18);

		//Backgroud color is white
		$back = imagecolorallocate($image, 255, 255, 255);

		//Text color is black
		$text = imagecolorallocate($image, 0, 0, 0);

		//Print text on image.
		imagestring($image,4, 2, 0, $_SESSION["id"], $text);

		//Tell the browser that this is an image.
		Header('Content-type: image/png');

		//Finalize image.
		imagepng($image);

		//Cleanup.
		imagedestroy($image);
					
					
					?>