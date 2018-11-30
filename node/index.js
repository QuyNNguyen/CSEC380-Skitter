function addSkit(user, data){
    var http = require('http');
    var querystring = require('querystring');
    var post_data = {"content":data,"time":Date.now()};
    var options = {
        host: "elasticsearch",
        port: "9200",
        path: "/skits/"+user+"/",
        method: "POST",
        headers: { 
            "Content-Type": "application/json",
        }
    };
    var putReq = http.request(options, function (res){
        res.setEncoding('utf8');
        res.on('data', function (chunk) {
            console.log('Response: ' + chunk);
        });
    });
    putReq.write(JSON.stringify(post_data));
    putReq.end();
}

function getSkits(user){
    var http = require('http');
    var options = {
        host: "elasticsearch",
        port: "9200",
        path: "/skits/"+user+"/_search?q=*",
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        }
    };
    var getReq = http.request(options, function (res){
        res.setEncoding('utf8');
        res.on('data', function (chunk) {
            console.log('Response: ' + chunk);
        });
    });
    getReq.end();
}

function delSkit(user, id){
    var http = require('http');
    var options = {
        host: "elasticsearch",
        port: "9200",
        path: "/skits/"+user+"/+id",
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
        }
    };
    var delReq = http.request(options, function (res){
        res.setEncoding('utf8');
        res.on('data', function (chunk) {
            console.log('Response: ' + chunk);
        });
    });
    delReq.end();
}

var http = require('http');
var express = require('express');
var bodyParser = require('body-parser');
var app = express();

app.use(bodyParser.urlencoded());

app.listen(8888, function (err) {
    if (err) {
        throw err;
    }
});


app.post('/addSkit', function(req, res){
    var data = req.body.newSkit;
    var user = req.body.user;
    addSkit(user, data);
    console.log('Skit added');
    res.end();
});

app.post('/getSkit', function(req, res){
    var user = req.body.user;
    getSkit(user);
    console.log('Skits retrieved');
    res.end();
});

app.post('/delSkit', function(req, res){
    var id = req.body.delSkit;
    var user = req.body.user;
    delSkit(user, id);
    console.log('Skit removed');
    res.end();
});
