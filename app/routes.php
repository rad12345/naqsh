<?php

$homeroutes = array(
// admin

array('GET|POST', '/admin/uploader/upload', function() {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$uploader = new rad\app\lib\Upload;
$_FILES['upload'] = (isset($_FILES['upload']) ? $_FILES['upload'] : "");
$rad = $uploader->uploadimage($_FILES['upload'],"uploads/");
if(is_array($rad)){
echo '{
   "uploaded": 0,
     "error": {
        "message": "' . $rad[0] . '"
    }
}';
}else{
echo '{
    "uploaded": 1,
    "fileName": "foo.jpg",
    "url": "'.mem::get('config')->config['tpl']['baseurl'] . $rad.'"
}';
}


}),



array('GET|POST', '/admin/dabkarequest.html(|/[i:pageid])', function($pageid=1) {
$data = array();
$data['pageid'] = $pageid;

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
mem::get('tpl')->render('templates/new/admin/dabkarequest.html',$data);
}),


array('GET|POST', '/admin/dabkarequest.html/read/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$data['dabkarequest'] = rad\app\model\dabkarequest::getdabkarequest($id);
mem::get('tpl')->render('templates/new/admin/dabkarequest_read.html',$data);
}),


array('GET|POST', '/admin/dabkarequest.html/delete/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$delete = rad\app\model\dabkarequest::delete($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/dabkarequest.html");
}),





array('GET|POST', '/admin/membership.html(|/[i:pageid])', function($pageid=1) {
$data = array();
$data['pageid'] = $pageid;

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
mem::get('tpl')->render('templates/new/admin/membership.html',$data);
}),


array('GET|POST', '/admin/membership.html/read/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$data['membership'] = rad\app\model\membership::getmembership($id);
mem::get('tpl')->render('templates/new/admin/membership_read.html',$data);
}),


array('GET|POST', '/admin/membership.html/delete/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$delete = rad\app\model\membership::delete($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/membership.html");
}),














array('GET|POST', '/captcha.jpg', function() {


$code=rand(1000,9999);
$_SESSION["code"]=$code;
$im = imagecreatetruecolor(50, 35);
$bg = imagecolorallocate($im, 22, 86, 165); //background color blue
$fg = imagecolorallocate($im, 255, 255, 255);//text color white
imagefill($im, 0, 0, $bg);
imagestring($im, 5, 5, 5,  $code, $fg);
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
}),




array('GET|POST', '/admin/background.html', function() {
$data = array();

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if(isset($_POST['action'])){
$newwidget = rad\app\model\settings::updatebackground();
if($newwidget === true){
 header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/background.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;

}

}


mem::get('tpl')->render('templates/new/admin/background.html',$data);
}),




array('GET|POST', '/admin/aboutuswidget.html', function() {
$data = array();

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if(isset($_POST['action'])){
$newwidget = rad\app\model\settings::updateaboutus(1);
if($newwidget === true){

}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;

}

}


mem::get('tpl')->render('templates/new/admin/aboutuswidget.html',$data);
}),














array('GET|POST', '/admin/counter.html', function() {
$data = array();

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if(isset($_POST['action'])){
$newwidget = rad\app\model\counter::updatecounter(1);
if($newwidget === true){

}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;

}

}


mem::get('tpl')->render('templates/new/admin/counter.html',$data);
}),



array('GET|POST', '/admin/albums.html', function() {
$data = array();

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");

mem::get('tpl')->render('templates/new/admin/albums.html',$data);
}),


array('GET|POST', '/admin/albums.html/newalbum', function() {
$data = array();
$data['catinfo'] = array('title'=>'','englishtitle'=>'');
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if(isset($_POST['action'])){
$data['catinfo'] = array('title'=>$_POST['title'],'englishtitle'=>$_POST['englishtitle']);
$newwidget = rad\app\model\images::addcat();
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/albums.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;
}
}
mem::get('tpl')->render('templates/new/admin/albums_newalbum.html',$data);
}),



