<?php
/*
Plugin Name: Top App 
Plugin URI: http://foolish-media.com/top-applications-appstore-plugin-wordpress/
Description: Top App est un plugin qui affiche en sidebar le top des applications iPad de l'AppStore avec votre lien d'affiliation 
Version: 0.5.0
Author: <a href="http://www.foolish-media.com/">Jean Baptiste Marchand-Arvier</a>
Author URI: http://www.foolish-media.com
*/


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



$cache_time = 3600*24; // 24 hours

$cache_file = $_SERVER['DOCUMENT_ROOT'].'/cache/xml_cached.rss';
$timedif = @(time() - filemtime($cache_file));

if (file_exists($cache_file) && $timedif < $cache_time) {
    $applefeed = file_get_contents($cache_file);
} else {
    $applefeed = file_get_contents('http://itunes.apple.com/fr/rss/toppaidipadapplications/limit=10/xml');
    if ($f = @fopen($cache_file, 'w')) {
        fwrite ($f, $applefeed, strlen($applefeed));
        fclose($f);
    }
}


$applefeed = file_get_contents('http://itunes.apple.com/fr/rss/toppaidipadapplications/limit=10/xml');
$feed = new SimpleXMLElement($applefeed);

foreach ($feed->entry as $entry) {
	$namespaces = $entry->getNameSpaces(true);
	
//url tradedoubler à insérer 
	$affi='http://clk.tradedoubler.com/click?p=23753&a=2076412&url=';
//url tradedoubler à insérer
	
	$cat= utf8_decode ($entry->category ['label']);
	$link= $entry->link ['href'];
		
	$im = $entry->children($namespaces['im']);
	//$name_utf8=utf8_decode($im->name);
	$name=clean_text($im->name, 40);
	$description=clean_text($entry->summary,100);
	
	echo "

	<table class='table table-bordered'>
<tbody>


<tr style='border-bottom: 1px solid #000;'>
<td width='53px' valign='top'><a href='$affi$link'><img style=' -webkit-border-radius: 11px; -moz-border-radius: 11px; 'src='$im->image'  /></a></td>
<td class='desc'  ><font color='#338998'><b><a href='$affi$link'>$name </a> </b></font></a><br />$description</td>

</tr>
<div class='border' style='border-bottom : 1px solid #DDD;'></div>
</tbody>
</table>	
	";
}
}



//widgétise le plugin: les tweets peuvent maintenant être insérés dans une sidebar.
function top_app_sidebar() {
	if (!function_exists('register_sidebar_widget')) {
		return;
	}
	register_sidebar_widget('Afficher top App', 'top_app');
}

add_action('init','top_app_sidebar');

?>
