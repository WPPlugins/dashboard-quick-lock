if (typeof lock_dashboard == "undefined") {
    var lock_dashboard = {}
}
jQuery(document).ready(function(){
    if (typeof lock_dashboard.locked == "undefiend") {
        lock_dashboard.locked = false;
    }
    
    lock_dashboard.check_timeout = 0;
    
    lock_dashboard.lock_screen_date_time = function(){
        if(typeof lock_dashboard.time_timer != "undefined" && lock_dashboard.time_timer > 0)
            clearTimeout(lock_dashboard.time_timer);

        var now = new Date();
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        jQuery("#lock-screen-datetime p").html(now.getDate() + " "+ months[now.getMonth()] + " " + now.getFullYear());
        
        set_time();
        function set_time() {
            var now = new Date();
            jQuery("#lock-screen-datetime h4").html(get_digit(now.getHours()) + ":" + get_digit(now.getMinutes()));
            
            if(lock_dashboard.locked)
                lock_dashboard.time_timer = setTimeout(set_time);
        }
    
        function get_digit(digit) {
            return ( digit > 9 ) ? digit : "0"+digit;
        }
    };
    
    /**
     *@name auto_lock
     *@description function to auto_lock
     */
    lock_dashboard.auto_lock = function(){
        lock_dashboard.idel_seconds = 0;
        lock_dashboard.close_auto_lock_msg();
        if(typeof lock_dashboard.locked != "undefined" && lock_dashboard.locked == true)
            return;
        if (lock_dashboard.locked) {
            return;
        }
        if(typeof(Storage) === "undefined") {
            localStorage = {};
        }
        localStorage.auto_lock_xhr = jQuery.ajax({
            url: lock_dashboard.lock_admin_url+'admin-ajax.php?action=auto_lock',
            type: 'post',
            data: lock_global_vars,
            success: function(response){
                if (response != 0) {
                    lock_dashboard.close_auto_lock_msg();
                    lock_dashboard.locked = true;
                    lock_dashboard.direct_lock = false;
                    
                    if (typeof response.is_admin == "undefined" || response.is_admin == true) {
                        if ((lock_global_vars.is_admin)) {
                            if(jQuery("#lock-mask").length == 0){
                                jQuery("body").append("<div id='lock-mask'/>");
                                jQuery("body").append("<div id='lock-screen-cont'/>");
                            }
                            else{
                                jQuery("#lock-mask").show();
                                jQuery("#lock-screen-cont").show();
                            }
                            
                            jQuery("#lock-screen-cont").html(response);
                            
                            jQuery("#wpadminbar").slideUp("fast");
                            jQuery("html").addClass("lock-overflow");
                            jQuery("body").addClass("lock-overflow");
                        }
                        
                        lock_dashboard.html_classes = jQuery("html").attr("class");
                        jQuery("html").removeClass();
                    }
                    
                    lock_dashboard.handle_events();
                    lock_dashboard.lock_screen_date_time();
                    setTimeout(function(){
                        jQuery(".lockscreen-pin-container").find("input[type='password']").first().focus()
                    })
                    setTimeout(lock_dashboard.get_something, 2000);
                }
            }
        });
    }
    
    /**
     *@name lock
     *@description function to lock
     */
    lock_dashboard.lock = function(){
        lock_dashboard.idel_seconds = 0;
        localStorage.lock_user_active = 1;
        if(typeof lock_dashboard.locked != "undefined" && lock_dashboard.locked == true)
            return;
        jQuery.ajax({
            url: lock_dashboard.lock_admin_url+'admin-ajax.php?action=lock_me',
            type: 'post',
            data: lock_global_vars,
            success: function(response){
                lock_dashboard.close_auto_lock_msg();
                lock_dashboard.locked = true;
                lock_dashboard.direct_lock = false;
                
                if (typeof response.is_admin == "undefined" || response.is_admin == true) {
                    if ((lock_global_vars.is_admin)) {
                        if(jQuery("#lock-mask").length == 0){
                            jQuery("body").append("<div id='lock-mask'/>");
                            jQuery("body").append("<div id='lock-screen-cont'/>");
                        }
                        else{
                            jQuery("#lock-mask").show();
                            jQuery("#lock-screen-cont").show();
                        }
                        
                        jQuery("#lock-screen-cont").html(response);
                        
                        jQuery("#wpadminbar").slideUp("fast");
                        jQuery("html").addClass("lock-overflow");
                        jQuery("body").addClass("lock-overflow");
                    }
                    
                    lock_dashboard.html_classes = jQuery("html").attr("class");
                    jQuery("html").removeClass();
                }
                
                lock_dashboard.handle_events();
                lock_dashboard.lock_screen_date_time();
                setTimeout(function(){
                    jQuery(".lockscreen-pin-container").find("input[type='password']").first().focus()
                })
                setTimeout(lock_dashboard.get_something, 2000);
            }
        });
    }
    
    /**
     *@name unlock
     *@description function to unlock
     */
    lock_dashboard.unlock = function(cred){
        lock_dashboard.idel_seconds = 0;
        localStorage.lock_user_active = 1;
        if (typeof cred == "undefined") {
            //error
            return;
        }
        clearTimeout(lock_dashboard.check_timeout);
        if (typeof lock_dashboard.get_something_xhr == "object" && typeof lock_dashboard.get_something_xhr.abort == "function") {
            lock_dashboard.get_something_xhr.abort();
        }
        lock_dashboard.hide_error_noti();
        jQuery.ajax({
            url: lock_dashboard.lock_admin_url+'admin-ajax.php?action=unlock_me',
            type: 'post',
            data: cred,
            beforeSend: function(){
                lock_dashboard.show_signing_on();
            },
            success: function(response){
                if(response.success == true){
                    lock_dashboard.locked = false;
                    jQuery(".lock-loggin-in-cntr").hide();
                    jQuery(".lock-unlocking-cntr").show();
                    lock_dashboard.unlock_screen();
                }
                else if(cred.type == "pin"){
                    lock_dashboard.show_unlock_error();
                    jQuery(".lock-loggin-in-cntr").hide();
                    jQuery(".lockscreen-pin-container").show();
                    jQuery(".lockscreen-pin-container").find("input[type='password']").first().focus();
                    lock_dashboard.auto_hide_error();
                }
                else{
                    lock_dashboard.show_unlock_error("password");
                    jQuery(".lock-loggin-in-cntr").hide();
                    jQuery(".lock-passwd-container").show();
                    jQuery(".lock-passwd-container").find("input[type='password']").first().focus();
                    lock_dashboard.auto_hide_error();
                }
            }
        });
    }
    
    /**
     *@name unlock_screen
     *@description function to unlock the screen
     */
    lock_dashboard.unlock_screen = function(){
        if (typeof lock_dashboard.direct_lock != "undefined" && lock_dashboard.direct_lock && !lock_dashboard.locked) {
            window.location.reload();
        }
        else if(!lock_dashboard.locked){
            clearTimeout(lock_dashboard.check_timeout);
            jQuery("html").addClass(lock_dashboard.html_classes);
            jQuery("body").removeClass("lock-overflow");
            jQuery("html").removeClass("lock-overflow");
            jQuery("#lock-mask").fadeOut();
            jQuery("#lock-screen-cont").fadeOut();
            jQuery("#lock-screen-cont").html("");
            jQuery("#wpadminbar").slideDown("fast");
            lock_dashboard.destroy_vega_slider();
        }
    }
    
    /**
     *@name show_unlock_error
     *function will show error message
     */
    lock_dashboard.show_unlock_error = function(type){
        var message = (typeof type != "undefined" && type == "password") ? lock_global_vars.messages['password_incorrect_title'] : lock_global_vars.messages['pin_incorrect_title'];
        var _this = jQuery(".error-wrapper");
        if(typeof type != "undefined" && type == "password")
            jQuery(".lock-passwd-container").addClass("unlock-error")
        else
            jQuery(".lockscreen-pin-container").addClass("unlock-error")
            
        jQuery(".tip-head", _this).html(message);
        _this.css({
            opacity:'1',
            height: '70px'
        })
        _this.fadeIn();
        jQuery(".signin-options").slideDown();
    }
    
    /**
     *@name auto_hide_error
     *function will auto hide error message after 10 second
     */
    lock_dashboard.auto_hide_error = function(){
        if (typeof lock_dashboard.error_timeout != "undefined") {
            clearTimeout(lock_dashboard.error_timeout);
        }
        lock_dashboard.error_timeout = setTimeout(lock_dashboard.hide_error_noti, 10000)
    }
    
    /**
     *@name hide_error_noti
     *function will hide error notitification
     */
    lock_dashboard.hide_error_noti = function(){
        var _this = jQuery(".error-wrapper");
        _this.animate({
            opacity:'0' 
        }, 'slow', function(){
            _this.fadeOut();
            jQuery(".credential-inner").removeClass("unlock-error")
        });
    }
    
    /**
     *@name handle_events
     *@description function handle all events
     */
    lock_dashboard.handle_events = function(){
        var _btn_lock_old_ver = jQuery("#toplevel_page_wp-lock-button")
        var _btn_lock_new_ver = jQuery("#wp-admin-bar-wp-lock-button");
        if (_btn_lock_old_ver.length > 0) {
            _btn_lock_old_ver.unbind("click");
            _btn_lock_old_ver.click(function(e){
                e.preventDefault();
                lock_dashboard.lock();
            })
        }
        if (_btn_lock_new_ver.length > 0) {
            _btn_lock_new_ver.unbind("click");
            _btn_lock_new_ver.click(function( e ){
                e.preventDefault();
                lock_dashboard.lock();
            });
        }
        
        jQuery(document).unbind("keydown");
        jQuery(document).keydown(function(e) {
            if(e.which == 81 && e.ctrlKey && lock_global_vars.is_admin) {
                // ctrl+q pressed
                lock_dashboard.lock();
                e.preventDefault();
                if(e.stopPropagation){
                    e.stopPropagation();
                }
                else if (window.event) {
                    window.event.cancelBubble = true;
                }
            }
        });
        
        jQuery(window).unbind("focus");
        jQuery(window).focus(function() {
            clearTimeout(lock_dashboard.check_timeout);
            lock_dashboard.get_something();
        });
        
        lock_dashboard.handle_lock_screen_pin();
        lock_dashboard.handle_password_unlock();
        lock_dashboard.handle_signin_options();
        lock_dashboard.auto_hide_notifications();
        lock_dashboard.handle_show_tip();
        //lock_dashboard.handle_notifcations();
        lock_dashboard.handle_switch_user();
        lock_dashboard.start_vegas_slider();
    }
    
    /**
     *@name get_something
     *function will check locked state continously still will unlock screen is is_locked = false
     */
    lock_dashboard.get_something = function(){
        clearTimeout(lock_dashboard.check_timeout);
        if (typeof lock_dashboard.get_something_xhr == "object" && typeof lock_dashboard.get_something_xhr.abort == "function") {
            lock_dashboard.get_something_xhr.abort();
        }
        if (typeof localStorage.auto_lock_xhr == "object" && typeof localStorage.auto_lock_xhr.state == "function") {
            if(localStorage.auto_lock_xhr.state() == "pending"){
                lock_dashboard.check_timeout = setTimeout(lock_dashboard.get_something, 3000);
                return;
            }
        }
        lock_dashboard.get_something_xhr = jQuery.ajax({
            url: lock_dashboard.lock_admin_url+'admin-ajax.php?action=locked_get_something',
            type: 'post',
            data: lock_global_vars,
            success: function(response){
                if(typeof response.is_locked != "undefined"
                       && response.is_locked == true
                       && lock_dashboard.locked == true
                ){
                    if (jQuery(".count_published_pages").length > 0) {
                        jQuery(".count_published_pages").html(response.published_pages_count);
                    }
                    if (jQuery(".count_comments").length > 0) {
                        jQuery(".count_comments").html(response.comments_count);
                    }
                    if (jQuery(".count_in_moderation").length > 0) {
                        jQuery(".count_in_moderation").html(response.moderated);
                    }
                    
                    lock_dashboard.check_timeout = setTimeout(lock_dashboard.get_something, 3000);
                }
                else if (
                    typeof response.is_locked != "undefined"
                        && response.is_locked == true
                        && lock_global_vars.is_admin == true
                        && (typeof lock_dashboard.locked == "undefined" || lock_dashboard.locked == false)
                ) {
                    lock_dashboard.lock();
                }
                else if (lock_dashboard.locked && (typeof response.is_locked != "undefined"
                   && response.is_locked == false)) {
                    lock_dashboard.idel_seconds = 0;
                    localStorage.lock_user_active = 1;
                    lock_dashboard.locked = false;
                    lock_dashboard.unlock_screen();
                }
            }
        });
    }
    
    /**
     *@name handle_lock_screen_pin
     *function will enable auto focus for PIN lock screen
     */
    lock_dashboard.handle_lock_screen_pin = function(){
        var _selector = jQuery(".text_lock_pin")
        var _dq_nonce = (typeof(dq_nonce) != 'undefined') ? dq_nonce : ''
        if(_selector.length > 0){
            _selector.each(function(index, obje){

                if(typeof jQuery('.lockscreen-pin-container').on == 'function'){
                    jQuery('.lockscreen-pin-container').on('input', '.text_lock_pin', function(e){
                        jQuery(".credential-inner").removeClass("unlock-error")
                        if(jQuery(this).val().length > 0 && jQuery(this).next().length > 0){
                            jQuery(this).next().focus();
                        }
                        else if(jQuery(this).val().length > 0 && jQuery(this).next().length == 0 && (e.which != 8 && e.which != 46)){
                            e.preventDefault();
                        }
                    });
                }
                jQuery(this).unbind("keydown");
                jQuery(this).keydown(function(e){
                    jQuery(".credential-inner").removeClass("unlock-error")
                    if ((e.which == 8 || e.which == 46) && jQuery(this).val() == '') {
                        jQuery(this).prev('input').focus();
                    }
                    else if(jQuery(this).val().length > 0 && jQuery(this).next().length == 0 && (e.which != 8 && e.which != 46)){
                        e.preventDefault();
                    }
                });
                
                jQuery(this).unbind("keyup");
                jQuery(this).keyup(function(e){
                    if(jQuery(this).val().length > 0 && jQuery(this).next().length > 0){
                        jQuery(this).next().focus();
                    }
                    else{
                        var pin = "";
                        _selector.each(function(index, obje){
                            pin += jQuery(this).val();
                        });
                        
                        if(pin.trim().length == 4){
                            var cred = {};
                            cred = {
                                input_pin: pin.trim(),
                                dql_nonce: _dq_nonce,
                                type: 'pin'
                            }
                            lock_dashboard.unlock(cred);
                        }
                    }
                });
                jQuery(this).unbind("focus");
                jQuery(this).focus(function(e){
                    jQuery(this).val('');
                });
            });
        }
    }
    
    /**
     *@name handle_signin_options
     *function will allow user to switch sigin option
     */
    lock_dashboard.handle_signin_options = function(){
        var _parent = jQuery(".signin-options");
        if(_parent.length > 0 ){
            jQuery("a", _parent).each(function(){
                jQuery(this).unbind("click");
                jQuery(this).click(function(e){
                    jQuery("a", _parent).removeClass("selected");
                    jQuery(this).addClass("selected");
                    jQuery(".credential-inner").hide();
                    var _parent = jQuery(jQuery(this).attr("rel"))
                    var _pass_fields = _parent.find("input[type='password']")
                    _parent.show();
                    _pass_fields.first().focus();
                    _pass_fields.each(function(){
                        jQuery(this).val("");
                    })
                    lock_dashboard.hide_error_noti();
                });
            })
        }
    }
    
    /**
     *@name handle_password_unlock
     *function to trigger unlock with password
     */
    lock_dashboard.handle_password_unlock = function() {
        var _form_selector = jQuery("#unlock-with-password")
        var _passwd_text = jQuery("#text_lock_password")
        var _dq_nonce = (typeof(dq_nonce) != 'undefined') ? dq_nonce : ''
        _form_selector.unbind("submit");
        _form_selector.submit(function(e){
            e.preventDefault();
            if (_passwd_text.val().trim() == '') {
                jQuery(".lock-passwd-container").addClass("unlock-error");
            }
        });
        _passwd_text.unbind("keypress");
        _passwd_text.keypress(function(e){
            var keyCode = e.keyCode || e.which;
            jQuery(".lock-passwd-container").removeClass("unlock-error");
            if (keyCode == 13) {
                var cred = {};
                cred = {
                    input_passwd: jQuery(this).val(),
                    dql_nonce: _dq_nonce,
                    type: 'password'
                }
                lock_dashboard.unlock(cred);
            }
        });
        
    }
    
    /**
     *@name lock_dashboard.auto_hide_notifications
     *function auto hide all notifications one by one
     */
    lock_dashboard.auto_hide_notifications = function(){
        jQuery(".hints-wrapper").each(function(index){
            var delay = (index == 0) ? 15000 : (2000 * index) + 15000;
            var _this = jQuery(this)
            setTimeout(function(){
                _this.animate({
                    opacity:'0' 
                }, 'slow', function(){
                    _this.animate({
                        height: '0px',
                        'min-height': '0px',
                        'margin-top': '0px',
                        border: '0px'
                    }, 'slow', function(){
                        jQuery('.signin-options').fadeIn();
                        jQuery('.signin-options a').first().trigger('click')
                    });
                });
            }, delay);
        })
    }
    
    /**
     *@name auto_hide_tip
     *function will hide idea box after 5000ms
     */
    lock_dashboard.auto_hide_tip = function(){
        if (typeof lock_dashboard.tip_timeout != "undefined") {
            clearTimeout(lock_dashboard.tip_timeout);
        }
        setTimeout(function(){
            jQuery(".lock-tip-box .notification-panel").fadeIn("slow");
            jQuery(".lock-tip-box").animate({width:'100%'}, function(){
                jQuery(".lock-tip-box").css('height','auto');
            });
        },1000);
        lock_dashboard.tip_timeout = setTimeout(function(){
            jQuery(".notification-panel", _selector).fadeOut();
            var _selector = jQuery(".lock-tip-box");
            _selector.animate({width:'60px', height: '60px'});
            _selector.slideDown("fast")
        }, 5000);
    }
    
    /**
     *@name lock_dashboard.handle_show_tip
     *function will handle lock screen tip
     */
    lock_dashboard.handle_show_tip = function(){
        if(jQuery(".lock-tip-box").attr('rel') == 1)
            lock_dashboard.auto_hide_tip();

        jQuery(".lock-tip-box .tips-img").unbind("click")
        jQuery(".lock-tip-box .tips-img").click(function(e){
            if (jQuery(".lock-tip-box .notification-panel").css("display") == "none") {
                jQuery(".lock-tip-box").animate({width:'100%'}, function(){
                    jQuery(".lock-tip-box").css('height','auto');
                    jQuery(".lock-tip-box .notification-panel").fadeIn();
                });
            }
            else{
                jQuery(".lock-tip-box").animate({width:'60px', height: '60px'});
                jQuery(".lock-tip-box").slideDown("fast")
                jQuery(".lock-tip-box .notification-panel").hide();
                
            }
            
            if (typeof lock_dashboard.tip_timeout != "undefined") {
                clearTimeout(lock_dashboard.tip_timeout);
            }
        })
    }
    
    /**
     *@name lock_dashboard.handle_notifcations
     *function will display normal-notification to users
     */
    lock_dashboard.handle_notifcations = function(){
        jQuery(".normal-notifications ul li").each(function(index){
            index++;
            var delay = index * 1000;
            var _this = jQuery(this)
            setTimeout(function(){
                _this.slideDown();
            },delay)
        })
    }
    
    lock_dashboard.handle_switch_user = function(){
        var _selector = jQuery(".switch-user")
        _selector.unbind("hover")
        _selector.hover(function(){
            jQuery(".switch-wrapper-noti").fadeIn();
        }, function(){
            jQuery(".switch-wrapper-noti").hide();
        });
    }
    
    /**
     *@name show_signing_on
     *function will hide password and pin textboxes, then will show loggin in loader
     */
    lock_dashboard.show_signing_on = function(){
        jQuery(".credential-inner").hide();
        jQuery(".lock-loggin-in-cntr").show();
    }
    
    /**
     *@name start_vegas_slider
     *function will create background slider if there is morethan one image
     */
    lock_dashboard.start_vegas_slider = function(){
        lock_dashboard.destroy_vega_slider();
        if (typeof lock_dashboard.bgs == "object" && lock_dashboard.bgs.length > 0) {
            jQuery.vegas('slideshow', {
                backgrounds:lock_dashboard.bgs,
                walk:function(step) {
                    
                }
            })('overlay');
        }
    }
    
    /**
     *@name destroy_vega_slider
     *function will destroy vega slider
     */
    lock_dashboard.destroy_vega_slider = function(){
        if (typeof jQuery.vegas != "undefined") {
            jQuery.vegas('destroy');
        }
    }
    
    /**
     *@name init
     *init function
     */
    lock_dashboard.init = function(){
        
        lock_dashboard.check_idle_time();
        lock_dashboard.handle_settings_event();
        lock_dashboard.handle_events();
        lock_dashboard.lock_screen_date_time();
        if (jQuery(".text_lock_pin").length > 0) {
            jQuery(".text_lock_pin").first().focus();
        }
        
        if(typeof lock_dashboard.direct_lock && lock_dashboard.direct_lock){
            setTimeout(lock_dashboard.get_something, 2000)
        }
    }
    
    
    lock_dashboard.init();
})

