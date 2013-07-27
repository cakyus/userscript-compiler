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
		$content = $this->parseJavascript(MAIN_FILE);
		file_put_contents(OUTPUT_FILE, $content);
		debug_print('build completed');
	}
	
	public function parseJavascript($file) {
		
		debug_print('parseJavascript '.$file);
		
		if (is_file($file) == false) {
			debug_print('WARNING', 'File not found');
			return '';
		}
		
		$content = file_get_contents($file);
		
		return $content;
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
