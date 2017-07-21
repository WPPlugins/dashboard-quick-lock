<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	$lock_admin = array(
		'lock_btn'				=> 'Verrou immédiat (Ctr + q)',
		'settings_menu'			=> 'DQ Lock',
		'settings_title'		=> 'Dashboard Quick Lock paramètres',
		'settings_description'	=> '',
		
		'security_pin_title'					=> 'PIN réinitialisation',
		'security_pin_enabled'					=> 'Verrouillage du tableau de bord activé. Appuyez sur Ctrl + q pour le verrouiller.',
		'security_pin_defult_set'				=> 'Votre code PIN par défaut est <b> defualt_pin </ b>. Veuillez réinitialiser votre NIP.',
		'security_pin_btn_reset'				=> 'réinitialiser PIN',
		'security_pin_wp_passwd_label'			=> 'Entrez votre mot de passe Wordpress',
		'security_pin_wp_passwd_blank'			=> 'S\'il vous plaît entrer votre mot de passe de connexion wordpress.',
		'security_pin_wp_passwd_invalid'		=> 'Mauvaise passe wordpress.',
		'security_pin_new_pin_label'			=> 'Entrez un nouveau code PIN',
		'security_pin_confirm_new_pin_label'	=> 'Confirmer le nouveau code PIN',
		'security_pin_new_pin_blank'			=> 'S\'il vous plaît entrez 4 chiffres PIN.',
		'security_pin_new_pin_mismatch'			=> 'PIN ne correspondent pas.',
		'security_pin_new_pin_updated'			=> 'Mise à jour réussie PIN.',
		'security_pin_new_pin_previous'			=> 'Vous ne pouvez pas utiliser votre code PIN précédente.',
		'security_pin_error_wp_password'		=> 'Mauvaise passe wordpress. S\'il vous plaît revenir en arrière et entrez votre mot de passe wordpress.',
		'security_pin_error_occured'			=> 'Une erreur s\'est produite lors de l\'actualisation code PIN de sécurité.',


		'security_btn_submit'		=> 'soumettre',
		'security_btn_cancel'		=> 'annuler',
		'security_btn_save'			=> 'Enregistrer les modifications',

		'autolock_title'			=> 'Auto Lock',
		'autolock_description'		=> 'Verrouillage automatique de votre tableau de bord en cas d\'inactivité.',
		'autolock_disabled_label'	=> 'Auto Lock',
		'autolock_enabled_label'	=> 'Verrouillage automatique après',
		'autolock_time_disabled'	=> 'handicapés',
		'autolock_time_singular'	=> 'minute',
		'autolock_time_plural'		=> 'procès-verbal',
		'autolock_updated'			=> 'Mise à jour de blocage automatique réussie.',
		'autolock_updation_error'	=> 'Erreur lors de la mise à jour des paramètres de verrouillage de l\'automobile',

		'appearance_title'							=> 'Verrouillage Personnalisation de l\'écran',
		'appearance_bg_image_title'					=> 'Image de fond / Diaporama',
		'appearance_bg_image_description'			=> 'Personnalisez votre écran de verrouillage en ajoutant et en sélectionnant les images de votre choix. Sélectionnez plusieurs images pour un diaporama.',
		'appearance_bg_image_from_library'			=> 'Partir de votre média',
		'appearance_bg_image_library_empty'			=> 'Vous n\'êtes pas ajouté des images à l\' DQ Lock',
		'appearance_bg_image_add_popup_title'		=> 'Choisissez Image (Image Recommandé taille minimum 1000 * 600)',
		'appearance_bg_image_add_popup_button'		=> 'Choisissez Image',
		'appearance_bg_image_remove_title'			=> 'Confirmation de la suppression',
		'appearance_bg_image_remove_message'		=> 'Êtes-vous sûr de vouloir supprimer cet article?',
		'appearance_bg_image_remove_cancel_btn'		=> 'Ne pas supprimer',
		'appearance_bg_image_remove_confirm_btn'	=> 'Oui, je suis sûr',

		'appearance_or'								=> 'OU',

		'appearance_bg_color_title'					=> 'Couleur de fond',
		'appearance_bg_color_description'			=> 'Choisissez une couleur unie de votre choix et de préserver la simplicité de l\'écran de verrouillage.',

		'appearance_bg_not_selected'				=> 'S\'il vous plaît sélectionner au moins une image ou couleur',
		'appearance_updated' 						=> 'Verrouiller l\'écran mise à jour réussie de l\'apparence.',
		'appearance_updation_none_selected'			=> 'S\'il vous plaît sélectionner au moins une image ou couleur',
		'appearance_updation_error' 				=> 'Erreur lors de la mise à jour les paramètres d\'apparence.',
		
		'notice_default_pin_title'					=> 'Dashboard Quick Lock',
		'notice_default_settings'					=> 'paramètres',
		'notice_default_pin_descr1'					=> 'Votre code PIN par défaut est defualt_pin. Veuillez vous rendre à settings_link et réinitialiser le code PIN.',
		'notice_default_pin_descr2'					=> 'Vous pouvez verrouiller votre tableau de bord en appuyant sur <strong> CTRL + Q </ strong>'
	);

	$lock_screen_lang = array(
		'published_pages' 	=> 'Pages publiés',
		'comments' 			=> 'commentaires',
		'in_moderation'		=> 'avec modération',
		'switch_user_title'	=> 'Changer d\'utilisateur',
		'switch_user_desc'	=> 'Vous serez redirigé vers le Wordpress Connexion.',
		'authenticating'	=> 'authentification',
		'unlocking_dashboard'	=> 'déverrouillage',
		'signin_options'		=> 'Identifiez-options',
		'btn_password_title'	=> 'Déverrouillez avec mot de passe wordpress',
		'btn_pin_title'			=> 'Déverrouiller avec le code PIN',
		'password_placeholder'	=> 'Wordpress Mot de passe',
		'password_incorrect_title'	=> 'Mot de passe incorrect',
		'password_incorrect_descr'	=> 'S\'il vous plaît essayer de nouveau',
		'pin_incorrect_title'		=> 'PIN erroné',
		'password_incorrect_descr'	=> 'S\'il vous plaît essayer de nouveau',
		'default_pin_title'			=> 'Votre code PIN de sécurité par défaut est default_pin',
		'default_pin_desc'			=> 'S\'il vous plaît aller dans les paramètres et réinitialiser le code PIN.',
	);

	$lock_tips = array(
		'title'	=> 'Saviez-vous?',
        'tips'	=> array(
        	'Appuyant sur CTRL + Q verrouiller votre écran.'
        )
    );
?>
