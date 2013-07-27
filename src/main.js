/*
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */

// ==UserScript==
// @id             5fcd7c57-a60d-4a61-b9d6-4e35ce055ad8
// @name           Userscript Compiler
// @include        http://127.0.0.1/p/userscript-compiler/
// @run-at         document-end
// @version        0.0.1
// ==/UserScript==

// write the template
var content = require('template.html');
document.body.innerHTML = content;

// add stylesheet
var style = document.createElement('style');
style.textContent = require('style.css');
var head = document.getElementsByTagName('head');
head[0].appendChild(style);

// some javascript code
require('hello.js');
