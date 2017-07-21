<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	$lock_admin = array(
		'lock_btn'				=> 'bloquear Agora (Ctr+q)',
		'settings_menu'			=> 'DQ Lock',
		'settings_title'		=> 'Dashboard Quick Lock configurações',
		'settings_description'	=> '',
		
		'security_pin_title'					=> 'redefinição de PIN',
		'security_pin_enabled'					=> 'Bloqueio Painel habilitado. Pressione Ctrl + q para bloquear.',
		'security_pin_defult_set'				=> 'O PIN padrão é <b> defualt_pin </ b>. Por favor, redefinir seu PIN.',
		'security_pin_btn_reset'				=> 'Redefinir PIN',
		'security_pin_wp_passwd_label'			=> 'Digite sua senha de login Wordpress',
		'security_pin_wp_passwd_blank'			=> 'Por favor, digite a sua senha wordpress login.',
		'security_pin_wp_passwd_invalid'		=> 'Wordpress senha incorreta.',
		'security_pin_new_pin_label'			=> 'Digite o novo PIN',
		'security_pin_confirm_new_pin_label'	=> 'Confirmar novo PIN',
		'security_pin_new_pin_blank'			=> 'Por favor, indique 4 PIN dígitos.',
		'security_pin_new_pin_mismatch'			=> 'Descasamento PIN.',
		'security_pin_new_pin_updated'			=> 'Actualização PIN bem sucedida.',
		'security_pin_new_pin_previous'			=> 'Você não pode usar o seu PIN anterior.',
		'security_pin_error_wp_password'		=> 'Wordpress senha incorreta. Por favor, volte e digite sua senha wordpress.',
		'security_pin_error_occured'			=> 'Ocorreu um erro durante a atualização PIN de segurança.',


		'security_btn_submit'		=> 'Enviar',
		'security_btn_cancel'		=> 'cancelar',
		'security_btn_save'			=> 'Salvar alterações',

		'autolock_title'			=> 'Bloqueio Automático',
		'autolock_description'		=> 'Auto bloquear o painel de instrumentos quando ocioso.',
		'autolock_disabled_label'	=> 'Bloqueio Automático',
		'autolock_enabled_label'	=> 'Bloqueio automático após',
		'autolock_time_disabled'	=> 'desativado',
		'autolock_time_singular'	=> 'minuto',
		'autolock_time_plural'		=> 'minutos',
		'autolock_updated'			=> 'Atualização bloqueio automático de sucesso.',
		'autolock_updation_error'	=> 'Ocorreu um erro ao atualizar as configurações de bloqueio automático',

		'appearance_title'							=> 'Bloqueio aparência da tela',
		'appearance_bg_image_title'					=> 'Imagem de Fundo / Slideshow',
		'appearance_bg_image_description'			=> 'Personalize sua tela de bloqueio, adicionando e selecionando imagens de sua escolha. Selecione várias imagens para slideshow.',
		'appearance_bg_image_from_library'			=> 'A partir da mídia',
		'appearance_bg_image_library_empty'			=> 'Você não adicionou imagens para o DQ Lock',
		'appearance_bg_image_add_popup_title'		=> 'Escolha Imagem (imagem Recomendado tamanho mínimo de 1000 * 600)',
		'appearance_bg_image_add_popup_button'		=> 'Escolha Imagem',
		'appearance_bg_image_remove_title'			=> 'confirmar Remoção',
		'appearance_bg_image_remove_message'		=> 'Tem certeza de que deseja remover este item?',
		'appearance_bg_image_remove_cancel_btn'		=> 'Não Remover',
		'appearance_bg_image_remove_confirm_btn'	=> 'Sim, eu sou certo',

		'appearance_or'								=> 'OR',

		'appearance_bg_color_title'					=> 'Cor de fundo',
		'appearance_bg_color_description'			=> 'Escolha uma cor sólida de sua preferência e manter a tela de bloqueio simples.',

		'appearance_bg_not_selected'				=> 'Por favor, selecione pelo menos uma imagem ou cor',
		'appearance_updated' 						=> 'Atualização a aparência da tela de bloqueio bem sucedido.',
		'appearance_updation_none_selected'			=> 'Por favor, selecione pelo menos uma imagem ou cor',
		'appearance_updation_error' 				=> 'Ocorreu um erro ao atualizar as configurações de aparência.',
		
		'notice_default_pin_title'					=> 'Dashboard Quick Lock',
		'notice_default_settings'					=> 'configurações',
		'notice_default_pin_descr1'					=> 'O PIN padrão é defualt_pin. Por favor, vá para settings_link e redefinir o PIN.',
		'notice_default_pin_descr2'					=> 'É possível bloquear o painel pressionando <strong> CTRL + Q </ strong>'
	);

	$lock_screen_lang = array(
		'published_pages' 	=> 'páginas publicadas',
		'comments' 			=> 'comentários',
		'in_moderation'		=> 'com Moderação',
		'switch_user_title'	=> 'Trocar usuário',
		'switch_user_desc'	=> 'Você será redirecionado para o Wordpress em Login.',
		'authenticating'	=> 'Autenticação',
		'unlocking_dashboard'	=> 'Painel desbloqueio',
		'signin_options'		=> 'Cadastre-se Opções',
		'btn_password_title'	=> 'Desbloquear com senha wordpress',
		'btn_pin_title'			=> 'Desbloquear com PIN',
		'password_placeholder'	=> 'Wordpress senha',
		'password_incorrect_title'	=> 'Senha incorreta',
		'password_incorrect_descr'	=> 'Por favor, tente novamente',
		'pin_incorrect_title'		=> 'PIN incorreto',
		'password_incorrect_descr'	=> 'Por favor, tente novamente',
		'default_pin_title'			=> 'O seu PIN de segurança padrão é default_pin',
		'default_pin_desc'			=> 'Por favor, vá para as configurações e redefinir o PIN.',
	);

	$lock_tips = array(
		'title'	=> 'Você sabia?',
        'tips'	=> array(
        	'Pressionando CTRL + Q irá bloquear o ecrã.'
        )
    );
?>