array('GET|POST', '/admin/albums.html/editcat/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$data['cat'] = \rad\app\model\images::getcat($id);
$data['catinfo'] = array('title'=>$data['cat']['album_arabictitle'],'englishtitle'=>$data['cat']['album_englishtitle']);
if(isset($_POST['action'])){
$data['catinfo'] = array('title'=>$_POST['title'],'englishtitle'=>$_POST['englishtitle']);
$newwidget = rad\app\model\images::updatecat($id);
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/albums.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;
}
}
mem::get('tpl')->render('templates/new/admin/albums_newalbum.html',$data);
}),


array('GET|POST', '/admin/albums.html/deletecat/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$delete = rad\app\model\images::deletecat($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/albums.html");
}),
































array('GET|POST', '/admin/managenews.html(|/[i:id])', function($id=1) {
$data = array();
$data['page_id'] = $id;
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");

mem::get('tpl')->render('templates/new/admin/managenews.html',$data);
}),

array('GET|POST', '/admin/managenews.html/deletenews/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$new = rad\app\model\news::deletenews($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/managenews.html");
}),



array('GET|POST', '/admin/managenews.html/editnews/[i:id]', function($id) {
$data = array();
$data['updatesubject'] = true;
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$newsgetone = rad\app\model\news::getonenews($id);
$data['subjectinfo'] = array('title'=>$newsgetone['news_title'],'desc'=>$newsgetone['news_shortcontent'],'content'=>$newsgetone['news_content'],'cat'=>$newsgetone['news_cat']);

if(isset($_POST['action'])){
$data['subjectinfo'] = array('cat'=>$_POST['cat'],'title'=>$_POST['title'],'content'=>$_POST['content'],'desc'=>$_POST['desc']);

$newwidget = rad\app\model\news::savesubject($id);
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/managenews.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;
}
}
mem::get('tpl')->render('templates/new/admin/managenews_new.html',$data);
}),



array('GET|POST', '/admin/managenews.html/new', function() {
$data = array();
$data['subjectinfo'] = array('title'=>'','desc'=>'','content'=>'','cat'=>'');
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");

if(isset($_POST['action'])){
$data['subjectinfo'] = array('cat'=>$_POST['cat'],'title'=>$_POST['title'],'content'=>$_POST['content'],'desc'=>$_POST['desc']);

$newwidget = rad\app\model\news::newsubject();
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/managenews.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;
}
}
mem::get('tpl')->render('templates/new/admin/managenews_new.html',$data);
}),





array('GET|POST', '/admin/administrators.html', function() {
$data = array();

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");

mem::get('tpl')->render('templates/new/admin/administrators.html',$data);
}),


array('GET|POST', '/admin/administrators.html/new', function() {
$data = array();
$data['catinfo'] = array('username'=>'');
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if(isset($_POST['action'])){
$data['catinfo'] = array('username'=>$_POST['username']);
$newwidget = rad\app\model\admins::adduser();
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/administrators.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;
}
}
mem::get('tpl')->render('templates/new/admin/admin_new.html',$data);
}),


array('GET|POST', '/admin/administrators.html/deleteadmin/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if($id !=1) rad\app\model\admins::deleteuser($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/administrators.html");
}),


array('GET|POST', '/admin/administrators.html/editadmin/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$data['admin'] = \rad\app\model\admins::getuser($id);
$data['catinfo'] = array('username'=>$data['admin']['user_email']);
if(isset($_POST['action'])){
$data['catinfo'] = array('username'=>$_POST['username']);
$newwidget = rad\app\model\admins::updateuser($id);
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/administrators.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;
}
}
mem::get('tpl')->render('templates/new/admin/admin_new.html',$data);
}),










array('GET|POST', '/admin/news.html', function() {
$data = array();

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");

mem::get('tpl')->render('templates/new/admin/news.html',$data);
}),


array('GET|POST', '/admin/news.html/addcat/[*:lang]', function($lang) {
$data = array();
$data['catinfo'] = array('title'=>'','desc'=>'','lang'=>$lang);
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if(isset($_POST['action'])){
$data['catinfo'] = array('title'=>$_POST['title'],'desc'=>$_POST['desc'],'lang'=>$lang);
$lang = ($lang == "arabic" ? "arabic" : "english");
$newwidget = rad\app\model\news::addcat($lang);
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/news.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;
}
}
mem::get('tpl')->render('templates/new/admin/news_addcat.html',$data);
}),



