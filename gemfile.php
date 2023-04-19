<?php
/**
* Plugin Name: Gemfile Generator
* Plugin URI: https://www.your-site.com/
* Description: Test.
* Version: 0.1
* Author: Phie
* Author URI: https://www.your-site.com/
**/
require_once(plugin_dir_path(__FILE__) . '/vendor/autoload.php');
use League\HTMLToMarkdown\HtmlConverter;

function getFileName($post){
 return $post->ID."-".sanitize_file_name($post->post_title).".gmi";

}

function createGmiFromPost($post) {
$converter = new HtmlConverter();
$markdown = strip_tags($converter->convert($post->post_content));

mkdir("gemfiles");
//ob_start();
//var_dump($post->post_content);
//$data = ob_get_clean();
$finalText="# ".$post->post_title."\n".$post->post_date."\n by ".get_author_name($post->post_author)."\n\n".$markdown;
$fname = getFileName($post);
$fp = fopen("gemfiles/".$fname, "w");
fwrite($fp, $finalText);
fclose($fp);

}

function wporg_custom( $post_id, $post ) {
    // do something
createGmiFromPost($post);
$index = file_get_contents("gemfiles/index_header.gmi");

$posts = get_posts( array(
	'numberposts'	=> -1
));
foreach ($posts as $p) {
//createGmiFromPost($p);
$fname = getFileName($p);
$index .="\n=> ".$fname." ".$p->post_title." (".$p->post_date.")\n";
}
$fp = fopen("gemfiles/index.gmi", "w");
fwrite($fp, $index);
fclose($fp);

}
add_action( 'save_post', 'wporg_custom', 10, 2);
