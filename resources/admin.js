if (typeof lock_dashboard == "undefined") {
    var lock_dashboard = {}
}
jQuery(document).ready(function(){
    /**
     *handle_heartbeat
     *function to hanle lock/unlock with heartbeat
     */
    lock_dashboard.handle_heartbeat = function(){
        if (typeof wp == "object" && typeof wp.heartbeat == "object") {
            //wp.heartbeat.interval( 'fast' );
            jQuery(document).on( 'heartbeat-send', function( e, data ) {
                data['check_lock'] = true;
            });
            jQuery(document).on( 'heartbeat-tick', function( event, data ) {
                if ( data.hasOwnProperty( 'is_locked' ) ) {
                    if(data['is_locked'] == true &&
                       (typeof lock_dashboard.locked == "undefined" || lock_dashboard.locked == false)){
                        lock_dashboard.lock();
                    }
                    else if(data['is_locked'] == false && lock_dashboard.locked){
                        lock_dashboard.unlock_screen();
                    }
                    lock_dashboard.get_something();
                }
            })
        }
    }
    
    /**
     *@name handle_settings_event
     *function will handle events for settings page
     */
    lock_dashboard.handle_settings_event = function(){
        var _settings_page = jQuery(".wp-lock-settings")
        if (_settings_page .length > 0){
            var _btn_reset = jQuery("#btn-reset-lock-pin");
            var _btn_validate_wp_pwd = jQuery("#btn-validate-wp-passwd");
            var _btn_submit_pin = jQuery("#btn-submit-new-pin");
            var _btn_cancel_pin_setup = jQuery(".btn-cancel-pin-setup");
            
            var _box_step_one = jQuery(".lock-pin-set");
            var _box_step_two = jQuery(".lock-pin-wp-pwd");
            var _box_step_three = jQuery(".lock-pin-new-pin");
            var _box_success = jQuery(".pin-set-success");
            
            var _txt_wp_passwd = jQuery("#txt_lock_wp_passwd");
            var _error_wp_passwd = jQuery(".error_wp_pwd");
            
            var _txt_new_pin = jQuery(".txt-new-pin-contr input[type='password']");
            var _txt_confirm_pin = jQuery(".txt-confirm-pin-contr input[type='password']");
            var _error_new_pin = jQuery(".error_new_pin");
            var _error_confirm_pin = jQuery(".error_confirm_pin");
            
            _btn_reset.unbind("click");
            _btn_reset.click(function(e){
                e.preventDefault();
                _box_step_one.hide();
                _box_step_two.show();
                _txt_wp_passwd.focus();
            });
            
            _btn_validate_wp_pwd.unbind("click");
            _btn_validate_wp_pwd.click(function(e){
                e.preventDefault();
                _error_wp_passwd.hide();
                if (_txt_wp_passwd.val().trim() == '') {
                    _error_wp_passwd.html(lock_global_vars.messages['security_pin_wp_passwd_blank']);
                    _error_wp_passwd.show();
                    return;
                }
                jQuery.ajax({
                    url: lock_dashboard.lock_admin_url+'admin-ajax.php?action=settings_validate_wp_passwd',
                    type: 'post',
                    data: {input_passwd: _txt_wp_passwd.val().trim()},
                    beforeSend: function(){
                        _btn_validate_wp_pwd.parent().hide();
                        _btn_validate_wp_pwd.parent().next('.lock-loader').show();
                    },
                    success: function(response){
                        if(typeof response.status != "undefined" && response.status){
                            _box_step_two.hide();
                            _box_step_three.show();
                            _txt_new_pin.first().focus();
                        }
                        else{
                            if (typeof response.message != "undefined") {
                                _error_wp_passwd.html(response.message);
                            }
                            else{
                                _error_wp_passwd.html(lock_global_vars.messages['security_pin_wp_passwd_invalid']);
                            }
                            _error_wp_passwd.show();
                        }
                    },
                    complete: function(){
                        _btn_validate_wp_pwd.parent().next('.lock-loader').hide();
                        _btn_validate_wp_pwd.parent().show();
                    }
                })
            });
            
            _txt_wp_passwd.unbind('keypress');
            _txt_wp_passwd.keypress(function(e){
                var keyCode = e.keyCode || e.which;
                if (keyCode == 13) {
                   _btn_validate_wp_pwd.trigger("click")
                }
            });
            
            _btn_submit_pin.unbind("click");
            _btn_submit_pin.click(function(e){
                _error_new_pin.hide();
                _error_confirm_pin.hide();
                e.preventDefault();
                var new_pin = "";
                var confirm_pin = "";
                _txt_new_pin.each(function(){
                    new_pin += jQuery(this).val();
                });
                _txt_confirm_pin.each(function(){
                    confirm_pin += jQuery(this).val();
                })
                if (new_pin.length != 4) {
                    _error_new_pin.html(lock_global_vars.messages['security_pin_new_pin_blank']);
                    _error_new_pin.show();
                    return;
                }
                if (confirm_pin.length != 4) {
                    _error_confirm_pin.html(lock_global_vars.messages['security_pin_new_pin_blank']);
                    _error_confirm_pin.show();
                    return;
                }
                
                if (new_pin != confirm_pin){
                    _error_confirm_pin.html(lock_global_vars.messages['security_pin_new_pin_mismatch']);
                    _error_confirm_pin.show();
                    return;
                }
                
                jQuery.ajax({
                    url: lock_dashboard.lock_admin_url+'admin-ajax.php?action=settings_save_new_pin',
                    type: 'post',
                    data: {
                        input_passwd: _txt_wp_passwd.val(),
                        user_new_pin: new_pin,
                        user_confirm_pin: confirm_pin
                    },
                    beforeSend: function(){
                        _btn_submit_pin.parent().hide();
                        _btn_submit_pin.parent().next('.lock-loader').show();
                    },
                    success: function(response){
                        if(typeof response.status != "undefined" && response.status){
                            _box_step_three.hide();
                            _box_success.show();
                        }
                        else{
                            if (typeof response.message != "undefined") {
                                _error_new_pin.html(response.message);
                            }
                            else{
                                _error_new_pin.html(lock_global_vars.messages['security_pin_error_occured']);
                            }
                            _error_new_pin.show();
                        }
                    },
                    complete: function(){
                        _btn_submit_pin.parent().next('.lock-loader').hide();
                        _btn_submit_pin.parent().show();
                    },
                });
            });
            
            _btn_cancel_pin_setup.unbind("click")
            _btn_cancel_pin_setup.click(function(){
                _box_step_two.hide();
                _box_step_three.hide();
                _box_step_one.show();
                _txt_wp_passwd.val('')
                _error_new_pin.hide();
                _error_confirm_pin.hide();
                 _error_wp_passwd.hide();
            });
            
            lock_dashboard.handle_settings_pin_txt_box();
            lock_dashboard.handle_settings_autolock();
            lock_dashboard.handle_settings_background();
            lock_dashboard.handle_poweredby();
            lock_dashboard.handle_remove_image();
            lock_dashboard.set_color_container_height();
        }
    }

    /**
     *@name handle_lock_screen_pin
     *function will enable auto focus for PIN lock screen
     */
    lock_dashboard.handle_settings_pin_txt_box = function(){
        var _selector = jQuery(".text_settings_pin")
        var _btn_submit_pin = jQuery("#btn-submit-new-pin");
        if(_selector.length > 0){
            _selector.each(function(index, obje){
                var _this = jQuery(this)
                _this.unbind("keydown");
                _this.keydown(function(e){
                    if ((e.which == 8 || e.which == 46) && _this.val() == '') {
                        _this.prev('input').focus();
                    }
                    else if(_this.val().length > 0 && _this.next().length == 0 && (e.which != 8 && e.which != 46)){
                        e.preventDefault();
                    }
                });
                
                _this.unbind("keyup");
                _this.keyup(function(e){
                    if(_this.val().length > 0 && _this.next().length > 0){
                        _this.next().focus();
                    }
                });
                _this.unbind("focus");
                _this.focus(function(e){
                    _this.val('');
                });
                
                _this.unbind("keypress");
                _this.keypress(function(e){
                    var keyCode = e.keyCode || e.which;
                    if (keyCode == 13) {
                       _btn_submit_pin.trigger("click")
                    }
                });
            });
        }
    }
    
    /**
     *@name handle_settings_background
     *function will handle events for settings background
     */
    lock_dashboard.handle_settings_background = function(){
        var _btn_image_selector         = jQuery(".setting_img_selector li");
        var _btn_open_library           = jQuery(".setting_img_selector li.add-new");
        var _btn_save_setting           = jQuery("#btn-lock-submit-bg");
        
        var _btn_color_main_select      = jQuery(".color-main-selector li");
        var _btn_color_pallet_select    = jQuery(".lock_pallete li");
        
        var _box_lock_palette           = jQuery(".lock_pallete");

        var _message                    = jQuery(".appearance-set-success")

        var _checked_img_count          = 0;
        
        _btn_image_selector.each(function(){
            var _this = jQuery(this);
            _this .unbind("click");
            _this .click(function(e){
                if(!jQuery(e.target).hasClass('btn_remove_image')){
                    e.preventDefault();
                    var _checkbox = jQuery("input[type='checkbox']", _this);
                    _btn_color_pallet_select.each(function(){
                        jQuery(this).removeClass("selected");
                        jQuery("input[type='checkbox']",this).removeAttr("checked");
                    })
                    if(_checkbox.is(":checked")){
                        _checkbox.removeAttr("checked")
                        _this.removeClass("selected");
                        if(_checked_img_count> 0)
                            _checked_img_count--;
                    }
                    else{
                        _checkbox.attr("checked", "checked")
                        _this.addClass("selected");
                        _checked_img_count++;
                    }
                }

                if(_checked_img_count > 0){
                    jQuery(".color-picker-outer-wrap").closest('.featured-panel-right-frame').removeClass('selected-section');
                    jQuery(".setting_img_selector").closest('.featured-panel-left-frame').addClass('selected-section');
                }
                else{
                    jQuery(".setting_img_selector").closest('.featured-panel-left-frame').removeClass('selected-section');
                }
            });
        });
        
        _btn_save_setting.unbind("click")
        _btn_save_setting.click(function(e){
            e.preventDefault();
            var _selected_images = jQuery(".wp-lock-screen-bg")
            var data = {};
            data.selected_images = new Array();
            _selected_images.each(function(){
                var _check = jQuery(this);
                if (_check.is(":checked")) {
                    data.selected_images.push(_check.val())
                }
            });
            
            if (data.selected_images.length == 0) {
                var _selected_colors = jQuery(".wp-lock-screen-color")
                var data = {};
                data.selected_colors = new Array();
                _selected_colors.each(function(){
                    var _check = jQuery(this);
                    if (_check.is(":checked")) {
                        data.selected_color = _check.val()
                    }
                });
            }

            if (
                (typeof data.selected_images == "undefined" || data.selected_images.length == 0) &&
                (typeof data.selected_color == "undefined" || data.selected_color.length == 0)
            ){
                _message.hide();
                jQuery('.error_appearance').show();
                return;
            }
            
            
            jQuery.ajax({
                url: lock_dashboard.lock_admin_url+'admin-ajax.php?action=settings_save_bg',
                type: 'post',
                data: data,
                beforeSend: function(){
                    jQuery('.error_appearance').hide();
                    _message.hide();
                    _btn_save_setting.parent().hide();
                    _btn_save_setting.parent().next('.lock-loader').show();
                },
                success: function(response){
                    _message.show();
                },
                complete: function(){
                    _btn_save_setting.parent().next('.lock-loader').hide();
                    _btn_save_setting.parent().show();
                },
            });
        });
        

        _btn_color_main_select.each(function(){
            jQuery(this).unbind("click");
            jQuery(this).click( function(){
                _checked_img_count = 0;
                _btn_color_main_select.each(function(){
                    jQuery(this).removeClass('active')
                })
                var rel = jQuery(this).attr("rel");
                jQuery(this).addClass('active')
                _box_lock_palette.hide();

                jQuery(".setting_img_selector").closest('.featured-panel-left-frame').removeClass('selected-section');
                jQuery(".color-picker-outer-wrap").closest('.featured-panel-right-frame').addClass('selected-section');
                jQuery(".pallete_"+rel).show();
                jQuery(jQuery(".pallete_"+rel).find('li').get(0)).trigger('click');
            })
        });
        
        
        _btn_color_pallet_select.each(function(){
            jQuery(this).unbind("click");
            jQuery(this).click( function(){
                _checked_img_count = 0;
                var _selected_images = jQuery(".wp-lock-screen-bg")
                var data = {};
                data.selected_images = new Array();
                _selected_images.each(function(){
                    jQuery(this).removeAttr("checked");
                    jQuery(this).parent().removeClass("selected");
                });
                _btn_color_pallet_select.each(function(){
                    jQuery(this).removeClass("selected");
                    jQuery("input[type='checkbox']",this).removeAttr("checked");
                })
                
                jQuery(this).addClass("selected")
                jQuery("input[type='checkbox']",this).attr("checked","checked");
                jQuery(".setting_img_selector").closest('.featured-panel-left-frame').removeClass('selected-section');
                jQuery(".color-picker-outer-wrap").closest('.featured-panel-right-frame').addClass('selected-section');
            });
        });

        _btn_open_library.unbind('click');
        _btn_open_library.click(function(event){
            event.preventDefault();
            event.stopPropagation();
            if (wp.media.frames.lock) {
                wp.media.frames.lock.open();
                return;
            }

            wp.media.frames.lock = wp.media({
                title: lock_global_vars.messages['appearance_bg_image_add_popup_title'],
                button: {
                    text: lock_global_vars.messages['appearance_bg_image_add_popup_button']
                },
                multiple: false
            });
            
            wp.media.frames.lock.open();
            
            wp.media.frames.lock.on('select', function() {
                _btn_color_pallet_select.each(function(){
                    jQuery(this).removeClass("selected");
                    jQuery("input[type='checkbox']",this).removeAttr("checked");
                })
                var _attachment = wp.media.frames.lock.state().get('selection').first().toJSON();
                var _checker    = jQuery('.setting-library-images input[type="checkbox"][value="' + _attachment.url + '"]');

                if(_checker.length == 1 && ! _checker.is(':checked')){
                    _checker.closest('li').trigger('click');
                }
                else if(_checker.length == 0){
                    var new_img = '<li class="selected">';
                        new_img += '<a href="javascript:;" class="btn_remove_image"></a>'
                        new_img += '<input type="checkbox" class="wp-lock-screen-bg" value="' + _attachment.url +'" checked="checked" />';
                        new_img += '<img src="' + _attachment.url +'" />'
                    new_img += '</li>';

                    jQuery(new_img).insertBefore('.setting-library-images .add-new');

                    if(jQuery('.settings-no-image-library').length > 0){
                        jQuery('.settings-no-image-library').remove();
                    }

                    jQuery.ajax({
                        url: lock_dashboard.lock_admin_url+'admin-ajax.php?action=settings_add_imge_from_library',
                        type: 'post',
                        data: {
                            selected_image: _attachment.url
                        },
                        success: function(response){
                            if(typeof response.status != "undefined" && response.status){
                                
                            }
                            else{
                                
                            }
                        }
                    });
                    lock_dashboard.handle_remove_image();  
                    lock_dashboard.handle_settings_background(); 
                    lock_dashboard.set_color_container_height();
                    jQuery(".color-picker-outer-wrap").closest('.featured-panel-right-frame').removeClass('selected-section');
                    jQuery(".setting_img_selector").closest('.featured-panel-left-frame').addClass('selected-section');
                }
            });
        })   
    }

    /**
     *@name handle_remove_image
     *function will handle remove image button event 
     */
    lock_dashboard.handle_remove_image = function(){
        var _btn = jQuery('.btn_remove_image');
        _btn.each(function(){
            jQuery(this).unbind('click');
            jQuery(this).click(function(e){
                e.preventDefault();
                e.stopPropagation();
                var _this       = jQuery(this)
                jQuery("#confirm-image-delete").fadeIn();
                jQuery("#confirm-image-delete .btn-do-cancel").unbind('click');
                jQuery("#confirm-image-delete .btn-do-cancel").click(function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    var _checkbox   = _this.parent().find('input[type="checkbox"]');

                    var _image_url = _checkbox.val();

                    var _li_calsses = '';
                    jQuery.ajax({
                        url: lock_dashboard.lock_admin_url+'admin-ajax.php?action=settings_remove_imge_from_library',
                        type: 'post',
                        data: {
                            image: _image_url
                        },
                        beforeSend: function(){
                            jQuery("#confirm-image-delete").fadeOut();
                            _li_calsses = _this.closest('li').attr('class');
                            _this.closest('li').removeClass().addClass('imgloader');
                        },
                        success: function(response){
                            if(typeof response.status != "undefined" && response.status){
                                _this.parent().fadeOut('slow', function(){
                                    _this.parent().remove();
                                    lock_dashboard.set_color_container_height();
                                    if(jQuery('.setting_img_selector').find('input[type="checkbox"]:checked').length == 0){
                                        if(jQuery(".lock_pallete").find('input[type="checkbox"]:checked').length == 0){
                                            jQuery('.color-main-selector li').first().trigger('click');
                                        }
                                    }
                                });
                            }
                            else{
                                if(_li_calsses)
                                    _this.closest('li').removeClass().addClass(_li_calsses);
                            }
                        }
                    });
                });
            });
        });

        jQuery(".btn-cancel-delete").unbind('click');
        jQuery(".btn-cancel-delete").click(function(e){
            e.preventDefault();
            e.stopPropagation();
            jQuery("#confirm-image-delete").fadeOut();
        })
    }
    
    /**
     *@name handle_settings_autolock
     *funtion to handle auto lock events
     */
    lock_dashboard.handle_settings_autolock = function(){
        var _select = jQuery("#lock-auto-lock-period");
        var _label = jQuery(".lock-auto-lock-period-label");
        var _btn = jQuery("#btn-submit-auto-lock");
        var _error = jQuery(".error_autolock");
        var _box_form = jQuery(".autolock-period-form");
        var _box_success = jQuery(".autolock-period-success");
        
        _select.unbind("change")
        _select.change(function(){
            if (jQuery(this).val() == 0) {
                _label.html(lock_global_vars.messages['autolock_disabled_label']);
            }
            else{
                _label.html(lock_global_vars.messages['autolock_enabled_label']);
            }
        });
        
        _btn.unbind("click");
        _btn.click(function(e){
            e.preventDefault();
            jQuery.ajax({
                url: lock_dashboard.lock_admin_url+'admin-ajax.php?action=settings_save_autolock',
                type: 'post',
                data: {
                    input_auto_lock: _select.val()
                },
                beforeSend: function(){
                    _box_success.hide();
                    _btn.parent().hide();
                    _btn.parent().next('.lock-loader').show();
                },
                success: function(response){
                    if(typeof response.status != "undefined" && response.status){
                        lock_dashboard.auto_lock_seconds = parseInt(_select.val());
                        _box_success.show();
                        clearInterval(lock_dashboard.auto_lock_interval);
                        lock_dashboard.check_idle_time();
                    }
                    else{
                        if (typeof response.message != "undefined") {
                            _error.html(response.message);
                        }
                        else{
                            _error.html(lock_global_vars.messages['autolock_updation_error']);
                        }
                        _error.show();
                    }
                },
                complete: function(){
                    _btn.parent().next('.lock-loader').hide();
                    _btn.parent().show();
                }
            });
        })
    }
    
    /**
     *@name function will handle idle timeout
     *time will reset on mousemove or keypress
     */
    lock_dashboard.check_idle_time = function() {
        if(typeof(Storage) !== "undefined") {
            localStorage.lock_user_active = 1;
        }
        else{
            localStorage = {};
            localStorage.lock_user_active = 1;
        }
        lock_dashboard.idel_seconds = 0;
        if (typeof lock_dashboard.auto_lock_seconds != "undefined") {
            if(parseInt(lock_dashboard.auto_lock_seconds) > 0 ){
                lock_dashboard.auto_lock_interval = setInterval(function(){
                    if (localStorage.lock_user_active == 1) {
                        lock_dashboard.idel_seconds = 0;
                        lock_dashboard.close_auto_lock_msg();
                    }
                    lock_dashboard.idel_seconds++;
                    localStorage.lock_user_active = 0;
                    if (parseInt(lock_dashboard.auto_lock_seconds) > 0) {
                        if (lock_dashboard.idel_seconds > (parseInt(lock_dashboard.auto_lock_seconds)) && !lock_dashboard.locked) {
                            lock_dashboard.idel_seconds = 0;
                            lock_dashboard.auto_lock();
                        }
                        else if ((parseInt(lock_dashboard.auto_lock_seconds)) - lock_dashboard.idel_seconds < 10) {
                            lock_dashboard.show_auto_lock_msg(lock_dashboard.idel_seconds);
                        }
                    }
                }, 1000); // 1 second
                jQuery(document).mousemove(function (e) {
                    lock_dashboard.idel_seconds = 0;
                    localStorage.lock_user_active = 1;
                    lock_dashboard.close_auto_lock_msg();
                });
                jQuery(document).keypress(function (e) {
                    localStorage.lock_user_active = 1;
                    lock_dashboard.idel_seconds = 0;
                    lock_dashboard.close_auto_lock_msg();
                });
            }
            else{
                lock_dashboard.idel_seconds = 0;
            }
        }
    }
    
    /**
     *@name show_auto_lock_msg
     *function will show a popup before auto locking
     *@param time
     */
    lock_dashboard.show_auto_lock_msg = function(time){
        if (lock_dashboard.locked) {
            return;
        }
        if(jQuery(".lock-auto-lock-not").length == 0){

            var lock_not = '<div class="lock-not-mask"></div><div class="lock-notice lock-confirm lock-auto-lock-not">';
                lock_not += '<h3>Dashboard Auto Lock</h3>';
                    lock_not += '<p>';
                        lock_not += 'You\'r idle for past ' + time + ' seconds';
                    lock_not += '</p>';
                    lock_not += '<p>Dashboard will be locked in <span class="lock-not-time"></span> seconds <p></div>';
            lock_not += '</div>'
            jQuery("#wpbody-content").append(lock_not);
        }
        
        jQuery(".lock-not-time").html((parseInt(lock_dashboard.auto_lock_seconds)) - time)
    }
    
    /**
     *@name show_auto_lock_msg
     *function will close popup shown before auto lock
     */
    lock_dashboard.close_auto_lock_msg = function(){
        jQuery(".lock-not-mask").remove();
        jQuery(".lock-auto-lock-not").remove();
    }
    
    /**
     *@name handle_powered_by_submit
     *function will do submit powered by settings
     */
    lock_dashboard.handle_poweredby = function(){
        var _from = jQuery(".lock-poweredby-form");
        var _success = jQuery(".poweredby-success");
        var _btn = jQuery("#btn-lock-submit-powered");
        var _select = jQuery("#lock-powered");
        var _error = jQuery(".error_poweredby");
        _btn.unbind("click");
        _btn.click(function(e){
            e.preventDefault();
            jQuery.ajax({
                url: lock_dashboard.lock_admin_url+'admin-ajax.php?action=settings_save_poweredby',
                type: 'post',
                data: {
                    input_enable_powered: _select.val()
                },
                beforeSend: function(){
                    _success.hide();
                    _btn.parent().hide();
                    _btn.parent().next('.lock-loader').show();
                },
                success: function(response){
                    if(typeof response.status != "undefined" && response.status){
                        _success.show();
                    }
                    else{
                        if (typeof response.message != "undefined") {
                            _error.html(response.message);
                        }
                        else{
                            _error.html("Error occured while updating your settings.");
                        }
                        _error.show();
                    }
                },
                complete: function(){
                    _btn.parent().next('.lock-loader').hide();
                    _btn.parent().show();
                }
            });
        })
    }


    /**
     *@name hide_messages
     *function will automatically hide messages displayed
     */
    lock_dashboard.hide_messages = function(){
        lock_dashboard.message_timer = setTimeout(function(){
            jQuery('.lock_success').each(function(){
                if(!jQuery(this).hasClass('pin-set-success')){
                    jQuery(this).hide();
                }
            });
        }, 5000)
    }


    lock_dashboard.set_color_container_height = function(){
        jQuery(".featured-panel-right-frame").height(jQuery(".featured-panel-left-frame").height())
        jQuery(".divider-line").height(jQuery(".featured-panel-left-frame").height() + 32)
    }


    jQuery( document ).ajaxStart(function() {
        jQuery('.lock_success').each(function(){
            if(!jQuery(this).hasClass('pin-set-success')){
                jQuery(this).hide();
            }
        });
        clearTimeout(lock_dashboard.message_timer);
    });

    jQuery( document ).ajaxComplete(function() {
        lock_dashboard.hide_messages();
    });

    jQuery(window).resize(function(){
        lock_dashboard.set_color_container_height();
    })
    
    lock_dashboard.handle_heartbeat();
});