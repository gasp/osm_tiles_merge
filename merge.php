<?php
echo "listing files...\n";

error_reporting(E_ALL);

define('TILE_WIDTH', 256);
define('TILE_HEIGHT', 256);
define('EXPORT_DIRECTORY', './build/');
define('MAX_TILES_PER_MERGE', 50);


/// listing
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
echo '- listed about '.(count($tiles) * count($tiles[0])).' files.'."\n";

/// merging

echo "merging files...\n";

$nbtilesy = count($tiles);
$nbtilesx = count($tiles[0]);

$startx = 0;
$pertiles = MAX_TILES_PER_MERGE;

while($startx < $nbtilesx) {
	$starty = 0;
	while($starty < $nbtilesy) {
		$perx = min($pertiles, $nbtilesx - $startx);
		$pery = min($pertiles, $nbtilesy - $starty);
		generate($tiles, $startx, $starty, $perx, $pery);

		$starty = $starty + $pery;
	}
	$startx = $startx + $perx;
}

function generate($tiles, $startx, $starty, $perx, $pery){
	$saveTo = EXPORT_DIRECTORY.'result-'.$starty.'-'.$startx.'.png';

	$image = imagecreate(TILE_WIDTH * $perx, TILE_HEIGHT * $perx);

	for ($y=0; $y < $pery; $y++) {
		for ($x=0; $x < $perx ; $x++) {
			$filename = $tiles[($starty + $y)][($startx + $x)];
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
	echo '- wrote '.$saveTo .' '.TILE_WIDTH * $perx.'*'.TILE_HEIGHT * $pery.'px.'."\n";
}

