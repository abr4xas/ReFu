<?php
/*
Plugin Name: Functions
Description: Alternative <code>functions.php</code>  file of wordpress themes.
Contributors: abr4xas
Donate link: http://abr4xas.org/refu
Tags: functions
Version: 3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


// custom var

$url_feed = 'Put your feed url here';

////////////////////////////////////////////////////////
////////////////////////////////////////////////////////

// Custom feed link
function custom_feed_link($output, $feed) {

$feed_url = $url_feed;

$feed_array = array('rss' => $feed_url, 'rss2' => $feed_url, 'atom' => $feed_url, 'rdf' => $feed_url, 'comments_rss2' => '');
$feed_array[$feed] = $feed_url;
$output = $feed_array[$feed];

return $output;
}

function other_feed_links($link) {

$link = $url_feed;
return $link;

}
//Add our functions to the specific filters
add_filter('feed_link','custom_feed_link', 1, 2);
add_filter('category_feed_link', 'other_feed_links');
add_filter('author_feed_link', 'other_feed_links');
add_filter('tag_feed_link','other_feed_links');
add_filter('search_feed_link','other_feed_links');

// Slideshare to oEmbed
function oembed_slideshare(){
wp_oembed_add_provider( 'http://www.slideshare.net/*', 'http://api.embed.ly/v1/api/oembed');
}
add_action('init','oembed_slideshare');

// Custom_URL_LoginLogo
add_action( 'login_headerurl', 'my_custom_login_url' );
function my_custom_login_url() {
return site_url();
}

// Custom_ALT_text_LoginLogo
add_action("login_headertitle","my_custom_login_title");
function my_custom_login_title()
{
return get_bloginfo ( 'description' );
}

// Custom_social_fields
function add_redessociales_contactmethod( $contactmethods ) {
// add Twitter
  $contactmethods['twitter'] = 'Twitter';
// add Facebook
  $contactmethods['facebook'] = 'Facebook';
// remove Yahoo, IM, AIM y Jabber
  unset($contactmethods['yim']);
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  return $contactmethods;
}
add_filter('user_contactmethods','add_redessociales_contactmethod',10,1);

// Add new uploads files types
 add_filter ( 'upload_mimes' , 'masMimes' ) ;
 function masMimes ( $mimes )
 {
	 $mimes = array_merge ( $mimes , array (
		 'pages|numbers|key' => 'application/octet-stream'
	 ) ) ;
	 return $mimes ;
 }
// Custom_foter_text_admin_panel
function remove_footer_admin () {
    echo get_bloginfo ( 'description' );
}

add_filter('admin_footer_text', 'remove_footer_admin');

//Add_Canonical_Permalinks
function set_canonical() {
  if ( is_single() ) {
	global $wp_query;
	echo '<link rel="canonical" href="'.get_permalink($wp_query->post->ID).'"/>';
  }
}
add_action('wp_head', 'set_canonical');

//Add support_Twitter_oEmbed
add_filter('oembed_providers','twitter_oembed');
function twitter_oembed($a) {
	$a['#http(s)?://(www\.)?twitter.com/.+?/status(es)?/.*#i'] = array( 'http://api.twitter.com/1/statuses/oembed.{format}', true);
	return $a;
}
//Send the result when only one is in a search
function single_result() {
  if(is_search()) {
    global $wp_query;
    if($wp_query->post_count == 1) {
      wp_redirect(get_permalink($wp_query->posts['0']->ID ));
    }
  }
}
add_action('template_redirect', 'single_result');

//Remove the WordPress version of the RSS / Atom:
function remove_feed_generator() {
  return '';
}
add_filter('the_generator', 'remove_feed_generator');

// Disable self trackbacks
function disable_self_ping( &$links ) {
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, get_option( 'home' ) ) )
            unset($links[$l]);
}
add_action( 'pre_ping', 'disable_self_ping' );

function disableAutoSave(){
    wp_deregister_script('autosave');
}
add_action( 'wp_print_scripts', 'disableAutoSave' );

// Opengraph for posts
function opg_post() {
    if ( is_singular() ) {
        global $post;
        setup_postdata( $post );
        $output = '<meta property="og:type" content="article" />' . "\n";
        $output .= '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '" />' . "\n";
        $output .= '<meta property="og:url" content="' . get_permalink() . '" />' . "\n";
        $output .= '<meta property="og:description" content="' . esc_attr( get_the_excerpt() ) . '" />' . "\n";
        if ( has_post_thumbnail() ) {
            $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
            $output .= '<meta property="og:image" content="' . $imgsrc[0] . '" />' . "\n";
        }
        echo $output;
    }
}
add_action( 'wp_head', 'opg_post' );
?>