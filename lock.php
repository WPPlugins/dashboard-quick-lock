<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * @package Lock
 */
/*
Plugin Name: Dashboard Quick Lock
Description: Return to your dashboard with a smile. No more long tough passwords to resume your work. Ultrafast access with easy 4 digit PIN.
Author: Quintet.Solutions 
Author URI: http://quintetsolutions.com
Tags: lock, password, pin, auto lock, login, form, secure, username, idle lock, dashboard lock 
Version: 1.2
*/

$default_lang = 'en';
$blog_lang = get_bloginfo('language');
if($blog_lang && $blog_lang != ''){
    $lang_country = explode("-", $blog_lang);
}

define( 'LOCK_LANG', get_bloginfo('language'));
define( 'LOCK_PLUGIN_BASENAME', plugin_basename(__FILE__));
define( 'LOCK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'LOCK_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LOCK_WP_VERSION', get_bloginfo('version'));
define( 'LOCK_WP_INCLUDE_URL', includes_url());

require_once( LOCK_PLUGIN_DIR . 'includes/class.lock.php' );
require_once( LOCK_PLUGIN_DIR . 'includes/class.colors.php' );
require_once( LOCK_PLUGIN_DIR . 'includes/class.utility.php' );



if(isset($lang_country[0]) && file_exists(LOCK_PLUGIN_DIR . 'lang/' . $lang_country[0] . '.php')){
    $lang_file = LOCK_PLUGIN_DIR . 'lang/' . $lang_country[0] . '.php';
}
else{
    $lang_file = LOCK_PLUGIN_DIR . 'lang/' . $default_lang . '.php';
}
if(file_exists($lang_file)){
	require_once( $lang_file);
	$QLOCK = new QLock;

	register_activation_hook( __FILE__, array( $QLOCK, 'plugin_activation' ) );

	add_action( 'init', array( $QLOCK, 'init' ) );
}
else{

	add_action( 'admin_enqueue_scripts', 'load_language_scripts' );
	add_action( 'admin_notices', 'display_language_notice' );

	/**
     *@name display_language_notice
     *function to show notice to the user. notice will only show 
     *if lang file not found
    */
    function display_language_notice(){
        global $lang_file;
        $data = array(
        	'file' => $lang_file
        );

        echo QLockUtility::get_template( 'lang-notice', $data);
    }

	/**
     *@name load_language_scripts
     *function will load css to the dashboard
    */
    function load_language_scripts(){
    	wp_enqueue_style( 'q-lock-google-font', 'http://fonts.googleapis.com/css?family=Roboto:400,300,100,500|Roboto+Condensed:400,300');
        wp_enqueue_style( 'q-lock-admin-css', LOCK_PLUGIN_URL . 'resources/admin.css');
    }
}


