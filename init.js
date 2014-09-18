var async = require('async'),
  fs = require('fs');

var directories = [
  {
    name: 'tiles',
    path: __dirname + '/tiles',
    mask: 0744
  },
  {
    name: 'build',
    path: __dirname + '/build',
    mask: 0744

  }
];

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

var init = function (cb) {
  async.each(directories, function(dir, callback){
    mkdir(dir.path, dir.mask, function(err) {
        if (err) console.log("error creating folder");
        else callback()
    });
  }, function(err) {
    if(err) {
      console.log("init failed");
      // throw something
      return false;
    }

    mkdir(__dirname + '/tiles/16', 0744, function(err) {
        if (err) console.log("error creating folder");
        else {
          console.log("init finished");
          cb();
        }
    });

  });

};

module.exports = init;
