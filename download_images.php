<?php

$sqlite = sqlite_open('base.sqlite'); 

$videos = json_decode(file_get_contents("https://api.dailymotion.com/videos?search=obama&limit=100&fields=filmstrip_small_url,id"));

foreach ($videos->{'list'} as $video) {
	if (!empty($video->{'filmstrip_small_url'})) {
		$image = imagecreatefromjpeg($video->{'filmstrip_small_url'});
		$monopixel = imagecreatetruecolor(1, 1);

		imagecopyresized($monopixel, $image, 0, 0, 0, 0, 1, 1, 160, 120);
		$rgb = imagecolorat($monopixel, 0, 0);
		$b = $rgb & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$r = ($rgb >> 16) & 0xFF;

		echo "r= ", $r, "\n g= ", $g, "\n b= ", $b, "\n";
	}
} 

?>