array('GET|POST', '/admin/news.html/editcat/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$data['cat'] = \rad\app\model\news::getcat($id);
$data['catinfo'] = array('title'=>$data['cat']['cat_title'],'desc'=>$data['cat']['cat_desc'],'lang'=>$data['cat']['cat_lang']);
if(isset($_POST['action'])){
$data['catinfo'] = array('title'=>$_POST['title'],'desc'=>$_POST['desc'],'lang'=>$data['cat']['cat_lang']);
$newwidget = rad\app\model\news::updatecat($id);
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/news.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;
}
}
mem::get('tpl')->render('templates/new/admin/news_addcat.html',$data);
}),

array('GET|POST', '/admin/news.html/deletecat/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$delete = rad\app\model\news::deletecat($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/news.html");
}),








array('GET|POST', '/admin/messages.html(|/[i:pageid])', function($pageid=1) {
$data = array();
$data['pageid'] = $pageid;

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
mem::get('tpl')->render('templates/new/admin/messages.html',$data);
}),


array('GET|POST', '/admin/messages.html/read/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$data['message'] = rad\app\model\messages::getmessage($id);
mem::get('tpl')->render('templates/new/admin/messages_read.html',$data);
}),


array('GET|POST', '/admin/messages.html/delete/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$delete = rad\app\model\messages::delete($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/messages.html");
}),










array('GET|POST', '/admin/videoportfolio.html(|/[i:pageid])', function($pageid=1) {
$data = array();
$data['pageid'] = $pageid;

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
mem::get('tpl')->render('templates/new/admin/videoportfolio.html',$data);
}),

array('GET|POST', '/admin/videoportfolio.html/delete/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$new = rad\app\model\videos::delete($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/videoportfolio.html");
}),


array('GET|POST', '/admin/videoportfolio.html/new', function() {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if(isset($_POST['action'])){
$newwidget = rad\app\model\videos::newvideo();
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/videoportfolio.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;

}

}
mem::get('tpl')->render('templates/new/admin/videoportfolio_new.html',$data);
}),




array('GET|POST', '/admin/portfolio.html/[i:albumid](|/[i:pageid])', function($albumid,$pageid=1) {
$data = array();
$data['pageid'] = $pageid;
$data['album'] = \rad\app\model\images::getcat($albumid);

$data['uploadertemplate'] = <<< END


<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
END;

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
mem::get('tpl')->render('templates/new/admin/portfolio.html',$data);
}),



array('GET|POST', '/admin/portfolio.html/[i:albumid]/upload', function($albumid) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$uploader = new \rad\app\lib\Upload;
$rad = $uploader->doupload();
foreach($uploader->response['files'] as $file){
if(!isset($file->error) && $_SERVER['REQUEST_METHOD'] == "POST") {

$rad = \rad\app\model\images::newimage($albumid,$file->name);
}

}
}),

array('GET|POST', '/admin/portfolio.html/[i:albumid]/delete/[i:id]', function($albumid,$id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$new = rad\app\model\images::delete($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/portfolio.html/".$albumid);
}),



array('GET|POST', '/admin/slideshow.html', function() {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
mem::get('tpl')->render('templates/new/admin/slideshow.html',$data);
}),



array('GET|POST', '/admin/slides.html/new/[*:lang]', function($lang) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if(isset($_POST['action'])){
$lang = ($lang == "arabic" ? "arabic" : "english");
$newwidget = rad\app\model\slide::newslide($lang);
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/slideshow.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;

}

}
mem::get('tpl')->render('templates/new/admin/slides_new.html',$data);
}),

array('GET|POST', '/admin/slide.html/delete/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$new = rad\app\model\slide::delete($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/slideshow.html");
}),


array('GET|POST', '/admin/widgets.html', function() {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if(isset($_POST) && count($_POST) > 0){
foreach ($_POST as $rowid=>$value){
$value = intval($value);
\mem::get('db')->table('rows')->eq('row_id', $rowid)->save(
array('row_order' => $value));

}
}

mem::get('tpl')->render('templates/new/admin/widgets.html',$data);
}),


