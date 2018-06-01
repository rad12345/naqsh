<?php
include "appconfig.php";
include 'lib/Latte/latte.php';
include 'lib/PicoDb/dbloader.php';

// Create the controller, this is reusable

mem::set(new rad\app\lib\Gump,"validate");
mem::set(new PicoDb\Database($config['db']),"db");
mem::set(new Latte\Engine,"tpl");
mem::set(new rad\app\lib\Auth,"user");
mem::set(new rad\app\lib\SessionHandler('quasar_sessions'),"Session");
mem::set(new rad\app\lib\config,"config");
mem::set(new rad\app\lib\lang,"lang");
mem::get('tpl')->publicvars['lang'] = mem::get('lang');
mem::get('tpl')->publicvars['sitesettings'] = rad\app\model\settings::getsettings($_SESSION['lang']);
mem::get('tpl')->setTempDirectory($config['tpl']['tmpdir']);
mem::get('tpl')->baseurl = $config['tpl']['baseurl'];
mem::get('tpl')->tpl_dir = $config['tpl']['tpl_dir'];



mem::get('config')->config = $config;
mem::get('config')->setting = mem::get('tpl')->publicvars['sitesettings'];





/*
	$errMsg = '';

	if(mem::get('user')->log->hasError()){
		$errMsg = mem::get('user')->log->getErrors();
		$errMsg = $errMsg[0];
		
	}
	echo $errMsg;
print_r(mem::get('user')->log->getFormErrors());
*/
//mem::get(db)
?>