<?php

$sqlite = sqlite_open('base.sqlite');

foreach(sqlite_array_query($sqlite,'SELECT r, g, b FROM images;') as $record) {
	printf ("<div style=\"background-color: rgb(%s, %s, %s); height: 20; width: 20; display: inline-block;\" ></div>", $record['r'],$record['g'],$record['b'] );
}

?>