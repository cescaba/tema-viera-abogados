<?php
/**
 * Custom Post Type - Abogados
 *
 * Define el Custom Post Type "abogado" para gestionar los miembros del estudio
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registrar el Custom Post Type "abogado"
 */
function tema_viera_register_cpt_abogados() {
	$labels = array(
		'name'               => esc_html_x( 'Abogados', 'post type general name', 'tema-viera-abogados' ),
		'singular_name'      => esc_html_x( 'Abogado', 'post type singular name', 'tema-viera-abogados' ),
		'menu_name'          => esc_html_x( 'Abogados', 'admin menu', 'tema-viera-abogados' ),
		'name_admin_bar'     => esc_html_x( 'Abogado', 'add new on admin bar', 'tema-viera-abogados' ),
		'add_new'            => esc_html__( 'Agregar Nuevo', 'tema-viera-abogados' ),
		'add_new_item'       => esc_html__( 'Agregar Nuevo Abogado', 'tema-viera-abogados' ),
		'new_item'           => esc_html__( 'Nuevo Abogado', 'tema-viera-abogados' ),
		'edit_item'          => esc_html__( 'Editar Abogado', 'tema-viera-abogados' ),
		'view_item'          => esc_html__( 'Ver Abogado', 'tema-viera-abogados' ),
		'all_items'          => esc_html__( 'Todos los Abogados', 'tema-viera-abogados' ),
		'search_items'       => esc_html__( 'Buscar Abogados', 'tema-viera-abogados' ),
		'parent_item_colon'  => esc_html__( 'Padre Abogado:', 'tema-viera-abogados' ),
		'not_found'          => esc_html__( 'No se encontraron abogados.', 'tema-viera-abogados' ),
		'not_found_in_trash' => esc_html__( 'No se encontraron abogados en la papelera.', 'tema-viera-abogados' ),
	);

	$args = array(
		'labels'             => $labels,
		'description'        => esc_html__( 'Custom Post Type para gestionar abogados del estudio', 'tema-viera-abogados' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-businessman',
		'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
		'show_in_rest'       => true, // Permite usar el editor Gutenberg
		'rest_base'          => 'abogados',
		'rewrite'            => array(
			'slug'       => 'abogados',
			'with_front' => false,
		),
	);

	register_post_type( 'abogado', $args );
}
add_action( 'init', 'tema_viera_register_cpt_abogados' );

/**
 * Flush rewrite rules cuando se activa el tema
 * Esto es importante para que las URLs del CPT funcionen correctamente
 */
function tema_viera_flush_rewrite_rules() {
	tema_viera_register_cpt_abogados();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'tema_viera_flush_rewrite_rules' );
