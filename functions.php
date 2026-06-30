<?php
/**
 * Tema Viera Abogados - Archivo principal de configuración
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Versión del tema
 */
define( 'TEMA_VIERA_ABOGADOS_VERSION', '1.0.0' );
define( 'TEMA_VIERA_ABOGADOS_PATH', get_template_directory() );
define( 'TEMA_VIERA_ABOGADOS_URL', get_template_directory_uri() );

/**
 * Configuración inicial del tema
 */
function tema_viera_abogados_setup() {
	// Soporte para caracteres especiales en el blog
	load_theme_textdomain( 'tema-viera-abogados', TEMA_VIERA_ABOGADOS_PATH . '/languages' );

	// Agregar soporte para logo personalizado (Custom Logo)
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	// Agregar soporte para imagen destacada (featured image / thumbnail)
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 800, 600, true );

	// Agregar tamaños adicionales de thumbnail para diferentes usos
	add_image_size( 'abogado-card', 400, 300, true );
	add_image_size( 'abogado-single', 800, 600, true );
	add_image_size( 'section-banner', 1200, 400, true );

	// Agregar soporte para menús personalizados
	register_nav_menus( array(
		'primary-menu'   => esc_html__( 'Menú Principal', 'tema-viera-abogados' ),
		'footer-menu'    => esc_html__( 'Menú Footer', 'tema-viera-abogados' ),
	) );

	// Agregar soporte para HTML5 en formularios y search form
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Agregar soporte para feeds RSS automáticos
	add_theme_support( 'automatic-feed-links' );
}
add_action( 'after_setup_theme', 'tema_viera_abogados_setup' );

/**
 * Registrar estilos y scripts
 */
function tema_viera_abogados_enqueue_assets() {
	// Enqueue de estilos
	wp_enqueue_style(
		'tema-viera-abogados-style',
		TEMA_VIERA_ABOGADOS_URL . '/style.css',
		array(),
		TEMA_VIERA_ABOGADOS_VERSION
	);

	// Enqueue de scripts
	wp_enqueue_script(
		'tema-viera-abogados-main',
		TEMA_VIERA_ABOGADOS_URL . '/js/main.js',
		array(),
		TEMA_VIERA_ABOGADOS_VERSION,
		true
	);

	// Localizar variables JavaScript
	wp_localize_script( 'tema-viera-abogados-main', 'miTemaAbogados', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'tema-viera-abogados-nonce' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'tema_viera_abogados_enqueue_assets' );

/**
 * Desregistrar jQuery de la versión antigua
 * WordPress incluye jQuery, así que no es necesario agregarlo
 */
function tema_viera_abogados_remove_jquery() {
	if ( ! is_admin() ) {
		wp_dequeue_script( 'jquery' );
	}
}
add_action( 'wp_enqueue_scripts', 'tema_viera_abogados_remove_jquery', 1 );

/**
 * Incluir archivos del tema desde la carpeta /inc
 */
require_once TEMA_VIERA_ABOGADOS_PATH . '/inc/cpt-abogados.php';
require_once TEMA_VIERA_ABOGADOS_PATH . '/inc/metaboxes-abogados.php';
require_once TEMA_VIERA_ABOGADOS_PATH . '/inc/admin-opciones-landing.php';

/**
 * Configuración de ancho máximo del contenido
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

/**
 * Función auxiliar para obtener opción del tema con valor por defecto
 *
 * @param string $option Nombre de la opción
 * @param string $default Valor por defecto
 * @return mixed Valor de la opción
 */
function tema_viera_get_option( $option, $default = '' ) {
	return get_option( 'tema_viera_abogados_' . $option, $default );
}

/**
 * Función auxiliar para actualizar opción del tema
 *
 * @param string $option Nombre de la opción
 * @param mixed $value Valor a guardar
 * @return bool Resultado de la operación
 */
function tema_viera_update_option( $option, $value ) {
	return update_option( 'tema_viera_abogados_' . $option, $value );
}

/**
 * Función para obtener abogados ordenados por menu_order
 *
 * @return WP_Query
 */
function tema_viera_get_abogados( $posts_per_page = -1 ) {
	return new WP_Query( array(
		'post_type'      => 'abogado',
		'posts_per_page' => $posts_per_page,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	) );
}

/**
 * Función para obtener meta fields de un abogado
 *
 * @param int $post_id ID del post
 * @param string $field Nombre del campo (sin prefijo)
 * @return mixed Valor del meta field
 */
function tema_viera_get_abogado_meta( $post_id, $field ) {
	return get_post_meta( $post_id, '_abogado_' . $field, true );
}
