<?php
ini_set('max_execution_time', '600');
$search = $_POST['search'];

/* GESTION FICHIER ENVOYE */

$_FILES['fichier']['name'];     //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_fichier.png).
$_FILES['fichier']['type'] ;    //Le type du fichier. Par exemple, cela peut être « image/png ».
$_FILES['fichier']['size']  ;   //La taille du fichier en octets.
$_FILES['fichier']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
$_FILES['fichier']['error'];    //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.
if ($_FILES['fichier']['error'] > 0) $erreur = "Erreur lors du transfert";
$extensions_valides = array('jpg', 'jpeg');
$extension_upload = strtolower(substr(strrchr($_FILES['fichier']['name'], '.')  ,1)  );


$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$bdd = new PDO('mysql:host=mysql5-19.perso;dbname=creasycreasy', 'creasycreasy', 'tm1r02dReF', $pdo_options);

$bdd->exec('DROP TABLE images_mozaik');
$bdd->exec('CREATE TABLE images_mozaik (r int, g int, b int, video_id varchar(255), image_url varchar(255), position int);');


//$sqlite = new SQLite3('base.sqlite');
//$sqlite->query('DROP TABLE images;');
//$sqlite->query('CREATE TABLE images (r int, g int, b int, video_id string, image_url string, position int);');

for ($page=1; $page < 11; $page++) { 
	$videos = json_decode(file_get_contents("https://api.dailymotion.com/videos?search=".htmlspecialchars($search)."&limit=100&page=$page&fields=filmstrip_small_url,id"));

	foreach ($videos->{'list'} as $video) {
		if (!empty($video->{'filmstrip_small_url'})) {
			if ($image = imagecreatefromjpeg($video->{'filmstrip_small_url'})) {
				imagejpeg($image,'images/'.urlencode($video->{'filmstrip_small_url'}));

				$monopixel = imagecreatetruecolor(1, 1);
				$number = imagesy($image) / 120;

				for ($i=0; $i<$number; $i++) {
					$thumb = imagecreatetruecolor(160, 120);
					imagecopyresized($thumb, $image, 0, 0, 0, $i*120, 160, 120, 160, 120);
					imagecopyresampled($monopixel, $image, 0, 0, 0, $i*120, 1, 1, 160, 120);
					$rgb = imagecolorat($monopixel, 0, 0);
					$r = ($rgb >> 16) & 0xFF;
					$g = ($rgb >> 8) & 0xFF;
					$b = $rgb & 0xFF;
					echo "$r|$g|$b => ".$video->{'filmstrip_small_url'};
					echo "\n";
					$bdd->exec("INSERT INTO images_mozaik (r, g, b, video_id, image_url, position) VALUES ($r, $g, $b, '".$video->{'id'}."', '".$video->{'filmstrip_small_url'}."', $i)");
				}
			}
		}
	}
}

include_once('generate_mosaic.php');
header('Location: index.php');

?>