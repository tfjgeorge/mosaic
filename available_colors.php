<?php

$sqlite = new SQLite3('base.sqlite');
$result = $sqlite->query('SELECT r, g, b FROM images;');

while($record = $result->fetchArray()) {
	printf ("<div style=\"background-color: rgb(%s, %s, %s); height: 20; width: 20; display: inline-block;\" ></div>", $record['r'],$record['g'],$record['b'] );
}

?>