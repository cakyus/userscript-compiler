<?php

define('PROJECT_DIR', __DIR__);
define('SOURCE_DIR', PROJECT_DIR.'/src');
define('OUTPUT_DIR', PROJECT_DIR.'/build');
define('MAIN_FILE', SOURCE_DIR.'/main.js');
define('OUTPUT_FILE', OUTPUT_DIR.'/build.user.js');
define('BUILD_MINI', false);

// -- CODE --

class Builder {
	
	public function start() {
		debug_print('build starting ..');
		$content = $this->requireJavascript(MAIN_FILE);
		debug_print('Write output file', OUTPUT_FILE);
		file_put_contents(OUTPUT_FILE, $content);
		debug_print('build completed');
	}
	
	public function requireJavascript($file) {
		
		debug_print('requireJavascript '.$file);
		
		if (is_file($file) == false) {
			debug_print('WARNING', 'File not found');
			return '';
		}
		
		return $this->parseJavascript(
				file_get_contents($file)
			);
	}
	
	public function parseJavascript($content) {
		return preg_replace_callback(
			"/require\('((.+?)\.?([^\.]+)?)'\);/"
			, array($this, 'parseRequire')
			, $content
			);
	}
	
	
	public function parseRequire($match) {
		
		$file = $match[1];
		$path = SOURCE_DIR.'/'.$match[1];
		if (isset($match[3])) {
			$extension = strtolower($match[3]);
		} else {
			$extension = '';
		}
		
		debug_print('parseRequire', $path);
		
		if (is_file($path) == false) {
			debug_print('File not found', $path);
			return '';
		}
		
		$content = file_get_contents($path);
		
		if (empty($extension)) {
			// assume this is string
		} elseif ($extension == 'js') {
			if (BUILD_MINI) {
				return $this->parseJavascript($content);
			} else {
				return "\n// <!-- $file\n"
					.$this->parseJavascript($content)
					."\n// $file -->\n"
					;
			}
		} else {
			debug_print('Unknown file extension', $extension);
			return '';
		}
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
