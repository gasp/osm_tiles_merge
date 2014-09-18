<?php
error_reporting(E_ALL);

define('TILE_WIDTH', 256);
define('TILE_HEIGHT', 256);

echo "a\n";

$tiles = array();
$filesy = scandir('./tiles/16');
for ($i=0; $i < count($filesy); $i++) { 
	$filesx = scandir('./tiles/16/'.$filesy[$i]);
	$tilesline = array();
	for ($j=0; $j < count($filesx); $j++) {
		if($filesx[$j] !== '.' && $filesx[$j] !== '..' && $filesy[$i] !== '.' && $filesy[$i] !== '..') {
			array_push($tilesline,'./tiles/16/'.$filesy[$i].'/'.$filesx[$j]);
		}

	}
	// do not push empty array
	if(isset($tilesline[0])) {
		array_push($tiles, $tilesline);
	}
}

var_dump($tiles);

$saveTo = 'result.png';

$image = imagecreate(TILE_WIDTH * count($tiles), TILE_HEIGHT * count($tiles[2]));
var_dump("create image".TILE_WIDTH * count($tiles).'*'.TILE_HEIGHT * count($tiles[0]));
foreach($tiles as $row => $columns) {
	foreach($columns as $col => $filename) {
		var_dump($filename);
		$tile = imagecreatefrompng($filename);
		imagecopy($image, $tile, $col * TILE_WIDTH, $row * TILE_HEIGHT, 0, 0, TILE_WIDTH, TILE_HEIGHT);
	}
}

imagepng($image, $saveTo);
