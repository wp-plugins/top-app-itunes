<?php
/*
Plugin Name: Top App 
Plugin URI: http://foolish-media.com/top-applications-appstore-plugin-wordpress/
Description: Top App est un plugin qui affiche en sidebar le top des applications iPad de l'AppStore avec votre lien d'affiliation 
Version: 1.1.1
Author: <a href="http://www.foolish-media.com/">Jean Baptiste Marchand-Arvier</a>
Author URI: http://www.foolish-media.com
*/

load_plugin_textdomain('topapp','/wp-content/plugins/top-app-itunes/lang/');

function topapp_admin() {  
    include('topapp_admin.php');  
} 



function topapp_admin_actions() {  
    add_options_page("Top App Configuration", "Top App Configuration", 1, "topapp_admin", "topapp_admin");  
} 
 
  
add_action('admin_menu', 'topapp_admin_actions');  

function clean_text($text, $length = 0) {
    $html = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    $text = strip_tags($html);
    if ($length > 0 && strlen($text) > $length) {
        $cut_point = strrpos(substr($text, 0, $length), ' ');
        $text = substr($text, 0, $cut_point) . '…';
    }
    $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
    return $text;
}
function top_app(){
$plugin_dir_path = dirname(__FILE__);
$cat_config1= get_option ('topapp_cat'); 
$url_lang= __('url-langue','topapp'); 
	if ($cat_config1 =='iPad') {
		$url_p="ipad";}
	elseif ($cat_config1 =='iPhone'){
	
		$url_p="";}
		
	else {
	
		$url_p="";}

$cache_time = 3600*24; // 24 hours

$cache_file = $plugin_dir_path.'/cache/xml_cached.rss'; //like a noob
$timedif = @(time() - filemtime($cache_file));

if (file_exists($cache_file) && $timedif < $cache_time) {
    $applefeed = file_get_contents($cache_file);
} else {
    $applefeed = file_get_contents('http://itunes.apple.com/'.$url_lang.'/rss/toppaid'.$url_p.'applications/limit=10/xml');
    if ($f = @fopen($cache_file, 'w')) {
        fwrite ($f, $applefeed, strlen($applefeed));
        fclose($f);
    }
}


//$applefeed = file_get_contents('http://itunes.apple.com/'.$url_lang.'/rss/toppaid'.$url_p.'applications/limit=10/xml');
$feed = new SimpleXMLElement($applefeed);

foreach ($feed->entry as $entry) {
	$namespaces = $entry->getNameSpaces(true);
	
//url tradedoubler à insérer 
	//$affi='http://clk.tradedoubler.com/click?p=23753&a=2076412&url=';
//url tradedoubler à insérer
	
	$cat= utf8_decode ($entry->category ['label']);
	$link= $entry->link ['href'];
		
	$im = $entry->children($namespaces['im']);
	//$name_utf8=utf8_decode($im->name);
	$name=clean_text($im->name, 40);
	
	$description=clean_text($entry->summary,60);
	$affi= get_option('topapp_affi');
		if ($affi == NULL) {
		$affi="http://clk.tradedoubler.com/click?p=23753&a=2076412&url="; } //like a boss
	

		
	$titre_widget_show= get_option('topapp_titre_widget');
	//$cat_config1= get_option ('topapp_cat'); 
	

	echo "

	<table width ='250'border='0' cellspacing='0' cellpadding='0' class='table table-bordered'>



<tr>
	<td>
		 <div class=''>
		 	<ul style='list-style: none; border-bottom: 1px solid #DDD;'>
		<li style='position: relative; 
    
    padding: 5px 0px 5px 65px !important;
    '> <a href='$affi$link'><img class='' title='$name'style=' -webkit-border-radius: 11px; -moz-border-radius: 11px; position: absolute;
    float: left;
    display: inline;
    
    width: 50px;
    top: 5px;
    left: 10px;'src='$im->image'  /></a>
<font color='#338998'><b><a style='color: black;
    float: left;
    display: inline;
    font-weight:700;' title='$name'href='$affi$link'>$name </a> </b></font></a><br />

<div class='' >$description</div></li>

</div>
</td>
    </tr>
</ul>
<div style='font-size: small;
    color: gray !important;
    float: left;
    display: inline;
border-bottom : 1px solid #DDD;'></div>

</table>	
	";
}
	$support_us= get_option('topapp_soutien');
		if ($support_us =="Oui"){
		
		echo '<br/><small>Widget par <a href="http://www.ipad-apple.net/">blog iPad</a></small>';
		}
		else if ($support_us=="Non"){
		
		echo '';
		}
		else {
		
		echo '<br/><small>Widget par <a href="http://www.ipad-apple.net/">blog iPad</a></small>';
		}



}



//widgétise le plugin: 
function top_app_sidebar($args) {
	extract ($args);
	echo $before_widget;
	echo $before_title;?>	Top App <?php echo $titre_widget_show; ?><?php echo $after_title;top_app();
	echo $after_widget;
	}
	
function top_app_init()
{
	register_sidebar_widget (__('Afficher top App'), 'top_app_sidebar');
}
add_action ("plugins_loaded", "top_app_init");
	//if (!function_exists('register_sidebar_widget')) {
		//return;
	//}
	//register_sidebar_widget('Afficher top App', 'top_app');
//}

//add_action('init','top_app_sidebar');

?>
