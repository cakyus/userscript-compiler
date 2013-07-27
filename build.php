<?php

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