array('GET|POST', '/admin/slides.html/crop/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$data['slideinfo'] = rad\app\model\slide::getslide($id);
$data['slideinfo2'] = getimagesize($data['slideinfo']['slide_image']);
if(isset($_POST['action'])){

	$targ_w =  $_POST['w'];
	$targ_h = $_POST['h'];
	$jpeg_quality = 100;

	$src = $data['slideinfo']['slide_image'];

	$img_r = imagecreatefromjpeg($src);

	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,intval($_POST['x']),intval($_POST['y']), $targ_w,$targ_h, intval($_POST['w']),intval($_POST['h']));


$savesrc = "uploads/portfolio/" . rad\app\lib\Upload::random_string(20) . ".jpg";
	imagejpeg($dst_r,$savesrc,$jpeg_quality);
mem::get('db')->table('slide')->eq('slide_id', $id)->save(array('slide_image'=>$savesrc));

header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/slideshow.html");

}
mem::get('tpl')->render('templates/new/admin/slides_crop.html',$data);
}),





array('GET|POST', '/admin/slides.html/edit/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$data['slideinfo'] = rad\app\model\slide::getslide($id);

if(isset($_POST['action'])){

$editslide = rad\app\model\slide::update($id);
if($editslide === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/slideshow.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;

}

}
mem::get('tpl')->render('templates/new/admin/slides_edit.html',$data);
}),




array('GET|POST', '/admin/sidewidgets.html', function() {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
mem::get('tpl')->render('templates/new/admin/sidewidgets.html',$data);
}),


array('GET|POST', '/admin/widgets.html/newwidget/[i:id](|/[i:widgetid])', function($id,$widgetid=0) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if(isset($_POST['action'])){

$newwidget = rad\app\model\widgets::newwidget($id,$widgetid);
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/widgets.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;

}

}
mem::get('tpl')->render('templates/new/admin/widgets_newwidget.html',$data);
}),







array('GET|POST', '/admin/sidewidgets.html/addwidget/[*:lang]', function($lang) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$lang = ($lang == "arabic" ? "arabic" : "english");
if(isset($_POST['action'])){

$newwidget = rad\app\model\widgets::newsidewidget($lang);
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/sidewidgets.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;

}

}
mem::get('tpl')->render('templates/new/admin/widgets_newwidget.html',$data);
}),



array('GET|POST', '/admin/widgets.html/editwidget/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$data['widgetinfo'] = rad\app\model\widgets::getwidget($id);

if(isset($_POST['action'])){

$newwidget = rad\app\model\widgets::update($id,$data['widgetinfo']['widget_rowid']);
if($newwidget === true){
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/widgets.html");
}else{
$data['alertmessage'] = true;
$data['messages'] = $newwidget;

}

}
mem::get('tpl')->render('templates/new/admin/widgets_edit.html',$data);
}),

array('GET|POST', '/admin/widgets.html/addrow/[*:lang]', function($lang) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$lang = ($lang == "arabic" ? "arabic" : "english");
$new = rad\app\model\widgets::newrow($lang);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/widgets.html");
}),



array('GET|POST', '/admin/widgets.html/deleterow/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$new = rad\app\model\widgets::deleterow($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/widgets.html");
}),

array('GET|POST', '/admin/widgets.html/deletewidget/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$new = rad\app\model\widgets::deletewidget($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/widgets.html");
}),

























array('GET', '/news.html/cat/[i:id](|/page/[i:pageid])', function($id,$pageid=1) {
$data = array();
$data['pageid'] = $pageid;
$data['catid'] = $id;
$data['cat'] = rad\app\model\news::getcat($id);
if(count($data['cat']) < 1) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."news.html");
mem::get('tpl')->render('templates/new/news_cat.html',$data);
}),

array('GET', '/news.html(|/page/[i:pageid])', function($pageid=1) {
$data = array();
$data['pageid'] = $pageid;

mem::get('tpl')->render('templates/new/news.html',$data);
}),


