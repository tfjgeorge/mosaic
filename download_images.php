<?php

$sqlite = sqlite_open('base.sqlite');
sqlite_exec($sqlite,'DROP TABLE images;');
sqlite_exec($sqlite,'CREATE TABLE images (r int, g int, b int, video_id string, image_url string, position int);');

for ($page=1; $page < 11; $page++) { 
	$videos = json_decode(file_get_contents("https://api.dailymotion.com/videos?search=obama&limit=100&page=$page&fields=filmstrip_small_url,id"));

	foreach ($videos->{'list'} as $video) {
		if (!empty($video->{'filmstrip_small_url'})) {
			$image = imagecreatefromjpeg($video->{'filmstrip_small_url'});
			$monopixel = imagecreatetruecolor(1, 1);

			for ($i=0; $i<8; $i++) {
				imagecopyresized($monopixel, $image, 0, 0, 0, $i*160, 1, 1, 160, 120);
				$rgb = imagecolorat($monopixel, 0, 0);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
				echo "$r|$g|$b => ".$video->{'filmstrip_small_url'};
				echo "\n";
				sqlite_exec($sqlite,"INSERT INTO images (r, g, b, video_id, image_url, position) VALUES ($r, $g, $b, '".$video->{'id'}."', '".$video->{'filmstrip_small_url'}."', $i)");
			}
		}
	}
}

?>