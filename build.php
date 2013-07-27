<?php

define('PROJECT_DIR', __DIR__);
define('SOURCE_DIR', PROJECT_DIR.'/src');
define('OUTPUT_DIR', PROJECT_DIR.'/build');
define('MAIN_FILE', SOURCE_DIR.'/main.js');
define('OUTPUT_FILE', OUTPUT_DIR.'/build.user.js');

// -- CODE --

class Builder {
	
	public function start() {
		debug_print('build starting ..');
		// @todo do something
		debug_print('build completed');
	}
}


// -- MAIN --

function debug_print() {
	echo date("H:i:s ");
	echo implode(" ", func_get_args());
	echo "\n";
}

$debug = debug_backtrace();
if (empty($debug)) {
	$builder = new Builder;
	$builder->start();
}
