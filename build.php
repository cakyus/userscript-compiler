<?php

define('PROJECT_DIR', getcwd());
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
		debug_print('write output file', OUTPUT_FILE);
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
			debug_print('WARNING', 'file not found', $path);
			return '';
		}
		
		$content = file_get_contents($path);
		
		if (empty($extension)) {
			// assume this is string
			return $this->parseText($content);
		} elseif ($extension == 'js') {
			if (BUILD_MINI) {
				return $this->parseJavascript($content);
			} else {
				return "\n// <!-- $file\n"
					.$this->parseJavascript($content)
					."\n// $file -->\n"
					;
			}
		} elseif ($extension == 'html') {
			return $this->parseHTML($content);
		} elseif ($extension == 'css') {
			return $this->parseHTML($content);
		} elseif (in_array($extension, array('jpg','png'))) {
			return $this->parseData('image/'.$extension,$content);
		} else {
			debug_print('WARNING', 'unknown extension.', $extension);
			return '';
		}
	}
	
	public function parseStylesheet($content) {
		return $this->parseText($content);
	}
	
	public function parseHTML($content) {
		return $this->parseText($content);
	}
	
	public function parseText($content) {
		return "'".preg_replace("/\n/", "'\n+'", $content)."';";
	}
	
	/**
	 * Data URI Scheme
	 * @see https://en.wikipedia.org/wiki/Data_URI_scheme
	 **/
	
	public function parseData($contentType,$content) {
		
		preg_match_all("/.{0,72}/s", base64_encode($content), $match);
		$content = implode("\n", $match[0]);
		
		return "'data:$contentType;base64,'\n+"
			.$this->parseText($content)
			;
	}
}

function debug_print() {
	echo date("H:i:s ");
	echo implode(" ", func_get_args());
	echo "\n";
}

$builder = new Builder;
$builder->start();
