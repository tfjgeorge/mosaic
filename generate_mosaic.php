<?php

header ('Content-Type: image/jpeg');

$tolerance = 20;
$sqlite = new SQLite3('base.sqlite'); 

$input = imagecreatefromjpeg('obama.jpeg');
list($width, $height) = getimagesize('obama.jpeg');
$output = imagecreatetruecolor($width*32, $height*32);

for ($y=0; $y < $height; $y++) {
	for ($x=0; $x < $width; $x++) {

		// current pixel
		$rgb = imagecolorat($input, $x, $y);
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;

		$closest_colors = $sqlite->query('SELECT r, g, b, image_url, position FROM images WHERE '.
			'r <= '.($r+$tolerance).' AND r >= '.($r-$tolerance).
			' AND g <= '.($g+$tolerance).' AND g >= '.($g-$tolerance).
			' AND b <= '.($b+$tolerance).' AND b >= '.($b-$tolerance).';');
		
		$results = array();
		while ($current = $closest_colors->fetchArray()) {
			if(!isset($current['image_url'])) continue; 
			array_push($results,$current);
		}
		$color = $results[array_rand($results)];

		if ($color) {
			$image = imagecreatefromjpeg('images/'.urlencode($color['image_url']));
			imagecopyresized($output, $image, $x*32, $y*32, 0, $color['position']*160, 32, 32, 120, 160);
		}
		else {
			for ($i=0; $i<32; $i++) {
				for ($j=0; $j<32; $j++) {
					imagesetpixel($output, $x*32+$i, $y*32+$j, $rgb);
				}
			}
		}

	}
}

imagejpeg($output,'output.jpeg');


?>