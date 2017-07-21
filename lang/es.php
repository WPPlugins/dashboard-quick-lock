<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	$lock_admin = array(
		'lock_btn'				=> 'Bloquear ahora (Ctr+q)',
		'settings_menu'			=> 'DQ Lock',
		'settings_title'		=> 'Dashboard Quick Lock Ajustes',
		'settings_description'	=> '',
		
		'security_pin_title'					=> 'restablecimiento PIN',
		'security_pin_enabled'					=> 'Bloqueo Dashboard habilitado. Presione Ctrl + q para bloquear.',
		'security_pin_defult_set'				=> 'El PIN por defecto es <b>defualt_pin</b>. Amablemente restablecer su PIN.',
		'security_pin_btn_reset'				=> 'Cambiar PIN',
		'security_pin_wp_passwd_label'			=> 'Introduzca su nombre de usuario contraseña Wordpress',
		'security_pin_wp_passwd_blank'			=> 'Por favor, introduzca su contraseña de inicio de sesión de WordPress.',
		'security_pin_wp_passwd_invalid'		=> 'Wordpress contraseña incorrecta.',
		'security_pin_new_pin_label'			=> 'Introduzca el nuevo PIN',
		'security_pin_confirm_new_pin_label'	=> 'Confirmar nuevo PIN',
		'security_pin_new_pin_blank'			=> 'Por favor introduce el PIN de 4 dígitos.',
		'security_pin_new_pin_mismatch'			=> 'Desajuste PIN.',
		'security_pin_new_pin_updated'			=> 'Actualización correcta PIN.',
		'security_pin_new_pin_previous'			=> 'Usted no puede usar el PIN anterior.',
		'security_pin_error_wp_password'		=> 'Wordpress contraseña incorrecta. Por favor, vuelve e introduzca su contraseña de wordpress.',
		'security_pin_error_occured'			=> 'Error al actualizar el PIN de seguridad.',


		'security_btn_submit'		=> 'Enviar',
		'security_btn_cancel'		=> 'Cancelar',
		'security_btn_save'			=> 'Guardar cambios',

		'autolock_title'			=> 'Bloqueo automático',
		'autolock_description'		=> 'Bloqueo automático su tablero de instrumentos cuando está inactivo.',
		'autolock_disabled_label'	=> 'Bloqueo automático',
		'autolock_enabled_label'	=> 'Bloqueo automático después',
		'autolock_time_disabled'	=> 'Disabled',
		'autolock_time_singular'	=> 'Minuto',
		'autolock_time_plural'		=> 'minutos',
		'autolock_updated'			=> 'Actualización de bloqueo automático éxito.',
		'autolock_updation_error'	=> 'Error al actualizar la configuración de bloqueo automático',

		'appearance_title'							=> 'Aspecto de la pantalla de bloqueo',
		'appearance_bg_image_title'					=> 'Imagen de fondo / Presentación',
		'appearance_bg_image_description'			=> 'Personaliza tu pantalla de bloqueo mediante la adición y la selección de las imágenes de su elección. Seleccione varias imágenes de diapositivas.',
		'appearance_bg_image_from_library'			=> 'Desde el medio',
		'appearance_bg_image_library_empty'			=> 'Usted no está agregado imágenes a la DQ Lock',
		'appearance_bg_image_add_popup_title'		=> 'Seleccione Imagen (Imagen recomendada mínimo 1000 * 600)',
		'appearance_bg_image_add_popup_button'		=> 'Seleccione Imagen',
		'appearance_bg_image_remove_title'			=> 'confirmar la eliminación',
		'appearance_bg_image_remove_message'		=> '¿Estás seguro de que quieres eliminar este elemento?',
		'appearance_bg_image_remove_cancel_btn'		=> 'No eliminar',
		'appearance_bg_image_remove_confirm_btn'	=> 'Sí, estoy seguro',

		'appearance_or'								=> 'O',

		'appearance_bg_color_title'					=> 'color de fondo',
		'appearance_bg_color_description'			=> 'Elija un color sólido de su elección y mantener la sencilla pantalla de bloqueo.',

		'appearance_bg_not_selected'				=> 'Por favor, seleccione al menos una imagen o color',
		'appearance_updated' 						=> 'Actualización de aspecto de la pantalla de bloqueo con éxito.',
		'appearance_updation_none_selected'			=> 'Por favor, seleccione al menos una imagen o color',
		'appearance_updation_error' 				=> 'Error al actualizar la configuración de aspecto.',
		
		'notice_default_pin_title'					=> 'Dashboard Quick Lock',
		'notice_default_settings'					=> 'Ajustes',
		'notice_default_pin_descr1'					=> 'El PIN por defecto es defualt_pin. Favor ir al settings_link y restablecer el PIN.',
		'notice_default_pin_descr2'					=> 'Puede bloquear el panel de control pulsando <strong> CTRL + Q </ strong>'
	);

	$lock_screen_lang = array(
		'published_pages' 	=> 'Páginas Publicado',
		'comments' 			=> 'Comentarios',
		'in_moderation'		=> 'con Moderación',
		'switch_user_title'	=> 'Cambiar de usuario',
		'switch_user_desc'	=> 'Usted será redirigido a la Wordpress Login.',
		'authenticating'	=> 'Autenticación',
		'unlocking_dashboard'	=> 'Dashboard desbloqueo',
		'signin_options'		=> 'Regístrese Opciones',
		'btn_password_title'	=> 'Desbloquear con contraseña wordpress',
		'btn_pin_title'			=> 'Desbloquear con PIN',
		'password_placeholder'	=> 'Contraseña Wordpress',
		'password_incorrect_title'	=> 'Contraseña incorrecta',
		'password_incorrect_descr'	=> 'Por favor, inténtalo de nuevo',
		'pin_incorrect_title'		=> 'PIN incorrecta',
		'password_incorrect_descr'	=> 'Por favor, inténtalo de nuevo',
		'default_pin_title'			=> 'Su PIN de seguridad por defecto es default_pin',
		'default_pin_desc'			=> 'Por favor, vaya a la configuración y reiniciar el PIN.',
	);

	$lock_tips = array(
		'title'	=> 'Sabías?',
        'tips'	=> array(
        	'Al presionar CTRL + Q se bloqueará la pantalla.'
        )
    );
?>
