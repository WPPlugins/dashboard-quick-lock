<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="wrap wp-lock-settings">
    <h2><?php echo $lang['settings_title']; ?></h2>
    <p>
        <?php echo $lang['settings_description']; ?>
    </p>
    <div class="lock-outer-frame">
        <div class="lock-data-wrap-left">
            
            <div class="featured-panel">
                <label class="hndle-head"><?php echo $lang['security_pin_title']; ?></label>
                <div class="featured-panel-content-wrap lock-pin-set">
                    <h4><?php echo $lang['security_pin_enabled']; ?></h4>
                    <?php if(isset($defualt_pin) && $defualt_pin): ?>
                        <small>
                            <?php echo str_replace('defualt_pin', $defualt_pin, $lang['security_pin_defult_set']); ?>
                        </small>
                    <?php endif; ?>
                    <div class="button-wrap">
                        <input type="button" class="button button-primary" value="<?php echo $lang['security_pin_btn_reset']; ?>" id="btn-reset-lock-pin" />
                    </div>
                </div>
                <div class="featured-panel-content-wrap lock-pin-wp-pwd lock-display-none">
                    <h5><?php echo $lang['security_pin_wp_passwd_label']; ?></h5>
                    <input type="password" placeholder="Password" id="txt_lock_wp_passwd" />
                    <span class="lock_error error_wp_pwd"></span>
                    <div class="button-wrap">
                        <input type="button" class="button button-primary" value="<?php echo $lang['security_btn_submit']; ?>" id="btn-validate-wp-passwd" />
                        <input type="button" class="button btn-cancel-pin-setup" value="<?php echo $lang['security_btn_cancel']; ?>" />
                    </div>
                    <div class="button-wrap lock-loader"></div>
                </div>
                <div class="featured-panel-content-wrap lock-pin-new-pin lock-display-none">
                    <h5><?php echo $lang['security_pin_new_pin_label']; ?></h5>
                    <div class="split-input-frame txt-new-pin-contr">
                        <input type="password" maxlength="1" class="text_settings_pin" />
                        <input type="password" maxlength="1" class="text_settings_pin" />
                        <input type="password" maxlength="1" class="text_settings_pin" />
                        <input type="password" maxlength="1" class="text_settings_pin" />
                        <span class="lock_error error_new_pin"></span>
                    </div>
                    <h5><?php echo $lang['security_pin_confirm_new_pin_label']; ?></h5>
                    <div class="split-input-frame txt-confirm-pin-contr">
                        <input type="password" maxlength="1" class="text_settings_pin" />
                        <input type="password" maxlength="1" class="text_settings_pin" />
                        <input type="password" maxlength="1" class="text_settings_pin" />
                        <input type="password" maxlength="1" class="text_settings_pin" />
                        <span class="lock_error error_confirm_pin"></span>
                    </div>
                    <div class="button-wrap">
                        <input type="button" class="button button-primary" value="<?php echo $lang['security_btn_submit']; ?>"  id="btn-submit-new-pin" />
                        <input type="button" class="button btn-cancel-pin-setup" value="<?php echo $lang['security_btn_cancel']; ?>" />
                    </div>
                    <div class="button-wrap lock-loader"></div>
                </div>
                <div class="featured-panel-content-wrap pin-set-success lock_success lock-display-none">
                    <?php echo $lang['security_pin_new_pin_updated']; ?>
                </div>
            </div>
            
            <div class="featured-panel">
                <label class="hndle-head"><?php echo $lang['autolock_title']; ?></label>
                <div class="featured-panel-content-wrap">
                    <p><?php echo $lang['autolock_description']; ?></p>
                    <div class="autolock-period-form">
                        <div class="select-wrap">
                            <h5 class="lock-auto-lock-period-label">
                                <?php echo (isset($autolock_selected_time) && $autolock_selected_time) ? $lang['autolock_enabled_label'] : $lang['autolock_disabled_label']; ?>
                            </h5>
                            <?php if(isset($autolock_periods) && !empty($autolock_periods)): ?>
                                <select name="lock-auto-lock-period" id="lock-auto-lock-period">                                
                                    <?php foreach($autolock_periods as $value => $label): ?>
                                        <?php $selected = (isset($autolock_selected_time) && $autolock_selected_time == $value) ? 'selected="selected"' : ''; ?>
                                        <option value="<?php echo $value; ?>" <?php echo $selected; ?> ><?php echo $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="lock_error error_autolock lock-display-none"></span>
                            <?php endif; ?>
                        </div>
                        <div class="button-wrap">
                            <input type="button" class="button button-primary" value="<?php echo $lang['security_btn_save']; ?>" id="btn-submit-auto-lock" />
                        </div>
                        <div class="button-wrap lock-loader"></div>
                    </div>
                    <div class="select-wrap autolock-period-success lock_success lock-display-none">
                        <?php echo $lang['autolock_updated']; ?>
                    </div>
                </div>
            </div>
            
            <div class="featured-panel">
                <label class="hndle-head"><?php echo $lang['appearance_title']; ?></label>
                <div class="featured-panel-content-wrap">
                    <div class="featured-panel-left-frame left <?php echo (isset($selected_bg) && is_array($selected_bg['images']) && !empty($selected_bg['images'])) ? 'selected-section' : ''; ?>">
                        <h5><?php echo $lang['appearance_bg_image_title']; ?></h5>
                        <p><?php echo $lang['appearance_bg_image_description']; ?></p>
                        <?php if(isset($def_bg_images) && !empty($def_bg_images)): ?>
                            <div class="image-prev-frame">
                                <ul class="setting_img_selector">
                                    <?php foreach( $def_bg_images as $image): ?>
                                        <?php
                                            $selected = (isset($selected_bg) && is_array($selected_bg['images']) && in_array($image, $selected_bg['images'])) ? true : false;
                                            $checked = ($selected) ? "checked='checked'" : "";
                                            $class = ($selected) ? "selected" : "";
                                        ?>
                                        <li class="<?php echo $class; ?>">
                                            <input type="checkbox" class="wp-lock-screen-bg" value="<?php echo $image; ?>" <?php echo $checked; ?> />
                                            <img src="<?php echo $image; ?>" />
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <h5><?php echo $lang['appearance_bg_image_from_library']; ?></h5>
                        <div class="image-prev-frame">
                            <?php 
                                if($bg_images_library){
                                    $bg_images_library = unserialize($bg_images_library);
                                }
                            ?>
                            <?php if(isset($bg_images_library) && !empty($bg_images_library)): ?>
                                <ul class="setting_img_selector setting-library-images">
                                    <?php foreach( $bg_images_library as $image): ?>
                                        <?php
                                            $selected  = false;
                                            if(isset($selected_bg['images']) && is_array($selected_bg['images']) && !empty($selected_bg['images'])){
                                                $selected  = (isset($selected_bg['images']) && in_array($image, $selected_bg['images'])) ? true : false;
                                            }
                                            $checked   = ($selected) ? "checked='checked'" : "";
                                            $class     = ($selected) ? "selected" : "";
                                        ?>
                                        <li class="<?php echo $class; ?>">
                                            <a href="javascript:;" class='btn_remove_image'></a>
                                            <input type="checkbox" class="wp-lock-screen-bg" value="<?php echo $image; ?>" <?php echo $checked; ?> />
                                            <img src="<?php echo $image; ?>" />
                                        </li>
                                    <?php endforeach; ?>
                                    <li class="add-new"></li>
                                </ul>
                            <?php else: ?>
                                <div class='settings-no-image-library'><?php echo $lang['appearance_bg_image_library_empty']; ?></div>
                                <ul class="setting_img_selector setting-library-images">
                                    <li class="add-new"></li>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="divider-line">
                        <span class="circular-wrap"><?php echo $lang['appearance_or']; ?></span>
                    </div>
                    <div class="featured-panel-right-frame right <?php echo (isset($selected_bg) && $selected_bg['color'] != '') ? 'selected-section' : ''; ?>">
                        <?php if(isset($def_bg_colors) && !empty($def_bg_colors)): ?>
                            <?php $selected_color = (isset($selected_bg) && $selected_bg['color'] != '') ? $selected_bg['color'] : $def_bg_colors[0]['main_color']; ?>
                            <h5><?php echo $lang['appearance_bg_color_title']; ?></h5>
                            <p><?php echo $lang['appearance_bg_color_description']; ?></p>
                            <div class="color-picker-outer-wrap">
                                <div class="color-pool-frame">
                                    <?php foreach($def_bg_colors as $key => $color): ?>
                                        <?php $display = (in_array($selected_color, $color['pallete'])) ? 'style="display:block"' : ''; ?>
                                        <ul class="lock_pallete pallete_<?php echo $key; ?>" <?php echo $display; ?>>
                                            <?php foreach($color['pallete'] as $light_color): ?>
                                                <?php $class = (!empty($selected_bg['color']) && $selected_color == $light_color) ? 'selected' : ''; ?>
                                                <?php $checked = (!empty($selected_bg['color']) && $selected_color == $light_color) ? 'checked="checked"' : ''; ?>
                                                <li style="background: <?php echo $light_color; ?>" class="<?php echo $class; ?>">
                                                    <input type="checkbox" class="wp-lock-screen-color" value="<?php echo $light_color; ?>" <?php echo $checked; ?> />
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endforeach; ?>
                                </div>
                                <div class="color-selector-frame">
                                    <ul class="color-main-selector">
                                        <?php foreach($def_bg_colors as $key => $color): ?>
                                            <?php $class = (in_array($selected_color, $color['pallete'])) ? "active" : ""; ?>
                                            <li style="background: <?php echo $color['main_color']; ?>" rel="<?php echo $key; ?>" class="<?php echo $class; ?>"></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="button-wrap">
                        <input type="button" class="button button-primary" value="<?php echo $lang['security_btn_save']; ?>" id="btn-lock-submit-bg" />
                    </div>
                    <div class="button-wrap lock-loader"></div>
                    <div class="featured-panel-content-wrap appearance-set-success lock_success lock-display-none">
                        <?php echo $lang['appearance_updated']; ?>
                    </div>
                     <span class="lock_error error_appearance"><?php echo $lang['appearance_bg_not_selected']; ?></span>
                </div>
            </div>
        </div>
        <div class="lock-data-wrap-right">
            <div class="blue-box">
                <a class="quintet-site-link" href="http://quintetsolutions.com" target="_blank">
                    <img src="<?php echo LOCK_PLUGIN_URL; ?>resources/img/site-image.jpg" alt="" />
                    <span>Quintet Solutions</span>
                </a>
            </div>
            <div class="gray-box">
                <?php echo $this->quintet_fb_box(); ?>
            </div>
            <div class="gray-box">
                <?php echo $this->quintet_gplus_box(); ?>
            </div>
        </div>
    </div>
    <div class="lock-notice lock-confirm" id="confirm-image-delete" style="display:none;">
        <h3><?php echo $lang['appearance_bg_image_remove_title']; ?></h3>
        <p>
            <?php echo $lang['appearance_bg_image_remove_message']; ?>
        </p>
        <div class="lockbutton red center btn-do-cancel"><?php echo $lang['appearance_bg_image_remove_confirm_btn']; ?></div>
        <div class="lockbutton light center btn-cancel-delete"><?php echo $lang['appearance_bg_image_remove_cancel_btn']; ?></div>
    </div>
</div>