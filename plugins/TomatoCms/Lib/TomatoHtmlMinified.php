<?PHP
class TomatoHtmlMinified{

	public static function minified($html){
		$search = array(
	        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
	        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
	        '/(\s)+/s'       // shorten multiple whitespace sequences
	    );

	    $replace = array(
	        '>',
	        '<',
	        '\\1'
	    );

	    $buffer = preg_replace($search, $replace, $html);

	    return $buffer;
	}

}