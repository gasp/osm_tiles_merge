var tiles = require('./tiles')(),
  init = require('./init');

var http = require('http'),
  fs = require('fs'),
  url = require('url'),
  async = require('async');

var mkdir = function (path, mask, cb) {
  if (typeof mask == 'function') { // allow the `mask` parameter to be optional
    cb = mask;
    mask = 0777;
  }
  fs.mkdir(path, mask, function(err) {
    if (err) {
      if (err.code == 'EEXIST') cb(null); // ignore the error if the folder already exists
      else cb(err); // something else went wrong
    } else cb(null); // successfully created folder
  });
};

init(function () {
  async.each(tiles, function(tile, callback){
    var t = url.parse(tile);
    var xd = t.path.match(/(\/\d+)/g);

    t.directories = {
      z: xd[0].substring(1),
      x: xd[1].substring(1),
      y: xd[2].substring(1)
    };

    var options = {
      host: t.host,
      port: 80,
      path: t.path,
      t: t
    };

    // should be using q ?
    mkdir(__dirname + '/tiles/' + t.directories.z, 0744, function() {
      mkdir(__dirname + '/tiles/' + t.directories.z + '/' + t.directories.y, 0744, function() {
        options.file = t.directories.x
        request(options, function() {
          callback();
        })
      })
    })

  }, function(err) {
    console.log("done");
  });
});

var request = function(options, cb) {
  
  http.get(options, function(res){
    var imagedata = ''
    res.setEncoding('binary')

    res.on('data', function(chunk){
        imagedata += chunk
    })

    res.on('end', function(){
      var f = __dirname 
        + '/tiles/' 
        + options.t.directories.z 
        + '/' 
        + options.t.directories.y 
        + '/' 
        + options.t.directories.x 
        + '.png';

      fs.writeFile(f, imagedata, 'binary', function(err){
        if (err) throw err
        console.log('saved '+f);
        cb();
      })

    })
  });
};