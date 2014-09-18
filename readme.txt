What is that
------------


![A nice tile from Paris](https://raw.githubusercontent.com/gasp/osm_tiles_merge/master/22546.png)
Openstreetmap lovers, would you like to make big maps from your favorite tiles ?

This script downloads all the tiles from a specific server and then merge them
into big images.

This example used toner-background tiles from [stamen](http://stamen.com), and the result is really great ()[Paris Center](https://raw.githubusercontent.com/gasp/osm_tiles_merge/master/paris_center.png))

How to use
----------

0.install with `npm i` and configure `tiles.js`

1.run with 
`node load.js && php merge.php`
my lazy `node load.js && /Applications/MAMP/bin/php5.3/bin/php merge.php`

2.wait
you shall have a lot of logs to read

3.fail
tweak your machine performance (especially php.ini, swap)

4.restart
better luck next time


Why is it so ? 
--------------

Because this is quick-and-dirty


Why using some PHP and some Nodejs ?
------------------------------------

Because phpGD is really easy to use.