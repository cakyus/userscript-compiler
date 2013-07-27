Userscript Compiler
===================

Compile javascript, stylesheet, html files into 
a single userscript file.

Usage
-----

    php build.php

Example
-------

Execute javascript file

    require('hello.js');

Assign content of file into a variable

    var html = require('template.html');
    var style = require('style.css');
    var data = require('Octopus.jpg');

See src/main.js for complete example

Requirements
------------

* PHP 5.3+
