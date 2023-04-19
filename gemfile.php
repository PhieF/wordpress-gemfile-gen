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
function wporg_custom( $post_id, $post ) {
    // do something
$converter = new HtmlConverter();
$markdown = $converter->convert($post->post_content);

mkdir("gemfiles");
//ob_start();
//var_dump($post->post_content);
//$data = ob_get_clean();
$finalText="# ".$post->post_title."\n\n".$markdown;

$fp = fopen("gemfiles/".$post->ID."-".$post->post_title.".gemi", "w");
fwrite($fp, $finalText);
fclose($fp);
}
add_action( 'save_post', 'wporg_custom', 10, 2);
