<?php

namespace rad\app\lib;
class lang implements \ArrayAccess {
public $mainlang = "arabic";
    public $container = array();
	public function __construct() {
       if(!isset($_SESSION['lang'])) $_SESSION['lang'] = $this->mainlang;
       $classname = "rad\lang\\" . $_SESSION['lang'];
       $this->container = $classname::get();             
	}
	function setlang($lang){
       if(file_exists("lang\\". $lang .".php")){
       $_SESSION['lang'] = $lang;
       }else{
       $_SESSION['lang'] = $lang;

       }
	}
public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }	
	

}
