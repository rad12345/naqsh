<?php

namespace rad\app\lib;


/**
 * Before using this class make sure to create the database table, source:
 * 

  CREATE TABLE `quasar_sessions` (
  `id` varchar(32) NOT NULL,
  `data` text NOT NULL,
  `accessed` int(10) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `accessed` (`accessed`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 * 
 */
class SessionHandler  {

	/**
	 * @var Database
	 */
	protected $table;
	public function __construct($tableName) {
		$this->table = $tableName;
		$this->pdo = \mem::get('db')->getDriver()->pdo;
		
if(!isset($_COOKIE['radsesstionid'])){
$_expires = pow(2,31)-1;
$this->sessionid = $this->random_string(25);
setcookie( 'radsesstionid',$this->sessionid , $_expires );
}else{
$this->sessionid = $_COOKIE['radsesstionid'];
}

	            $this->security_code = $_SERVER['HTTP_USER_AGENT'];
            session_set_save_handler(
                array(&$this, 'open'),
                array(&$this, 'close'),
                array(&$this, 'read'),
                array(&$this, 'write'),
                array(&$this, 'destroy'),
                array(&$this, 'gc')
            );

            // start the session
            session_start();
            
	}
	
public static function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}
	
	

	public function close() {
		return true;
	}

	public function gc($maxlifetime) {

		return \mem::get('db')->table($this->table)->lt('accessed', $_SERVER['REQUEST_TIME'] - $maxlifetime)->remove();
	}

	public function open($save_path, $name) {
		
		return true;
	}

	public function read($session_id) {
			$data = "";
    $data = \mem::get('db')->table($this->table)->eq('id', $this->sessionid)->eq('hash', md5($this->security_code))->findOne();
		if ($data) $data = $data['data'];
   
		return $data;
	}

	public function write($session_id, $session_data) {
		$sql = 'REPLACE INTO ' . $this->table . ' (id, data, accessed, hash) VALUES (?, ?, ?, ?)';
		
		return $this->pdo->prepare($sql)->execute(array(
					$this->sessionid, $session_data, $_SERVER['REQUEST_TIME'], md5($this->security_code)
		));
		
	}

	public function destroy($session_id) {
		return \mem::get('db')->table($this->table)->eq('id', $this->sessionid)->remove();
	}

}