array('GET|POST', '/news.html/read/[i:id]', function($id) {
$data = array();
$data['onenews'] = rad\app\model\news::getonenews($id);
if(count($data['onenews']) < 1) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."news.html");
$data['cat'] = rad\app\model\news::getcat($data['onenews']['news_cat']);
if(isset($_POST['action'])){
$savecomment = rad\app\model\comments::save(3,$id);
if($savecomment === true){
$data['successmessage'] = true;

$data['messages'][] = (mem::get('config')->setting['setting_comnedaprov'] == 0 ? mem::get('lang')->container['commenthasbeemsentadmin'] : mem::get('lang')->container['commenthasbeemsent'] );

}else{
$data['alertmessage'] = true;
$data['messages'] = $savecomment;

}

}
$sideid = ($id > 5 ? $id -4 : $id);


$data['comments'] = rad\app\model\comments::getcomments(3,$id,1);
mem::get('tpl')->render('templates/new/news_read.html',$data);
}),


















array('GET|POST', '/contact.html', function() {
$data = array();
if(isset($_POST['action'])){


if(isset($_POST["captcha"])&&$_POST["captcha"]!=""&&$_SESSION["code"]==$_POST["captcha"]){
$_SESSION["code"] = rad\app\lib\Upload::random_string(20);

$is_valid = mem::get("validate")->validate($_POST, 
array(   'name' => 'required',
    'email' => 'required|valid_email',
    'phone' => 'required',
    'subject' => 'required',
    'message' => 'required'
) , // errors
array('namevalidate_required' => mem::get('lang')->container['writename'],
'emailvalidate_required' => mem::get('lang')->container['writeemail'],
'emailvalidate_valid_email' => mem::get('lang')->container['writevalidemail'],
'subjectvalidate_required' => mem::get('lang')->container['writesubject'],
'phonevalidate_required' => mem::get('lang')->container['writephone'],
'messagevalidate_required' => mem::get('lang')->container['writemessage']
)
);

}else{
$is_valid = array(mem::get('lang')->container['wrongcaptcha']);
}


if($is_valid === true){
\mem::get('db')->table('messages')->save(
array('message_phone'=>$_POST['phone'],'message_name'=>$_POST['name'],'message_email' => $_POST['email'],'message_subject' => $_POST['subject'],'message_message' => $_POST['message'],'message_time' => time()));
$data['successmessage'] = true;
$data['messages'][] = mem::get('lang')->container['messagehassent'];
$_POST['name'] = "";
$_POST['email'] = "";
$_POST['message'] = "";
$_POST['phone'] = "";
$_POST['subject'] = "";
}else{
$data['alertmessage'] = true;
$data['messages'] = $is_valid;
}

}

mem::get('tpl')->render('templates/new/contact.html',$data);
}),









array('GET', '/videoportfolio.html(|/page/[i:pageid])', function($pageid=1) {
$data = array();
$data['pageid'] = $pageid;

mem::get('tpl')->render('templates/new/videoportfolio.html',$data);
}),




array('GET|POST', '/videoportfolio.html/video/[i:id]', function($id) {
$data = array();
$data['video'] = rad\app\model\videos::getvideo($id);
if(count($data['video']) < 1) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."videoportfolio.html");
if(isset($_POST['action'])){
$savecomment = rad\app\model\comments::save(2,$id);
if($savecomment === true){
$data['successmessage'] = true;
$data['messages'][] = (mem::get('config')->setting['setting_comnedaprov'] == 0 ? mem::get('lang')->container['commenthasbeemsentadmin'] : mem::get('lang')->container['commenthasbeemsent'] );

}else{
$data['alertmessage'] = true;
$data['messages'] = $savecomment;

}

}


$data['sidebarvideos'] = rad\app\model\videos::getsvideos($id,4);
$data['comments'] = rad\app\model\comments::getcomments(2,$id,1);
mem::get('tpl')->render('templates/new/videoportfolio_view.html',$data);
}),





array('GET', '/albums.html', function() {
$data = array();

mem::get('tpl')->render('templates/new/albums.html',$data);
}),



