<?php if ( ! defined( 'ABSPATH' ) ) exit;
    if(!class_exists('QLockUtility')){
        /**
         *@package Lock
         *@name QLockUtility
         *@author Quintet.Developers
         */
        class QLockUtility{
            
            private $current_user;
            private $tips;
            private $lang;
            
            /**
             *constructor function
             */
            public function __construct(){
                global $current_user;
                global $lock_admin;
                get_currentuserinfo();
                $this->current_user = $current_user;
                $this->lang         = $lock_admin;
                $this->_set_tips();
            }
            
            /**
             *@name get_template
             *function to retrieve content of template
             *@access public
             *@param string $template_file filename inside template folder
             *@param array $data variable to pass to template
             *@return string html with variables passed
             */
            public function get_template( $template_file, $data = array() ){
                if(!empty($data)) extract( $data );
                ob_start();                    // Start output buffering
                include( LOCK_PLUGIN_DIR . "/templates/$template_file.php" );// Include the file
                $contents = ob_get_contents(); // Get the contents of the buffer
                ob_end_clean();                // End buffering and discard
                return $contents;              // Return the contents
            }
            
            /**
             *@name set_cookie
             *function to set cookie
             *@access public
             */
            public function set_cookie(){
                $unique_id = $this->_get_unique_value();
                $expiration = time() + apply_filters( 'auth_cookie_expiration', 2 * DAY_IN_SECONDS, $this->current_user->ID, false );
                setcookie( 'wp_lock_system', $unique_id, $expiration, COOKIEPATH, COOKIE_DOMAIN );
                return $unique_id;
            }
            
            /**
             *@name get_cookie
             *function to get cookie
             *@access public
             *@return string cookie value
             */
            public function get_cookie(){
                if(!isset($_COOKIE['wp_lock_system']))
                    return $this->set_cookie();
                else
                    return $_COOKIE['wp_lock_system'];
            }
            
            /**
             *@name unset_cookie
             *function to unset cookie
             *@access public
             */
            public function unset_cookie(){
                if(isset($_COOKIE['wp_lock_system'])) unset($_COOKIE['wp_lock_system']);
                setcookie('wp_lock_system', null, strtotime('-1 day'));
            }
            
            /**
             *@name _get_unique_value
             *function to get a unique value
             *will create a unique value with "wp_lock_system", "username", "timestamp", "user ip" and "useragent"
             *@access private
             *@return string a unique string
             */
            private function _get_unique_value(){
                return md5( "wp_lock_system:". $this->current_user->username . ":" . microtime() . ":" . $_SERVER['REMOTE_ADDR'] . ":" . $_SERVER['HTTP_USER_AGENT'] );
            }
            
            /**
             *@name _get_all_bg_images
             *function to retreive all images from plugin bf folder
             *@access private
             *@return array return all images inside LOCK_PLUGIN_DIR/bg_images direcotory
             */
            public function get_all_default_bg_images(){
                $dir = opendir(LOCK_PLUGIN_DIR .'/bg_images');
                $bgs = array();
                while($file = readdir($dir)):
                    if($file == "." || $file == ".." || $file == "index.php") continue;
                    $bgs[] = LOCK_PLUGIN_URL .'bg_images/'.$file;
                endwhile;
                return $bgs;
            }
            
            /**
             *@name generate_auto_lock_periods
             *function to retreive auto lock periods
             *@access public
             *@return array with second as key and label as value
             */
            public function generate_auto_lock_periods(){
                return array(
                    0 => $this->lang['autolock_time_disabled'],
                    120 => '2 ' . $this->lang['autolock_time_plural'],
                    180 => '3 ' . $this->lang['autolock_time_plural'],
                    240 => '4 ' . $this->lang['autolock_time_plural'],
                    300 => '5 ' . $this->lang['autolock_time_plural'],
                    600 => '10 ' . $this->lang['autolock_time_plural'],
                    900 => '15 ' . $this->lang['autolock_time_plural']
                );
            }
            
            
            /**
             *@name _get_images_from_library
             *function to retreive 5 images from library
             *@access public
             *@return array return 5 images from media library
             */
            public function get_images_from_library(){
                $return = array();
                $query_images_args = array(
                    'post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => 5,
                    'order' => 'DESC', 'orderby' => 'date'
                );
                $query_images = new WP_Query( $query_images_args );
                $images = 0;
                foreach ( $query_images->posts as $image):
                    $attachment_url = wp_get_attachment_url( $image->ID );
                    $explodes       = explode('wp-content', $attachment_url);
                    if(count($explodes) == 2){
                        $relative_path  = ABSPATH . 'wp-content' . $explodes[1];
                        if(file_exists($relative_path)){
                            if(function_exists('getimagesize')){
                                list($width, $height, $type, $attr) = getimagesize($relative_path);
                                
                                if($width >= 1000 && $height >= 625)
                                    $return[] =  $attachment_url;
                            }
                            else{
                                $return[] =  $attachment_url;   
                            }
                        }
                    }
                endforeach;
                return $return;
            }
            
            /**
             *@name is_mobile
             *function will check mobile except ipad or desktop,
             *we're not using wp defualt is_mobile method,
             *we have copied same method to edit support of ipad
             *@access public
             *@return boolean true if mobile else false
             */
            public function is_mobile() {
                static $is_mobile;
                
                if ( isset($is_mobile) )
                    return $is_mobile;
                
                if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
                    $is_mobile = false;
                } elseif (
                    strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
                    || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
                    || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
                    || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
                    || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false ) {
                        $is_mobile = true;
                } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') == false) {
                        $is_mobile = true;
                } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
                    $is_mobile = false;
                } else {
                    $is_mobile = false;
                }
                return $is_mobile;
            }
            
            /**
             *@name generate_pin
             *function will generate random PIN
             *@access public
             *@param number $length length of random PIN, default 4
             *@return string random generated PIN
             */
            public function generate_pin( $length = 4 ){
                return substr(str_shuffle(MD5(microtime())), 0, $length);
            }
            
            /**
             *@name _print_json
             *function will echo json_encode of array with json header
             *@access public
             */
            public function print_json($data = array()){
                header('Content-Type: application/json');
                $data['temp'] = '_print_json';
                die(json_encode($data));
            }
            
            /**
             *@name quintet_gplus_box
             *function will return google plus box of Quintet Solutions
             *@access public
             *@return string html of google plus box
             */
            public function quintet_gplus_box(){
                return '
                    <div class="g-page" data-href="//plus.google.com/u/0/103360999663117921271" 
                        data-showtagline="false" data-rel="publisher" 
                        data-layout="landscape" data-theme="dark"></div>

                    <script type="text/javascript">
                      (function() {
                        var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
                        po.src = "https://apis.google.com/js/platform.js";
                        var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
                      })();
                    </script>
                ';
            }
            
            /**
             *@name quintet_fb_box
             *function will retunrn fb like box of Quintet Solutions
             *@access public
             *@return string html of fblike box
             */
            public function quintet_fb_box(){
                return '
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=454354697977324&version=v2.0";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, "script", "facebook-jssdk"));</script>

                    <div class="fb-like-box" data-href="https://www.facebook.com/QuintetSolutions" data-show-border="true" 
                        data-height="290" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>

                ';
                return "

                    <div>
                        <iframe src=\"http://www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FQuintetSolutions&amp;width=300&amp;height=108&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=true&amp;appId=454354697977324\" scrolling=\"no\" frameborder=\"0\" style=\"overflow:hidden; width:300px; height:100px;background:#fff;\" allowTransparency=\"true\"></iframe>
                    <div>
                ";
            }
            
            private function _set_tips(){
                global $lock_tips;
                $this->tips = $lock_tips;
            }
            
            public function get_tip(){
                $tip = array();
                $tip['title'] = $this->tips['title'];
                $tip['tip'] = $this->tips['tips'][array_rand($this->tips['tips'])];
                return $tip;
            }
        }
    }
