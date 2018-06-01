<?php
namespace rad\system;
use rad\system\AltoRouter as router;
class App extends router {
	protected $router = '';
	public $settings = array();
	
public function __construct($settings){
$this->router = new router;
$this->settings = $settings;

}


function __get($class){
if(isset($this->$class)) return $this->$class;
return \mem::get($class);
return false;
}

public function run(){
include($this->settings['appdir']."/start.php");
include($this->settings['appdir']."/routes.php");
// match current request url
$match = $this->match();

// call closure or throw 404 status
if( $match && is_callable( $match['target'] ) ) {
$match['target'] = $match['target'];

	call_user_func_array( $match['target'], $match['params'] ); 
} else {
header("HTTP/1.0 404 Not Found");
echo "404 Not Found";

}

}


public function _404(){
header("HTTP/1.0 404 Not Found");
echo "404 Not Found";
}


}

?>