<?php
echo "listing files...\n";

error_reporting(E_ALL);

define('TILE_WIDTH', 256);
define('TILE_HEIGHT', 256);

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

echo "merging files...\n";

$saveTo = 'result.png';

$nbtilesy = count($tiles);
$nbtilesx = count($tiles[0]);
/*
	TODO limit file size
	$nbtilesy = min($nbtilesy, 10);
	$nbtilesx = min($nbtilesx, 10);
*/

$image = imagecreate(TILE_WIDTH * $nbtilesx, TILE_HEIGHT * $nbtilesx);
var_dump("create image".TILE_WIDTH * $nbtilesx.'*'.TILE_HEIGHT * $nbtilesy);


for ($y=0; $y < $nbtilesy; $y++) {
	for ($x=0; $x < $nbtilesx ; $x++) {
		$filename = $tiles[$y][$x];
		$tile = imagecreatefrompng($filename);
		if($tile === false) {
			var_dump('failed to create from '.$filename);
		}
		else {
			imagecopy($image, $tile, $x * TILE_WIDTH, $y * TILE_HEIGHT, 0, 0, TILE_WIDTH, TILE_HEIGHT);
		}
	}
}

imagepng($image, $saveTo);
