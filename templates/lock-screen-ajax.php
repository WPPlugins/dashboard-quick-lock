<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<script type="text/javascript">
    lock_dashboard.bgs = []
    <?php
        $div_style = 'margin:0; padding:0;';
        if(isset($background['images']) && is_array($background['images']) && !empty($background['images'])):
            foreach($background['images'] as $key=>$bg):
                ?>
                lock_dashboard.bgs.push(
                    <?php echo "{ src: '$bg'}"; ?>
                );
                <?php
            endforeach;
        elseif(isset($background['color']) && $background['color'] != ''):
            $div_style = 'background:'.$background['color'].';transition: background-color 1s linear;';
        endif;
    ?>
</script>
<div class="lock-screen-ajax" id="lock-screen" style="<?php echo $div_style; ?>">
    <div class="body">
        <div class="site-name"><?php echo $site_title; ?></div>
        <div class="login-main-wrapper">
            <a href="<?php echo wp_login_url(); ?>" class="switch-user"><img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/switch_user.png" alt="" /></a>
             <div class="switch-wrapper switch-wrapper-noti" style="display: none;">
                <span class="notification-tip"></span>
                <div class="tip-head"><?php echo $lang['switch_user_title']; ?></div>
                <p><?php echo $lang['switch_user_desc']; ?></p>
            </div>
            <div class="login-wrap">
                <div class="profile-pic">
                    <?php echo get_avatar($this->current_user->ID, 80); ?>
                </div>
                <div class="credential-cntnr">
                     <h2><?php echo $this->current_user->display_name; ?></h2>
                    <div class="credential-inner lock-passwd-container" style="display: none;">
                        <div class="ct-inner">
                            <form action="" method="post" id="unlock-with-password">
                                <input type="password" class="text_lock_password" id="text_lock_password" placeholder="<?php echo $lang['password_placeholder']; ?>"  />
                            </form>
                        </div>

                    </div>
                    <div class="credential-inner lock-loggin-in-cntr" style="display: none;">
                        <div class="login"><?php echo $lang['authenticating']; ?> <img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/loader.gif" alt="" /></div>
                    </div>
                    <div class="credential-inner lockscreen-pin-container" >
                        <div class="ct-inner">
                            <input type="password" class="text_lock_pin" maxlength="1" autofocus />
                            <input type="password" class="text_lock_pin" maxlength="1" />
                            <input type="password" class="text_lock_pin" maxlength="1" />
                            <input type="password" class="text_lock_pin" maxlength="1" />
                        </div>
                        <script type="text/javascript">
                            var dq_nonce = '<?php echo wp_create_nonce( "dq-lock-nonce" ); ?>';
                        </script>
                    </div>

                </div>
                <div class="signin-options" style="display: none;">
                    <p><?php echo $lang['signin_options']; ?></p>
                    <a href="javascript:;" rel=".lock-passwd-container"><img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/password.png" 
                        alt="<?php echo $lang['btn_password_title']; ?>" title="<?php echo $lang['btn_password_title']; ?>" /></a>
                    <a href="javascript:;" rel=".lockscreen-pin-container" class="selected"><img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/pin.png" 
                        alt="<?php echo $lang['btn_pin_title']; ?>" title="<?php echo $lang['btn_pin_title']; ?>" /></a>
                </div>
            </div>

            <div class="error-wrapper"  style="display: none;">
                <span class="notification-tip"></span>
                <div class="hint-icon">
                    <img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/error.png" alt="">
                </div>
                <div class="tip-head"><?php echo $lang['pin_incorrect_title']; ?></div>
                <p><?php echo $lang['password_incorrect_descr']; ?></p>
            </div>
            <?php if($defualt_pin): ?>
                <div class="hints-wrapper one"  style="display: block;">
                    <span class="notification-tip"></span>
                    <div class="hint-icon">
                        <img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/info.png" alt="">
                    </div>
                    <div class="tip-head"><?php echo str_replace('default_pin', $defualt_pin, $lang['default_pin_title']); ?></div>
                    <p><?php echo $lang['default_pin_desc']; ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="widget-wrap">
            <div class="time-clock" id="lock-screen-datetime">
                <h4></h4>
                <p></p>
            </div>
            <div class="normal-notifications">
                <ul>
                    <li>
                        <a href="javascript:;">
                            <span class="bg-blue">
                                <img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/pages-icon.png" alt="" />
                            </span>
                            <i class='count_published_pages'><?php echo ($published_pages_count) ? $published_pages_count : 0; ?></i>
                            <?php echo $lang['published_pages']; ?>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="bg-green">
                                <img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/comments-icon.png" alt="" />
                            </span>
                            <i class='count_comments'><?php echo ($comments_count) ? $comments_count : 0; ?></i>
                            <?php echo $lang['comments']; ?>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="bg-orange">
                                <img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/moderation-icon.png" alt="" />
                            </span>
                            <i class='count_in_moderation'><?php echo ($moderated) ? $moderated : 0; ?></i>
                            <?php echo $lang['in_moderation']; ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="realtime-notifications lock-tip-box" rel="<?php echo ($defualt_pin) ? true : false; ?>"><!--Reduced width is 63px and Full width is 100%-->
                <div class="tips-img">
                    <img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/tips.png" alt="" />
                </div>
                <div class="notification-panel" style="">
                    <div class="rlnt-head"><?php echo $tip['title']; ?></div>
                    <p><?php echo $tip['tip']; ?></p>
                </div>

            </div>
        </div>

        <div class="lock-footer">
            <img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/logo.png" alt="" class="lock-logo" />

            <?php if((isset($show_powered_by)) && $show_powered_by == 1): ?>
                <p>by <a href="http://quintetsolutions.com" target="_blank"><img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/quintet.png" alt="" /></a></p>
            <?php endif; ?>
        </div>
    </div>
</div>
