<?php
/*
Plugin Name: Functions
Description: Alternative <code>functions.php</code>  file of wordpress themes.
Version: 2.0
Author: abr4xas
Author URI: http://abr4xas.org/refu
License: GPLv2 or later
*/


//Making jQuery Google API
function modify_jquery() {
	if (!is_admin()) {
		// comment out the next two lines to load the local copy of jQuery
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js', false, '1.4.4');
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'modify_jquery');

// Custom_Avatar
function custom_loginlogo() {
echo '<style type="text/css">
h1 a {background-image: url('.get_bloginfo('template_directory').'/images/login_logo.png) !important; }
</style>';
}
add_action('login_head', 'custom_loginlogo');

add_filter( 'avatar_defaults', 'newgravatar' );

function newgravatar ($avatar_defaults) {
$myavatar = get_bloginfo('template_directory') . '/images/gravatar.gif';
$avatar_defaults[$myavatar] = "Name of new gravatar";
return $avatar_defaults;
}


// Custom feed link
function custom_feed_link($output, $feed) {

$feed_url = 'Put your feed url here';

$feed_array = array('rss' => $feed_url, 'rss2' => $feed_url, 'atom' => $feed_url, 'rdf' => $feed_url, 'comments_rss2' => '');
$feed_array[$feed] = $feed_url;
$output = $feed_array[$feed];

return $output;
}

function other_feed_links($link) {

$link = 'Put your feed url here';
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


// Custom_LoginLogo
add_action("login_head", "my_login_head");
function my_login_head() {
	echo "
	<style>
	body.login #login h1 a {
		background: url('".get_bloginfo('template_url')."/images/awloginlogo.png') no-repeat scroll center top transparent;
		height: 135px;
		width: 135px;
	}
	</style>
	";
}

// Custom_URL_LoginLogo
add_action( 'login_headerurl', 'my_custom_login_url' );
function my_custom_login_url() {
return 'put your URL here';	
}

// Custom_ALT_text_LoginLogo
add_action("login_headertitle","my_custom_login_title");
function my_custom_login_title()
{
return 'Change this';
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
    echo "Change this";
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

// Color according to different post state
function posts_status_color() {
?>
  <style>
  .status-draft { background: #FCE3F2 !important; }
  .status-pending { background: #87C5D6 !important; }
  .status-publish { /* por defecto */ }
  .status-future { background: #C6EBF5 !important; }
  .status-private { background: #F2D46F; }
  </style>
<?php
}
add_action('admin_footer','posts_status_color');
