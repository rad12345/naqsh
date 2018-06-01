<?php
class mem {
 private static $objects = array();    
    
    /**
     * Private constructor to prevent it being created directly
     * @access private
     */
    private function __construct()
    {
     
    }

    /**
     * Stores an object in the registry
     * @param String $object the name of the object
     * @param String $key the key for the array
     * @return void
     */
    public static function set($aclass,$key)
    {
		$class = (is_array($aclass) ? $aclass[0] : $aclass);
		if (isset(self::$objects[ $key ]))	return self::$objects[ $key ];
			self::$objects[ $key ] = $class;
			if(is_array($aclass)) call_user_func_array(array(self::$objects[ $key ],$aclass[1]),$aclass[2]);

    }
    
    public static function get( $key )
    {
        if( is_object ( self::$objects[ $key ] ) )
        {
            return self::$objects[ $key ];
        }
    }
     
}
?>