array('GET', '/portfolio.html/[i:albumid](|/page/[i:pageid])', function($albumid,$pageid=1) {
$data = array();
$data['pageid'] = $pageid;
$data['album'] = rad\app\model\images::getcat($albumid);
if(count($data['album']) < 1) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."albums.html");

mem::get('tpl')->render('templates/new/portfolio.html',$data);
}),

array('GET|POST', '/portfolio.html/image/[i:image]', function($id) {
$data = array();
$data['image'] = rad\app\model\images::getimage($id);
$data['album'] = rad\app\model\images::getcat($data['image']['image_album']);
if(count($data['image']) < 1) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."albums.html");

if(isset($_POST['action'])){
$savecomment = rad\app\model\comments::save(1,$id);
if($savecomment === true){
$data['successmessage'] = true;
$data['messages'][] = (mem::get('config')->setting['setting_comnedaprov'] == 0 ? mem::get('lang')->container['commenthasbeemsentadmin'] : mem::get('lang')->container['commenthasbeemsent'] );

}else{
$data['alertmessage'] = true;
$data['messages'] = $savecomment;

}

}
$sideid = $id -4;

$data['sidebarimages'] = rad\app\model\images::getsimages($sideid,8);
$data['comments'] = rad\app\model\comments::getcomments(1,$id,1);
mem::get('tpl')->render('templates/new/portfolio_view.html',$data);
}),




array('GET|POST', '/admin/settings.html', function() {
$data = array();

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if(isset($_POST['action'])){
mem::get('db')->table('settings')->eq('setting_lang',$_POST['action'])->save(
array(
'setting_title' => $_POST['title'],
'setting_desc' => $_POST['desc'],
'setting_phone' => $_POST['phone'],
'setting_fax' => $_POST['fax'],
'setting_email' => $_POST['email'],
'setting_video' => $_POST['video'],
'setting_mobile' => $_POST['mobile'],
'setting_facebook' => $_POST['facebook'],
'setting_twitter' => $_POST['twitter'],
'setting_youtube' => $_POST['youtube'],
'setting_address' => $_POST['address']));
}



mem::get('tpl')->render('templates/new/admin/settings.html',$data);
}),







array('GET|POST', '/admin(|/|/index.html)(|/[i:id])', function($id=1) {
$data = array();
$data['page_id'] = $id;
if(isset($_POST['action'])){
$save = rad\app\model\settings::updatecomments($_POST['pageimagecat']);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/index.html");
}

if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
mem::get('tpl')->render('templates/new/admin/homepage.html',$data);
}),



array('GET|POST', '/admin/index.html/deletec/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$new = rad\app\model\comments::delete($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/index.html");
}),

array('GET|POST', '/admin/index.html/aprovc/[i:id]', function($id) {
$data = array();
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
$new = rad\app\model\comments::aprov($id);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/index.html");
}),





