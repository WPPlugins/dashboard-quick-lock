<?php if ( ! defined( 'ABSPATH' ) ) exit;
    if(!class_exists('QLock')){
        /**
         *@package Lock
         *@name QLock
         *@author Quintet.Developers
         */
        class QLock{

            //wp initialize flag
            private $wp_initialize_flag;
            
            //wp user option keys
            private $bg_image_opt_key;
            private $bg_color_opt_key;
            private $auto_lock_opt_key;
            private $powered_by_opt_key;
            private $last_activity_opt_key;
            private $library_img_opt_key;
            
            private $def_bg_images;
            private $def_bg_color;
            private $def_powereby_show;
            
            private $current_user;
            
            //class objects
            private $colors;
            private $utility;
            
            private $def_auto_lock;

            private $lang;
            
            /**
             *Constructor function
             *@access public
             */
            function __construct(){

                global $lock_admin;
                
                $this->bg_color_opt_key         = 'qlock-bg-color';
                $this->bg_image_opt_key         = 'qlock-bg-image';
                $this->def_pin_opt_key          = 'qlock-def-pin';
                $this->usr_pin_opt_key          = 'qlock-user-pin';
                $this->auto_lock_opt_key        = 'qlock-auto-lock-time';
                $this->powered_by_opt_key       = 'qlock-show-poweredby';
                $this->last_activity_opt_key    = 'qlock-last-activity';
                $this->library_img_opt_key      = 'qlock-library-images';
                
                $this->def_bg_color             = '#008299';  //this will be used if no bg images in plugin
                $this->def_auto_lock            = 180;
                $this->def_powereby_show        = 1;  //1 for show and 0 for hide

                $this->lang                     = $lock_admin;
                $this->wp_initialize_flag       = false;
            }

            /**
             *
             *@name initialize_variables
             *function will initialize private variables
             *@access private
             *
             */
            private function initialize_variables(){
                $this->colors               = new QLockColors;
                $this->utility              = new QLockUtility;
                $this->current_user         = wp_get_current_user();
                $this->wp_initialize_flag   = true;
                $this->_handle_lock();
            }
            
            /**
             *@name plugin_activation
             *@access public
             */
            public function plugin_activation(){
                if($this->wp_initialize_flag === false){
                    $this->initialize_variables();
                }
                $users  = $this->_get_all_users();
                $images = $this->utility->get_images_from_library();
                if(!empty($users)){
                    foreach($users as $user){
                        $this->_set_def_background( $user->ID );
                        $this->_set_def_PIN( $user->ID );
                        $this->_set_def_autolock( $user->ID);
                        $this->_set_library_images( $user->ID, $images);
                        $this->_set_def_powered_by( $user->ID );
                    }
                }
                $this->_remove_lock(); //fix for multiple activate deactivate plugin
            }

            /**
             *@name _remove_lock
             *function will remove locked variable from db
             *@access private
             */
            private function _remove_lock(){
                delete_user_option( $this->current_user->ID, $this->utility->get_cookie());
            }

            /**
             *@name init
             *function will be triggered on admin init
             *@access public
             */
            public function init(){
                if($this->wp_initialize_flag === false){
                    $this->initialize_variables();
                }
                if(!$this->utility->is_mobile()){
                    if ( current_user_can('edit_pages') ||  current_user_can('edit_posts')) {
                        $this->_register_hooks();
                    }
                }
            }
            
            /**
             *@name _register_hooks
             *function will register methods for wp hooks
             *@access private
             */
            public function _register_hooks(){
                add_action( 'admin_menu', array( $this, 'load_menu' ));
                add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ));
                add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts_frontend' ));
                if( LOCK_WP_VERSION > 3.6){
                    add_action( 'wp_before_admin_bar_render', array( $this, 'add_lock_button' ));
                }
                add_action( 'admin_head', array( $this, 'admin_head' ));
                add_action( 'wp_head', array( $this, 'admin_head' ));
                
                add_filter( 'plugin_action_links_' . LOCK_PLUGIN_BASENAME, array( $this, 'load_action_links' ));
                add_action( 'user_register', array( $this, 'update_settings_new_user'), 10, 1 );
                
                
                add_action( 'wp_ajax_auto_lock', array( $this, 'auto_lock' ));
                add_action( 'wp_ajax_nopriv_auto_lock', array( $this, 'auto_lock' ));
                
                add_action( 'wp_ajax_lock_me', array( $this, 'lock_me' ));
                add_action( 'wp_ajax_nopriv_lock_me', array( $this, 'lock_me' ));
                
                add_action( 'wp_ajax_unlock_me', array( $this, 'unlock_me' ));
                add_action( 'wp_ajax_nopriv_unlock_me', array( $this, 'unlock_me' ));
                
                add_action( 'wp_ajax_locked_get_something', array( $this, 'locked_get_something' ));
                add_action( 'wp_ajax_nopriv_locked_get_something', array( $this, 'locked_get_something' ));
                
                add_action( 'wp_ajax_settings_validate_wp_passwd', array( $this, 'settings_validate_wp_passwd' ));
                
                add_action( 'wp_ajax_settings_save_new_pin', array( $this, 'settings_save_new_pin' ));
                
                add_action( 'wp_ajax_settings_save_autolock', array( $this, 'settings_save_autolock' ));
                
                add_action( 'wp_ajax_settings_save_bg', array( $this, 'settings_save_bg' ));
                
                add_action( 'wp_ajax_settings_save_poweredby', array( $this, 'settings_save_poweredby' ));

                add_action( 'wp_ajax_settings_add_imge_from_library', array( $this, 'settings_add_imge_from_library' ));
                add_action( 'wp_ajax_settings_remove_imge_from_library', array( $this, 'settings_remove_imge_from_library' ));
                
                add_filter( 'heartbeat_received', array($this, 'heartbeat_received'), 10, 2 );
                add_filter( 'heartbeat_nopriv_received', array($this, 'heartbeat_received'), 10, 2 );
                
                add_action( 'wp_login', array( $this, 'wp_login'), 10, 2);

                add_action( 'admin_notices', array( $this, 'display_notice' ) );
            }
            
            
            /**
             *@name wp_login
             *function will be triggered on user login
             *@access public
             */
            public function wp_login(){
                $this->utility->set_cookie();
            }
            
            /**
             *@name _load_menu
             *function will be triggered from admin_menu hook
             *@access public
             */
            public function load_menu(){
                if( LOCK_WP_VERSION < 3.6){
                    add_menu_page( $this->lang['settings_menu'], $this->lang['settings_menu'], 'edit_posts', 'wp-lock-settings', array( $this, 'settings' ), ' ');
                    add_menu_page( $this->lang['lock_btn'], $this->lang['lock_btn'], 'edit_posts', 'wp-lock-button', '#', ' ');
                }
                else{
                    add_menu_page( $this->lang['settings_menu'], $this->lang['settings_menu'], 'edit_posts', 'wp-lock-settings', array( $this, 'settings' ));
                }
            }
            
            /**
             *@name load_scripts
             *function will load all js and css
             *@access public
             */
            public function load_scripts(){
                if ( function_exists( 'wp_enqueue_media' )){
                    wp_enqueue_media();
                }
                wp_enqueue_style( 'q-lock-google-font', 'http://fonts.googleapis.com/css?family=Roboto:400,300,100,500|Roboto+Condensed:400,300');
                wp_enqueue_style( 'q-lock-admin-css', LOCK_PLUGIN_URL . 'resources/admin.css');
                wp_enqueue_style( 'q-lock-lock-css', LOCK_PLUGIN_URL . 'resources/lock.css');
                if( LOCK_WP_VERSION < 3.6){
                    wp_enqueue_style( 'q-lock-lock-older', LOCK_PLUGIN_URL . 'resources/older-version.css');
                }
                
                wp_register_script( 'q-lock-vegas', LOCK_PLUGIN_URL . 'resources/jquery.vegas.min.js', array( 'jquery' ) );
                wp_register_script( 'q-lock-admin-script', LOCK_PLUGIN_URL . 'resources/admin.js', array( 'jquery' ) );
                wp_register_script( 'q-lock-script', LOCK_PLUGIN_URL . 'resources/plugin.js', array( 'jquery' ) );
                wp_enqueue_script( 'jquery' );
                wp_enqueue_script( 'q-lock-vegas' );
                wp_enqueue_script( 'q-lock-admin-script' );
                wp_enqueue_script( 'q-lock-script' );
                
                $this->_load_scrip_var();
            }
            
            /**
             *@name load_scripts_frontend
             *function to enque script for front-end
             *@access public
             */
            public function load_scripts_frontend(){
                wp_register_script( 'q-lock-vegas', LOCK_PLUGIN_URL . 'resources/jquery.vegas.min.js', array( 'jquery' ) );
                wp_register_script( 'q-lock-admin-script', LOCK_PLUGIN_URL . 'resources/admin.js', array( 'jquery' ) );
                wp_register_script( 'q-lock-script', LOCK_PLUGIN_URL . 'resources/plugin.js', array( 'jquery' ) );
                wp_enqueue_script( 'jquery' );
                wp_enqueue_script( 'q-lock-vegas' );
                wp_enqueue_script( 'q-lock-admin-script' );
                wp_enqueue_script( 'q-lock-script' );
                
                $this->_load_scrip_var();
            }
            
            /**
             *@name_load_scrip_var
             *function will add global data to lock_global_vars varibale for javascript
             *@access private
             */
            private function _load_scrip_var(){
                global $lock_screen_lang;
                $data = array(
                    'is_admin' => is_admin(),
                    'messages' => array(
                        'security_pin_wp_passwd_blank'  => $this->lang['security_pin_wp_passwd_blank'],
                        'security_pin_wp_passwd_invalid'=> $this->lang['security_pin_wp_passwd_invalid'],
                        'security_pin_new_pin_blank'    => $this->lang['security_pin_new_pin_blank'],
                        'security_pin_new_pin_mismatch' => $this->lang['security_pin_new_pin_mismatch'],
                        'security_pin_error_occured'    => $this->lang['security_pin_error_occured'],
                        'appearance_bg_image_add_popup_title'    => $this->lang['appearance_bg_image_add_popup_title'],
                        'appearance_bg_image_add_popup_button'    => $this->lang['appearance_bg_image_add_popup_button'],
                        'autolock_disabled_label'    => $this->lang['autolock_disabled_label'],
                        'autolock_enabled_label'    => $this->lang['autolock_enabled_label'],
                        'autolock_updation_error'   => $this->lang['autolock_updation_error'],
                        'pin_incorrect_title'       => $lock_screen_lang['pin_incorrect_title'],
                        'password_incorrect_title'  => $lock_screen_lang['password_incorrect_title']
                    )
                );
                wp_localize_script('q-lock-script', 'lock_global_vars', $data);
            }
            
            /**
             *@name add_lock_button
             *function will add lock link in admin panel user profile
             *@access public
             */
            public function add_lock_button(){
                global $wp_admin_bar;
                
                $logout_node = $wp_admin_bar->get_node( 'logout' );
                
                $wp_admin_bar->remove_node('logout');
                $args = array(
                    'id'    => 'wp-lock-button',
                    'title' => $this->lang['lock_btn'],
                    'href'  => "#",
                    'meta'  => array( 'class' => 'wp-lock-button' ),
                    'parent' => 'user-actions'
                );
                $wp_admin_bar->add_node( $args );    
                $wp_admin_bar->add_node( $logout_node);
            }
            
            /**
             *@name load_action_links
             *function will add settings link to plugin page
             *@access public
             *@param array $links defautl wp plugin action links
             *@return array new action links for this plugin
             */
            public function load_action_links( $links ){
                $new_links = array();
                
                $new_links[] = '<a href="'. get_admin_url(null, 'admin.php?page=wp-lock-settings') .'">Settings</a>';
                $new_links[] = $links['deactivate'];
                
                return $new_links;
            }
            
            
            /**
             *@name _handle_lock
             *function to handle lock screen
             *@access private
             */
            private function _handle_lock(){
                if (defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && $_REQUEST['action'] == 'locked_get_something' ) {
                    return;
                }
                if (defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && $_REQUEST['action'] == 'heartbeat' ) {
                    return;
                }
                if (defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && $_REQUEST['action'] == 'unlock_me' ) {
                    return;
                }
                if (defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && $_REQUEST['action'] == 'lock_me' ) {
                    return;
                }
                if (defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && $_REQUEST['action'] == 'auto_lock' ) {
                    return;
                }
                if(is_admin() && $this->_is_locked()){
                    /* we hope this is not an ajax lock request, so we're sending full lock screen html*/
                    die($this->_get_full_lock_screen());
                }
                elseif(!is_admin() && $this->_is_locked()){
                    /* this is used to front-end, if user locked dashboard and viewing front-end*/
                    show_admin_bar(false);
                    add_filter( 'show_admin_bar', '__return_false' );
                }
                else if(is_admin()){
                    $this->_update_last_activity();
                }
            }
            
            public function auto_lock(){
                if((is_admin() && $this->_is_last_activity_expired()) || (is_admin() && $this->_is_locked())){
                    $this->lock_me();
                }
            }
            
            /**
             *@name lock_me
             *function to lock current login
             *@access public
             */
            public function lock_me(){
                update_user_option( $this->current_user->ID, $this->utility->get_cookie(), 'locked');
                die( $this->_get_ajax_lock_screen() );
            }
            
            /**@name locked_get_something
             *function to send something to client to maintain session
             *@access public
             */
            public function locked_get_something(){
                $comments_count = wp_count_comments();
                $data = array(
                    'current_time' => time(),
                    'is_locked' => $this->_is_locked(),
                    'is_admin' => ( isset($_POST['is_admin']) && $_POST['is_admin'] == true ) ? true : false,
                    'comments_count' => $comments_count->total_comments,
                    'moderated' => $comments_count->moderated,
                    'published_pages_count' => wp_count_posts( 'page')->publish,
                );
                $this->utility->print_json($data);
            }
            
            /**
             *@name heartbeat_received
             *function will add is_locked parameter with heartbeat response
             *@access public
             */
            public function heartbeat_received(){
                $response['is_locked']  = $this->_is_locked();
                return $response;
            }
            
            
            /**
             *@name unlock_me
             *function will check current user password and user entered password in lock screen
             *@access public
             */
            public function unlock_me(){
                $response = array(
                    'success' => false
                );
                $dql_nonce = $_REQUEST['dql_nonce'];
                if ( wp_verify_nonce( $dql_nonce, 'dq-lock-nonce' ) ) {
                    $input_pin = (isset($_POST['input_pin']) ) ? $_POST['input_pin'] : false;
                    if($input_pin){
                        $defult_pin = get_user_option( $this->def_pin_opt_key, $this->current_user->ID);
                        if($defult_pin){
                            if($defult_pin == $input_pin){
                                delete_user_option( $this->current_user->ID, $this->utility->get_cookie());
                                $response['success'] = true;
                            }
                        }
                        else{
                            $user_pin = get_user_option( $this->usr_pin_opt_key, $this->current_user->ID );
                            if($user_pin){
                                if($user_pin == sha1($input_pin)){
                                    delete_user_option( $this->current_user->ID, $this->utility->get_cookie());
                                    $response['success'] = true;
                                }
                            }
                        }
                    }
                    else if(isset($_POST['input_passwd'])){
                        $password = trim($_POST['input_passwd']);
                        $creds = array(
                            'user_login'    => $this->current_user->user_login,
                            'user_password' => $password,
                            'remember' 	   => false
                        );

                        $user = wp_signon( $creds, false );
                        if ( is_wp_error($user) ):
                            $response['success'] = false;
                        else:
                            delete_user_option( $this->current_user->ID, $this->utility->get_cookie());
                            $response['success'] = true;
                        endif;
                    }
                }
                $this->utility->print_json($response);
            }
            
            /**
             *@name _is_locked
             *function to check whether current session locked
             *@access private
             *@return boolean true if locked else false
             */
            private function _is_locked(){
                $locked = get_user_option($this->utility->get_cookie(), $this->current_user->ID);
                if($locked && $locked == "locked"){
                    return true;
                }
                return false;
            }
            
            /**
             *@name _get_ajax_lock_screen
             *function will return ajax lock screen template
             *@access private
             *@return string html of ajax lock screen template
             */
            private function _get_ajax_lock_screen(){
                global $lock_screen_lang;
                $comments_count = wp_count_comments();
                $data = array(
                    'site_title'            => get_bloginfo(),
                    'background'            => $this->_get_user_bg_settings(),
                    'comments_count'        => $comments_count->total_comments,
                    'moderated'             => $comments_count->moderated,
                    'published_pages_count' => wp_count_posts( 'page')->publish,
                    'defualt_pin'       => get_user_option( $this->def_pin_opt_key, $this->current_user->ID ),
                    'tip'               => $this->utility->get_tip(),
                    'show_powered_by'   => get_user_option( $this->powered_by_opt_key, $this->current_user->ID ),
                    'lang'              => $lock_screen_lang
                );
                
                return $this->utility->get_template( 'lock-screen-ajax', $data);
            }
            
            /**
             *@name _get_full_lock_screen
             *function will return full html of lock screen
             *@access private
             *@return string html of full ajax lock screen
             */
            private function _get_full_lock_screen(){
                global $lock_screen_lang;
                $comments_count = wp_count_comments();
                $data = array(
                    'site_title'            => get_bloginfo(),
                    'admin_url'             =>  admin_url(),
                    'background'            => $this->_get_user_bg_settings(),
                    'comments_count'        => $comments_count->total_comments,
                    'moderated'             => $comments_count->moderated,
                    'published_pages_count' => wp_count_posts( 'page')->publish,
                    'defualt_pin'       => get_user_option( $this->def_pin_opt_key, $this->current_user->ID ),
                    'tip'               => $this->utility->get_tip(),
                    'show_powered_by'   => get_user_option( $this->powered_by_opt_key, $this->current_user->ID ),
                    'lang'              => $lock_screen_lang
                );
                
                return $this->utility->get_template( 'lock-screen', $data);
            }
            
            /**
             *@name _set_def_PIN
             *function to set defualt PIN for user
             *@access private
             */
            private function _set_def_PIN($user_id = false){
                if($user_id){
                    delete_user_option( $user_id, $this->usr_pin_opt_key);
                    update_user_option( $user_id, $this->def_pin_opt_key, $this->utility->generate_pin() );
                }
            }
            
            /**
             *@name _set_def_autolock
             *function to set defualt PIN for user
             *@access private
             */
            private function _set_def_autolock($user_id = false){
                if($user_id){
                    delete_user_option( $user_id, $this->auto_lock_opt_key);
                    update_user_option( $user_id, $this->auto_lock_opt_key, $this->def_auto_lock);
                }
            }

            /**
             *@name _set_library_images
             *function will store images to library
             *@access private
             */
            private function _set_library_images($user_id, $images = array()){
                if(is_array($images) && !empty($images)){
                    delete_user_option( $user_id, $this->library_img_opt_key);
                    update_user_option( $user_id, $this->library_img_opt_key, serialize($images));
                }
            }
            
            /**
             *@name _set_def_powered_by
             *function to enable powered by link by default
             *@access private
             */
            private function _set_def_powered_by($user_id = false){
                if($user_id){
                    delete_user_option( $user_id, $this->powered_by_opt_key);
                    update_user_option( $user_id, $this->powered_by_opt_key, $this->def_powereby_show);
                }
            }
            
            /**
             *@name _set_def_background
             *function will set lock screen background for user
             *@access private
             *@param integer $user_id 
             */
            private function _set_def_background($user_id = false){
                $this->def_bg_images = $this->utility->get_all_default_bg_images();
                if($user_id){
                    if(!empty($this->def_bg_images)){
                        delete_user_option( $user_id, $this->bg_color_opt_key );
                        update_user_option( $user_id, $this->bg_image_opt_key, serialize( $this->def_bg_images ) );
                    }
                    else{
                        delete_user_option( $user_id, $this->bg_image_opt_key );
                        update_user_option( $user_id, $this->bg_color_opt_key, $this->def_bg_color );
                    }
                }
            }
            
            /**
             *@name update_settings_new_user
             *function will update lock settings for new user
             *@access public
             *@param integer $user_id newly created user id
             */
            public function update_settings_new_user($user_id){
                
                $images = $this->utility->get_images_from_library();

                $this->_set_def_background( $user_id );
                $this->_set_def_PIN( $user_id );
                $this->_set_def_autolock( $user_id );
                $this->_set_def_powered_by( $user_id );
                $this->_set_library_images( $user_id, $images);
            }
            
            /**
             *@name _get_user_bg_settings
             *function will return user lock screen bg settings
             *@access private
             *@param integer $user_id user id to get bg settings
             *@return array array of images or color
             */
            private function _get_user_bg_settings( $user_id = false){
                $user_id            = ( !$user_id ) ? $this->current_user->ID : $user_id;
                $return             = array();
                $return['images']   = array();
                $images = unserialize(get_user_option( $this->bg_image_opt_key, $user_id));
                if(is_array($images) && !empty($images)){
                    foreach ($images as $key => $image) {
                        $plugin = false;
                        if(strpos($image, 'plugins')){
                            $explodes   = explode('plugins', $image);
                            $plugin     = true;
                        }
                        else if(strpos($image, 'wp-content')){
                            $explodes   = explode('wp-content', $image);
                            $plugin     = false;
                        }
                        
                        if(count($explodes) == 2){
                            if($plugin)
                                $relative_path  = ABSPATH . 'wp-content/plugins' . $explodes[1];
                            else
                                $relative_path  = ABSPATH . 'wp-content' . $explodes[1];
                            if(file_exists($relative_path)){
                                $return['images'][] = $image;
                            }
                        }
                    }
                }
                $return['color'] = get_user_option( $this->bg_color_opt_key, $user_id);
                if(empty($return['images']) && empty($return['color'])){
                    $return['color'] = $this->def_bg_color;
                }
                return ( empty( $return['images'] ) && empty( $return['color'] ) ) ? false : $return;
            }
            
            /**
             *@name _get_all_users
             *function will retutn all wordpress users
             *@access private
             *@return stdClass
             */
            private function _get_all_users(){
                return get_users( array( 'fields' => array( 'ID' ) ) ); //getting all wp users
            }
            
            /**
             *@name admin_head
             *function will be triggered from admin_head hook
             *@access public
             */
            public function admin_head(){
                $this->_set_settings_icon();
                $this->_set_meta();
                $this->_set_js_vars();
            }
            
            /**
             *@name _set_meta
             *function to set meta for viewport and charset
             *@access private
             */
            private function _set_meta(){
                echo '
                    <meta charset="utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
                ';
            }
            
            /**
             *@name _set_js_vars
             *function to set js variable from php
             *@access private
             */
            private function _set_js_vars(){
                $admin_url = admin_url();
                $auto_lock = get_user_option( $this->auto_lock_opt_key, $this->current_user->ID);
                echo '
                    <script type="text/javascript">
                        if( typeof lock_dashboard == "undefined" )
                            var lock_dashboard = {};
                        lock_dashboard.lock_admin_url = "'.$admin_url.'";
                        lock_dashboard.lock_plugin_url = "'.LOCK_PLUGIN_URL.'";
                        lock_dashboard.direct_lock = false
                        lock_dashboard.auto_lock_seconds = "'.$auto_lock.'";
                    </script>
                ';
            }
            
            /**
             *@name _set_settings_icon
             *function will change the icon of lock settings menu on the dashboard
             *@access private
             */
            public function _set_settings_icon(){
                ?>
                <style type="text/css">
                    #adminmenu #toplevel_page_wp-lock-settings div.wp-menu-image:before {
                        content: "\f160";
                    }
                </style>
                <?php
            }
            
            /**
             *@name settings
             *function is used for plugin settings page
             *@access public
             */
            public function settings(){
                $this->def_bg_images = $this->utility->get_all_default_bg_images();
                $data = array(
                    'defualt_pin' => get_user_option( $this->def_pin_opt_key, $this->current_user->ID ),
                    'autolock_periods' => $this->utility->generate_auto_lock_periods(),
                    'autolock_selected_time' => get_user_option( $this->auto_lock_opt_key, $this->current_user->ID ),
                    'def_bg_images' => $this->def_bg_images,
                    'bg_images_library' => get_user_option( $this->library_img_opt_key, $this->current_user->ID),
                    'def_bg_colors' => $this->colors->get_colors(),
                    'selected_bg' => $this->_get_user_bg_settings(),
                    'show_powered_by' => get_user_option( $this->powered_by_opt_key, $this->current_user->ID ),
                    'lang' => $this->lang
                );
                echo $this->utility->get_template( 'settings', $data);
            }
            
            
            
            /**
             *@name settings_validate_wp_passwd
             *function to validate user wp password while resetting PIN
             *@access public
             */
            public function settings_validate_wp_passwd(){
                $response = array(
                    'status'=> false
                );
                $user_passwd = (isset($_POST['input_passwd']) && $_POST['input_passwd'] != '')  ? $_POST['input_passwd'] : false;
                if($user_passwd ){
                    if( $this->current_user->ID && wp_check_password( $_POST['input_passwd'], $this->current_user->user_pass, $this->current_user->ID ) ){
                        $response['status'] = true;
                    }
                    else{
                        $response['message'] = $this->lang['security_pin_wp_passwd_invalid'];
                    }
                }
                else{
                    $response['message'] = $this->lang['security_pin_wp_passwd_blank'];
                }
                $this->utility->print_json($response);
            }
            
            /**
             *@name settings_save_new_pin
             *function to validate user wp password and set new PIN
             *@access public
             */
            public function settings_save_new_pin(){
                $response = array(
                    'status'=> false
                );
                $user_passwd = (isset($_POST['input_passwd']) && $_POST['input_passwd'] != '')  ? $_POST['input_passwd'] : false;
                $new_pin = (isset($_POST['user_new_pin']) && $_POST['user_new_pin'] != '')  ? $_POST['user_new_pin'] : false;
                $confirm_pin = (isset($_POST['user_confirm_pin']) && $_POST['user_confirm_pin'] != '')  ? $_POST['user_confirm_pin'] : false;
                if($user_passwd ){
                    if( $this->current_user->ID && wp_check_password( $_POST['input_passwd'], $this->current_user->user_pass, $this->current_user->ID ) ){
                        if($new_pin == $confirm_pin){
                            $user_pin = get_user_option( $this->usr_pin_opt_key, $this->current_user->ID );
                            if($user_pin == sha1($new_pin)){
                                $response['message'] = "You can't use your previous PIN.";
                            }
                            elseif(update_user_option( $this->current_user->ID, $this->usr_pin_opt_key, sha1($new_pin))){
                                delete_user_option( $this->current_user->ID, $this->def_pin_opt_key);
                                $response['status'] = true;
                            }
                            else{
                                $response['message'] = $this->lang['security_pin_error_occured'];
                            }
                        }
                        else{
                            $response['message'] = $this->lang['security_pin_new_pin_mismatch'];
                        }
                    }
                    else{
                        $response['message'] = $this->lang['security_pin_error_wp_password'];
                    }
                }
                else{
                    $response['message'] = $this->lang['security_pin_error_wp_password'];
                }
                $this->utility->print_json($response);
            }
            
            /**
             *@name settings_save_autolock
             *function to set auto lock period
             *@access public
             */
            public function settings_save_autolock(){
                $response = array(
                    'status'=> false
                );
                $auto_lock = (isset($_POST['input_auto_lock']) && $_POST['input_auto_lock'] != '')  ? $_POST['input_auto_lock'] : false;
                if($auto_lock ){
                    $auto_lock_value = get_user_option( $this->auto_lock_opt_key, $this->current_user->ID);
                    if($auto_lock_value  == $auto_lock){
                        $time = ($auto_lock_value > 60) ? ($auto_lock_value / 60) . " Minutes" : $auto_lock_value. " Seconds";
                        $response['status'] = true;
                    }
                    else if(update_user_option( $this->current_user->ID, $this->auto_lock_opt_key, $auto_lock)){
                        $response['status'] = true;
                    }
                    else{
                        $response['message'] = $this->lang['autolock_updation_error'];
                    }
                }
                else{
                    delete_user_option( $this->current_user->ID, $this->auto_lock_opt_key);
                    $response['status'] = true;
                }
                $this->utility->print_json($response);
            }
            
            
            /**
             *@name settings_save_bg
             *function to set auto lock screen bg
             *@access public
             */
            public function settings_save_bg(){
                $color_selected = (isset($_POST['selected_color']) && $_POST['selected_color'] != '') ? $_POST['selected_color'] : false;
                $images_selected = (isset($_POST['selected_images']) && $_POST['selected_images'] != '') ? serialize($_POST['selected_images']) : false;
                if($color_selected){
                    update_user_option( $this->current_user->ID, $this->bg_color_opt_key, $color_selected);
                    delete_user_option( $this->current_user->ID, $this->bg_image_opt_key);
                }
                else if($images_selected){
                    update_user_option( $this->current_user->ID, $this->bg_image_opt_key, $images_selected);
                    delete_user_option( $this->current_user->ID, $this->bg_color_opt_key);
                }
                
                $this->utility->print_json(array('status' => true));
            }
            
            /**
             *@name settings_save_poweredby
             *function to save powered by settings
             *@access public
             */
            public function settings_save_poweredby(){
                $enabled = (isset($_POST['input_enable_powered']) && $_POST['input_enable_powered'] == 1) ? 1 : 0;
                update_user_option( $this->current_user->ID, $this->powered_by_opt_key, $enabled);
                $this->utility->print_json(array('status' => true));
            }

            /**
             *@name settings_add_imge_from_library
             *function will user selected images to the library
             *@access public
             */
            public function settings_add_imge_from_library(){
                $selected_image = (isset($_POST['selected_image'])) ? $_POST['selected_image'] : false;
                if($selected_image){
                    $all_images = array();
                    $images = get_user_option($this->library_img_opt_key, $this->current_user->ID);
                    if($images){
                        $all_images = unserialize($images);
                    }
                    $all_images[] = $selected_image;
                    update_user_option( $this->current_user->ID, $this->library_img_opt_key, serialize($all_images));
                    $this->utility->print_json(array('status' => true));
                }
                else{
                    $this->utility->print_json(array('status' => false));
                }
            }

            /**
             *@name settings_remove_imge_from_library
             *function will remove image user added from library
             *@access public
             */
            public function settings_remove_imge_from_library(){
                $image_url = (isset($_REQUEST['image'])) ? $_REQUEST['image'] : false;
                if($image_url){
                    $images = get_user_option($this->library_img_opt_key, $this->current_user->ID);
                    if($images){
                        $all_images = unserialize($images);
                        if(is_array($all_images) && !empty($all_images)){
                            if(($key = array_search($image_url, $all_images)) !== false) {
                                unset($all_images[$key]);
                                update_user_option( $this->current_user->ID, $this->library_img_opt_key, serialize($all_images));
                            }
                        }

                        $bgs = $this->_get_user_bg_settings();
                        if(isset($bgs['images']) && is_array($bgs['images']) && !empty($bgs['images'])){
                            if(($key = array_search($image_url, $bgs['images'])) !== false) {
                                unset($bgs['images'][$key]);
                                update_user_option( $this->current_user->ID, $this->bg_image_opt_key, serialize($bgs['images']));
                            }
                        }
                        $this->utility->print_json(array('status' => true));
                        die();
                    }
                }
                $this->utility->print_json(array('status' => false));
                die();
            }
            
            /**
             *@name _is_last_activity_expired
             *function will check last activity if auto lock enabled
             *@access private
             *@return boolean return true if timout else false
             */
            private function _is_last_activity_expired(){
                $auto_lock = get_user_option( $this->auto_lock_opt_key, $this->current_user->ID );
                if($auto_lock  && $auto_lock  > 0){
                    $last_activity = $this->_get_last_activity();
                    if($last_activity && $last_activity > 0){
                        $current_time = time();
                        if( $current_time - $last_activity > $auto_lock){
                            return true;
                        }
                    }
                }
                return false;
            }
            
            /**
             *@name _get_last_activity
             *function to get last activity time
             *@access private
             *@return string last activity time
             */
            private function _get_last_activity(){
                return get_user_option( $this->last_activity_opt_key . ":" . $this->utility->get_cookie(), $this->current_user->ID );
            }
            
            /**
             *@name _update_last_activity
             *function to update last activity time
             *@access private
             */
            private function _update_last_activity(){
                $auto_lock = get_user_option( $this->auto_lock_opt_key, $this->current_user->ID );
                if($auto_lock  && $auto_lock  > 0){
                    update_user_option( $this->current_user->ID, $this->last_activity_opt_key. ":" . $this->utility->get_cookie(), time() );
                }
            }

            /**
             *@name display_notice
             *function to show notice to the user. notice will only show 
             *if user doesn't changed default PIN
             *@access public
            */
            public function display_notice(){
                global $current_screen;
                if(!isset($current_screen->id) || $current_screen->id != 'toplevel_page_wp-lock-settings'){
                    $default_pin = get_user_option( $this->def_pin_opt_key, $this->current_user->ID );

                    if($default_pin){
                        $p1 = str_replace('settings_link', '<a href="'.get_admin_url(null, 'admin.php?page=wp-lock-settings').'">'.$this->lang['notice_default_settings'].'</a>', $this->lang['notice_default_pin_descr1']);
                        $p1 = str_replace('defualt_pin', $default_pin, $p1);
                        
                        $data = array(
                            'title'         => $this->lang['notice_default_pin_title'],
                            'p1'            => $p1,
                            'p2'            => $this->lang['notice_default_pin_descr2']
                        );
                        echo $this->utility->get_template( 'notice', $data);
                    }
                }
            }
        }
    }