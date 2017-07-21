<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	$lock_admin = array(
		'lock_btn'				=> 'Kunci Sekarang (Ctr + q)',
		'settings_menu'			=> 'DQ Lock',
		'settings_title'		=> 'Dashboard Quick Lock pengaturan',
		'settings_description'	=> '',
		
		'security_pin_title'					=> 'PIN ulang',
		'security_pin_enabled'					=> 'Kunci Dashboard diaktifkan. Tekan Ctrl + q untuk mengunci.',
		'security_pin_defult_set'				=> 'PIN default Anda adalah <b> defualt_pin </ b>. Mohon ulang PIN Anda.',
		'security_pin_btn_reset'				=> 'Atur ulang PIN',
		'security_pin_wp_passwd_label'			=> 'Masukkan password login Wordpress Anda',
		'security_pin_wp_passwd_blank'			=> 'Masukkan sandi wordpress login Anda.',
		'security_pin_wp_passwd_invalid'		=> 'Salah sandi wordpress.',
		'security_pin_new_pin_label'			=> 'Masukkan PIN baru',
		'security_pin_confirm_new_pin_label'	=> 'Konfirmasi PIN baru',
		'security_pin_new_pin_blank'			=> 'Masukkan 4 digit PIN.',
		'security_pin_new_pin_mismatch'			=> 'PIN mismatch.',
		'security_pin_new_pin_updated'			=> 'Update PIN sukses.',
		'security_pin_new_pin_previous'			=> 'Anda tidak dapat menggunakan PIN Anda sebelumnya.',
		'security_pin_error_wp_password'		=> 'Salah sandi wordpress. Harap kembali dan masukkan password wordpress Anda.',
		'security_pin_error_occured'			=> 'Kesalahan terjadi saat memperbarui PIN keamanan.',


		'security_btn_submit'		=> 'Kirim',
		'security_btn_cancel'		=> 'Batal',
		'security_btn_save'			=> 'Simpan Perubahan',

		'autolock_title'			=> 'Auto Lock',
		'autolock_description'		=> 'Auto mengunci dashboard Anda saat idle.',
		'autolock_disabled_label'	=> 'Auto Lock',
		'autolock_enabled_label'	=> 'Auto Lock setelah',
		'autolock_time_disabled'	=> 'dinonaktifkan',
		'autolock_time_singular'	=> 'menit',
		'autolock_time_plural'		=> 'menit',
		'autolock_updated'			=> 'Update Auto lock sukses.',
		'autolock_updation_error'	=> 'Kesalahan terjadi saat memperbarui pengaturan kunci otomatis',

		'appearance_title'							=> 'Kunci Penampilan Layar',
		'appearance_bg_image_title'					=> 'Background Image / Slideshow',
		'appearance_bg_image_description'			=> 'Personalisasi layar kunci Anda dengan menambahkan dan memilih gambar pilihan Anda. Pilih beberapa gambar untuk slideshow.',
		'appearance_bg_image_from_library'			=> 'Dari Media Anda',
		'appearance_bg_image_library_empty'			=> 'Anda tidak menambahkan gambar ke DQ Lock',
		'appearance_bg_image_add_popup_title'		=> 'Pilih Gambar (Direkomendasikan gambar ukuran minimum 1000 * 600)',
		'appearance_bg_image_add_popup_button'		=> 'Pilih Gambar',
		'appearance_bg_image_remove_title'			=> 'konfirmasi Penghapusan',
		'appearance_bg_image_remove_message'		=> 'Apakah Anda yakin ingin menghapus item ini?',
		'appearance_bg_image_remove_cancel_btn'		=> 'Jangan Hapus',
		'appearance_bg_image_remove_confirm_btn'	=> 'Ya aku pasti',

		'appearance_or'								=> 'OR',

		'appearance_bg_color_title'					=> 'Background Color',
		'appearance_bg_color_description'			=> 'Pilih warna solid pilihan Anda dan menjaga layar kunci sederhana.',

		'appearance_bg_not_selected'				=> 'Silakan pilih minimal satu gambar atau warna',
		'appearance_updated' 						=> 'Update tampilan layar kunci sukses.',
		'appearance_updation_none_selected'			=> 'Silakan pilih minimal satu gambar atau warna',
		'appearance_updation_error' 				=> 'Kesalahan terjadi saat memperbarui pengaturan tampilan.',
		
		'notice_default_pin_title'					=> 'Dashboard Quick Lock',
		'notice_default_settings'					=> 'pengaturan',
		'notice_default_pin_descr1'					=> 'PIN standar Anda defualt_pin. Mohon pergi ke settings_link dan ulang PIN.',
		'notice_default_pin_descr2'					=> 'Anda dapat mengunci dashboard Anda dengan menekan <strong> CTRL + Q </ strong>'
	);

	$lock_screen_lang = array(
		'published_pages' 	=> 'Diterbitkan Pages',
		'comments' 			=> 'komentar',
		'in_moderation'		=> 'di Moderasi',
		'switch_user_title'	=> 'Switch User',
		'switch_user_desc'	=> 'Anda akan diarahkan ke Wordpress Login.',
		'authenticating'	=> 'otentikasi',
		'unlocking_dashboard'	=> 'Dashboard unlocking',
		'signin_options'		=> 'Sign-in Options',
		'btn_password_title'	=> 'Aktifkan dengan password wordpress',
		'btn_pin_title'			=> 'Aktifkan dengan PIN',
		'password_placeholder'	=> 'Sandi Wordpress',
		'password_incorrect_title'	=> 'Sandi salah',
		'password_incorrect_descr'	=> 'Silakan coba lagi',
		'pin_incorrect_title'		=> 'PIN salah',
		'password_incorrect_descr'	=> 'Silakan coba lagi',
		'default_pin_title'			=> 'Anda PIN keamanan default default_pin',
		'default_pin_desc'			=> 'Silakan pergi ke pengaturan dan ulang PIN.',
	);

	$lock_tips = array(
		'title'	=> 'Apakah Anda Tahu?',
        'tips'	=> array(
        	'Menekan CTRL + Q akan mengunci layar Anda.'
        )
    );
?>