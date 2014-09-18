var server = {
  url: "http://{{u}}.tile.stamen.com/toner-background/{{z}}/{{x}}/{{y}}.png"
};

// a simple random between a,b,c and d
var r = function() {
  var s = "abcd";
  var rand = Math.floor(Math.random()*s.length);
  return s[rand];
};

//the bbox, which zone ?
var bbox = {
  min: {x: 33100, y: 22400},
  max: {x: 33300, y: 22600}
};

// mini-mustache
var mu = function (original, data) {
  return original.replace( /\{\{(.*?)\}\}/g, function(key){
    key = key.substring(2,key.length-2);
    return data[key];
  });
};

var generate = function () {
  var t = [];
  var coord = {x: bbox.min.x, y: bbox.min.y}
  while (coord.x < bbox.max.x) {
    coord.y = bbox.min.y;
    while (coord.y < bbox.max.y) {
      var data = {
        u: r(),
        z: 16,
        x: coord.x,
        y:coord.y
      };
      t.push(mu(server.url, data));
      coord.y ++;
    }
    coord.x ++;
  }
  return t;
};

/*
console.log('testing r :', r());
console.log('testing mu:', mu(server.url, {u:"a",z:16,x:1,y:1}));
*/

module.exports = generate;