<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	$lock_admin = array(
		'lock_btn'				=> 'Lock Now (Ctr+q)',
		'settings_menu'			=> 'DQ Lock',
		'settings_title'		=> 'Dashboard Quick Lock Settings',
		'settings_description'	=> '',
		
		'security_pin_title'					=> 'PIN reset',
		'security_pin_enabled'					=> 'Dashboard lock enabled. Press Ctrl+q to lock.',
		'security_pin_defult_set'				=> 'Your default PIN is <b>defualt_pin</b>. Kindly reset your PIN.',
		'security_pin_btn_reset'				=> 'Reset PIN',
		'security_pin_wp_passwd_label'			=> 'Enter your Wordpress login password',
		'security_pin_wp_passwd_blank'			=> 'Please enter your wordpress login password.',
		'security_pin_wp_passwd_invalid'		=> 'Incorrect wordpress password.',
		'security_pin_new_pin_label'			=> 'Enter new PIN',
		'security_pin_confirm_new_pin_label'	=> 'Confirm new PIN',
		'security_pin_new_pin_blank'			=> 'Please enter 4 digit PIN.',
		'security_pin_new_pin_mismatch'			=> 'PIN mismatch.',
		'security_pin_new_pin_updated'			=> 'PIN update successful.',
		'security_pin_new_pin_previous'			=> 'You can\'t use your previous PIN.',
		'security_pin_error_wp_password'		=> 'Incorrect wordpress password. Please go back and enter your wordpress password.',
		'security_pin_error_occured'			=> 'Error occurred while updating security PIN.',


		'security_btn_submit'		=> 'Submit',
		'security_btn_cancel'		=> 'Cancel',
		'security_btn_save'			=> 'Save Changes',

		'autolock_title'			=> 'Auto Lock',
		'autolock_description'		=> 'Auto lock your dashboard when idle.',
		'autolock_disabled_label'	=> 'Auto Lock',
		'autolock_enabled_label'	=> 'Auto Lock after',
		'autolock_time_disabled'	=> 'Disabled',
		'autolock_time_singular'	=> 'Minute',
		'autolock_time_plural'		=> 'Minutes',
		'autolock_updated'			=> 'Auto lock update successful.',
		'autolock_updation_error'	=> 'Error occurred while updating auto lock settings',

		'appearance_title'							=> 'Lock Screen Appearance',
		'appearance_bg_image_title'					=> 'Background Image / Slideshow',
		'appearance_bg_image_description'			=> 'Personalize your lock screen by adding and selecting images of your choice. Select multiple images for slideshow.',
		'appearance_bg_image_from_library'			=> 'From Your Media',
		'appearance_bg_image_library_empty'			=> 'You\'r not added images to the DQ Lock',
		'appearance_bg_image_add_popup_title'		=> 'Choose Image (Recommended image minimum size 1000*600)',
		'appearance_bg_image_add_popup_button'		=> 'Choose Image',
		'appearance_bg_image_remove_title'			=> 'Confirm Removal',
		'appearance_bg_image_remove_message'		=> 'Are you sure you want to remove this item?',
		'appearance_bg_image_remove_cancel_btn'		=> 'Don\'t Remove',
		'appearance_bg_image_remove_confirm_btn'	=> 'Yes, I\'m Sure',

		'appearance_or'								=> 'OR',

		'appearance_bg_color_title'					=> 'Background Color',
		'appearance_bg_color_description'			=> 'Pick a solid color of your choice and keep the lock screen simple.',

		'appearance_bg_not_selected'				=> 'Please select atleast one image or color',
		'appearance_updated' 						=> 'Lock screen appearance update successful.',
		'appearance_updation_none_selected'			=> 'Please select atleast one image or color',
		'appearance_updation_error' 				=> 'Error occurred while updating appearance settings.',
		
		'notice_default_pin_title'					=> 'Dashboard Quick Lock',
		'notice_default_settings'					=> 'Settings',
		'notice_default_pin_descr1'					=> 'Your default PIN is <b>defualt_pin</b>. Kindly go to settings_link and reset the PIN.',
		'notice_default_pin_descr2'					=> 'You can lock your dashboard by pressing <strong>CTRL+Q</strong>'
	);

	$lock_screen_lang = array(
		'published_pages' 	=> 'Published Pages',
		'comments' 			=> 'Comments',
		'in_moderation'		=> 'in Moderation',
		'switch_user_title'	=> 'Switch User',
		'switch_user_desc'	=> 'You will be redirected to the Wordpress Login.',
		'authenticating'	=> 'Authenticating',
		'unlocking_dashboard'	=> 'Unlocking Dashboard',
		'signin_options'		=> 'Sign-in Options',
		'btn_password_title'	=> 'Unlock with wordpress password',
		'btn_pin_title'			=> 'Unlock with PIN',
		'password_placeholder'	=> 'Wordpress Password',
		'password_incorrect_title'	=> 'Incorrect Password',
		'password_incorrect_descr'	=> 'Please try again',
		'pin_incorrect_title'		=> 'Incorrect PIN',
		'password_incorrect_descr'	=> 'Please try again',
		'default_pin_title'			=> 'Your default security PIN is default_pin',
		'default_pin_desc'			=> 'Please go to settings and reset the PIN.',
	);

	$lock_tips = array(
		'title'	=> 'Did you Know?',
        'tips'	=> array(
        	'Pressing CTRL+Q will lock your screen.'
        )
    );
?>