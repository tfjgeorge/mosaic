<?php

header ('Content-Type: image/jpeg');

$tolerance = 20;
$min_width = 64;

$input_raw = imagecreatefromjpeg($_FILES['fichier']['tmp_name']);
// resample image
list($image_width, $image_height) = getimagesize($_FILES['fichier']['tmp_name']);
if ($image_width > $image_height) {
	$width = $min_width;
	$height = (int) ($min_width * $image_height / $image_width);
}
else {
	$height = $min_width;
	$width = (int) ($min_width * $image_width / $image_height);
}
$input = imagecreatetruecolor($width, $height);
imagecopyresampled($input, $input_raw, 0, 0, 0, 0, $width, $height, $image_width, $image_height);

$output = imagecreatetruecolor($width*32, $height*32);
$map = array();

for ($y=0; $y < $height; $y++) {
	$map[$y] = array();
	for ($x=0; $x < $width; $x++) {

		// current pixel
		$rgb = imagecolorat($input, $x, $y);
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;

		$closest_colors = $bdd->exec('SELECT r, g, b, image_url, video_id, position FROM images WHERE '.
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
			$map[$y][$x] = array('video_id' => $color['video_id'], 'image_url' => $color['image_url'], 'position' => $color['position']);

			imagecopyresized($output, $image, $x*32, $y*32, 20, $color['position']*120, 32, 32, 120, 120);
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
file_put_contents('output.json', json_encode($map));

?>