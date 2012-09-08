<?php
/*
Plugin Name: Functions
Description: Alternative <code>functions.php</code>  file of wordpress themes.
Version: 2.0.1
Author: abr4xas
Author URI: http://abr4xas.org/refu/
License: GPLv2 or later
*/

// Custom_Avatar_and_Logo
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
  .status-future { background: #C6EBF5 !important; }
  .status-private { background: #F2D46F; }
  </style>
<?php
}
add_action('admin_footer','posts_status_color');

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

// Paypal Donation Shortcode
// Just add [donate]Make a donation[/donate] or [donate] where you want to display donation link on post or widget
function donate_shortcode( $atts, $content = null) {
	global $post;extract(shortcode_atts(array(
		'account' => 'your-paypal-email-address',
		'for' => $post->post_title,
		'onHover' => '',
	), $atts));
	if(empty($content)) $content='Make A Donation';
		return '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business='.$account.'&item_name=Donation for '.$for.'" title="'.$onHover.'">'.$content.'</a>';
}
add_shortcode('donate', 'donate_shortcode');
add_filter('widget_text', 'do_shortcode');

// Disable self trackbacks
function disable_self_ping( &$links ) {
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, get_option( 'home' ) ) )
            unset($links[$l]);
}
add_action( 'pre_ping', 'disable_self_ping' );


//add .pdf support to the WordPress media manager
function modify_post_mime_types( $post_mime_types ) {
        $post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span $
        return $post_mime_types;
}
add_filter( 'post_mime_types', 'modify_post_mime_types' );
