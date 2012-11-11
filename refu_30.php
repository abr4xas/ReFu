<?php
/*
Plugin Name: Functions
Description: Alternative <code>functions.php</code>  file of wordpress themes.
Contributors: abr4xas
Donate link: http://abr4xas.org/refu
Tags: functions
Requires at least: 3.4
Tested up to: 3.4.1
Stable tag: 2.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

function refu()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "refu";
    $sql = " CREATE TABLE $table_name(
             id int(11) NOT NULL AUTO_INCREMENT ,
             ngravatar char(50) NOT NULL ,
             feed char(50) NOT NULL ,
             footer char(50),);
           ";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

loadData();
function loadData()
{
	global $wpdb;
    $table_name = $wpdb->prefix . "refu";
	$arrayDatos = array('ngravatar' => 'ReFu', 'feed' => '', 'footer' => 'With love & wordpress <3');
	$wpdb->insert($table_name,$arrayDatos);
}
register_activation_hook(__FILE__,'refu_install');

function refu_uninstall()
{
	global $wpdb;
	$table_name = $wpdb->prefix . "refu";

	$sql = "DROP TABLE $table_name";
	$wpdb->query($sql);
}
register_deactivation_hook(__FILE__,'refu_uninstall');

add_action('admin_menu', 'refu_menu');

function refu_panel()
{
  include('settings.php');
}

function refu_menu()
{
  // Extraemos el directorio en el que estamos para ir usándolo luego
	$pluginDir = pathinfo( __FILE__ );
	$pluginDir = $pluginDir['dirname'];
	//////// DECLARACION DEL MENU ////////////

	// titulo de la nueva sección:
	$page_title = "ReFu";

	// titulo en el menú
	$menu_title = $page_title;

	// nivel necesario para poder ver el menú (admin:10, editores:8)
	// + info en: http://codex.wordpress.org/User_Levels
	$access_level = "8";

	// la página que se cargará al clickar en el menú
	$content_file = $pluginDir . '/settings.php';

	// Función para cargar dentro de la página incluida para generar el menú
	// Si no se indica, se asume que al incluir el fichero ya se ha generado todo el
	// contenido necesario.
	$content_function = null;

	// url del icono para el menú
	$menu_icon_url = null;

	add_menu_page($page_title, $menu_title, $access_level, $content_file, $content_function, $menu_icon_url);
}

function getReFu(){
	global $wpdb;
	$table_name = $wpdb->prefix . "refu";
	$listaRefu = $wpdb->get_results("SELECT * FROM $table_name; ");
	return $listaRefu;
}

?>