array('GET|POST', '/admin/pages.html(|/[*:action]/[i:sid])', function($action="",$id="") {
if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
if(isset($_POST['action']) && $_POST['action'] == "saveorder"){
unset($_POST['action']);
foreach ($_POST as $rowid=>$value){
$value = intval($value);
\mem::get('db')->table('pages')->eq('page_id', $rowid)->save(
array('page_order' => $value));

}
}




$data = array();
$data['pageid'] = $id;
$data['emptypageinfo'] = array('page_type'=>'','page_imagecat'=>'','page_showinm'=>'','page_uname'=>'','page_id'=>'','page_lang'=>'','page_name'=>'','page_parent'=>'','page_content'=>'','page_desc'=>'');
$data['pageinfo'] = $data['emptypageinfo'];


$_POST['action'] = (isset($_POST['action']) ? $_POST['action'] : false);
if($_POST['action'] == "newpage" || $_POST['action'] == "editpage"){
$data['pageinfo'] = array('page_imagecat'=>$_POST['pageimagecat'],'page_type'=>$_POST['pagetype'],'page_showinm'=>$_POST['pageshowinm'],'page_uname'=>$_POST['pageuname'],'page_id'=>$id,'page_name'=>$_POST['pagetitle'],'page_parent'=>$_POST['mainpage'],'page_content'=>$_POST['pagecontents'],'page_desc'=>$_POST['pagedesc'],'page_lang'=>$_POST['pagelang']);
if($_POST['action'] == "newpage"){
$newpage = rad\app\model\pages::newpage();
if($newpage === true){
$data['pageinfo'] = $data['emptypageinfo'];
$data['successmessage'] = true;
$data['messages'][] = "تم اصافة الصفحة بنجاح";

}else{
$data['hidepages'] = true;
$data['alertmessage'] = true;
$data['messages'] = $newpage;

}
}else{
$editpage = rad\app\model\pages::updatepage($id);

if($editpage === true){
$data['pageinfo'] = $data['emptypageinfo'];
$data['successmessage'] = true;
$data['messages'][] = "تم تعديل الصغحة بنجاح";

}else{

$data['editpage'] = true;
$data['hidepages'] = true;
$data['alertmessage'] = true;
$data['messages'] = $editpage;

}


}
}elseif($action == "edit"){
$data['pageinfo'] = rad\app\model\pages::getpage($id);
$data['editpage'] = true;
$data['hidepages'] = true;




}elseif($action == "delete"){
rad\app\model\pages::deletepage($id);
$data['successmessage'] = true;
$data['messages'][] = "تم حذف الصفحة بنجاح";

}




if(!mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin/login.html");
mem::get('tpl')->render('templates/new/admin/pages.html',$data);
}),



array('GET|POST', '/admin/login.html', function() {
$data = array();
if(mem::get('user')->islogged()) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$login = mem::get('user')->login();
if($login === true) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin");
$data['errors'] = $login;
}
mem::get('tpl')->render('templates/new/admin/login.html',$data);
}),

array('GET', '/admin/logout', function() {
if(mem::get('user')->islogged()) mem::get('user')->logout();
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."admin" );

}),









array('GET|POST', '/index.html/lang/[*:lang]', function($lang) {
mem::get('lang')->setlang($lang);
header("Location:". mem::get('config')->config['tpl']['baseurl'] ."lang-". $lang .".html");

}),
array('GET', '/lang-[*:lang].html', function($lang) {
mem::get('tpl')->render('templates/new/homepage.html',array('content'=>'block_content.html'));
}),



// home 
array('GET', '/(|index.html)', function() {
mem::get('tpl')->render('templates/new/homepage.html',array('content'=>'block_content.html'));
}),


// contact
array('GET', '/contact.html', function() {
mem::get('tpl')->render('templates/contact.html');
      
}),

// about
array('GET', '/about.html', function() {
mem::get('tpl')->render('templates/about.html');
      
}),

// page view
array('GET|POST', '/page/[s:id].html', function( $id ) {
$data['viewpage'] = rad\app\model\pages::getupage($id);
if(!isset($data['viewpage'])) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."index.html");
$data['activepageid'] = $data['viewpage']['page_id'];
$data['viewsubpages'] = rad\app\model\pages::get($data['viewpage']['page_id']);
$data['viewmainpage'] = $data['viewpage'];
mem::get('tpl')->render('templates/new/pageview.html',$data);
}),


// page view
array('GET|POST', '/page/[i:id].html', function( $id ) {
$data['viewpage'] = rad\app\model\pages::getpage($id);
if(!isset($data['viewpage'])) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."index.html");
$data['activepageid'] = $data['viewpage']['page_id'];
$data['viewsubpages'] = rad\app\model\pages::get($id);
$data['viewmainpage'] = $data['viewpage'];
mem::get('tpl')->render('templates/new/pageview.html',$data);
}),

// sub page view
array('GET|POST', '/page/[i:id]/[i:sid].html', function( $id ,$sid) {
$data['viewpage'] = rad\app\model\pages::getpage($sid);
if(!isset($data['viewpage'])) header("Location:". mem::get('config')->config['tpl']['baseurl'] ."index.html");
$data['activepageid'] = $id;
$data['viewsubpages'] = rad\app\model\pages::get($id);
$data['viewmainpage'] = rad\app\model\pages::getpage($id);
mem::get('tpl')->render('templates/new/pageview.html',$data);
})

);



$this->addRoutes($homeroutes);

?>