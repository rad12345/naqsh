<?php
namespace rad\app\model;

class counter{
public static function getcounter($id=1){
return \mem::get('db')->table('counter')->eq('counter_id', $id)->findOne();
}

public static function updatecounter($id=1){
$upload =  \rad\app\lib\Upload::uploadimage($_FILES['slideimage'],"counter/");
if(is_array($upload)){
\mem::get('db')->table('counter')->eq('counter_id', $id)->save(
array(
'counter_arabictitle' => $_POST['arabictitle'],
'counter_englishtitle' => $_POST['englishtitle'],
'counter_arabicdesc' => $_POST['arabicdesc'],
'counter_englishdesc' => $_POST['englishdesc'],
'counter_hour' => $_POST['hour'],
'counter_day' => $_POST['day'],
'counter_month' => $_POST['month'],
'counter_year' => $_POST['year']
));
return true;
}else{
\mem::get('db')->table('counter')->eq('counter_id', $id)->save(
array(
'counter_arabictitle' => $_POST['arabictitle'],
'counter_englishtitle' => $_POST['englishtitle'],
'counter_arabicdesc' => $_POST['arabicdesc'],
'counter_englishdesc' => $_POST['englishdesc'],
'counter_hour' => $_POST['hour'],
'counter_day' => $_POST['day'],
'counter_month' => $_POST['month'],
'counter_year' => $_POST['year'],
'counter_image' => $upload
));
return true;
}

}










}

?>