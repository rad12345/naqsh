<?php
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);

if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}

   
       ini_set('display_errors', 1);
error_reporting(~0);
 

$starttime = microtime();
$startarray = explode(" ", $starttime);
$starttime = $startarray[1] + $startarray[0];





require_once("system/boot.php");
$app = new rad\system\app($config);

$app->setBasePath($config['basebath']);




$app->run();






    function echo_memory_usage() { 
        $mem_usage = memory_get_usage(true); 
        
        if ($mem_usage < 1024) 
            echo $mem_usage." bytes"; 
        elseif ($mem_usage < 1048576) 
            echo round($mem_usage/1024,2)." kilobytes"; 
        else 
            echo round($mem_usage/1048576,2)." megabytes"; 
            
        echo "<br/>"; 
    } 




$endtime = microtime();
$endarray = explode(" ", $endtime);
$endtime = $endarray[1] + $endarray[0];
$totaltime = $endtime - $starttime; 
$totaltime = round($totaltime,5);
// echo "This page loaded in $totaltime seconds.<br>";
//echo_memory_usage() ;

?>