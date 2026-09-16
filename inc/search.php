<?php
/**
 * Búsqueda viva del panel del navbar
 *
 * Expone el endpoint AJAX `tema_viera_search` que devuelve resultados
 * agrupados (Servicios / Blog / Equipo) para el overlay de búsqueda.
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Búsquedas populares del diseño (pills bajo el input).
 *
 * @return array
 */
function tema_viera_search_popular() {
	return array(
		'Litigios Civiles',
		'Litigios Penales',
		'Equipo legal',
		'Agenda una reunión',
	);
}

/**
 * Normaliza un texto para comparación insensible a tildes/mayúsculas.
 *
 * @param string $text Texto.
 * @return string
 */
function tema_viera_search_normalize( $text ) {
	$text = (string) $text;
	if ( function_exists( 'remove_accents' ) ) {
		$text = remove_accents( $text );
	}
	return function_exists( 'mb_strtolower' ) ? mb_strtolower( $text, 'UTF-8' ) : strtolower( $text );
}

/**
 * ¿El término aparece en el texto (insensible a tildes)?
 *
 * @param string $needle Búsqueda.
 * @param string $haystack Texto.
 * @return bool
 */
function tema_viera_search_match( $needle, $haystack ) {
	$needle   = tema_viera_search_normalize( $needle );
	$haystack = tema_viera_search_normalize( $haystack );
	if ( '' === $needle ) {
		return false;
	}
	return false !== strpos( $haystack, $needle );
}

/**
 * Traduce al idioma pedido en AJAX (pll__ usa el idioma de la petición
 * /wp-admin/, no el del frontend; pll_translate_string sí permite forzarlo).
 *
 * @param string $text Texto fuente (español).
 * @param string $lang Slug destino ('es' | 'en').
 * @return string
 */
function tema_viera_search_t( $text, $lang ) {
	if ( ! is_string( $text ) || '' === $text ) {
		return $text;
	}
	if ( $lang && function_exists( 'pll_translate_string' ) ) {
		$tr = pll_translate_string( $text, $lang );
		if ( is_string( $tr ) && '' !== $tr ) {
			return $tr;
		}
	}
	return function_exists( 'tema_viera_t' ) ? tema_viera_t( $text ) : $text;
}

/**
 * Endpoint AJAX: búsqueda viva.
 */
function tema_viera_search_ajax() {
	check_ajax_referer( 'tema-viera-abogados-nonce', 'nonce' );

	$q = isset( $_POST['q'] ) ? sanitize_text_field( wp_unslash( $_POST['q'] ) ) : '';
	$q = trim( $q );

	if ( mb_strlen( $q ) < 2 ) {
		wp_send_json_success( array(
			'query'  => $q,
			'total'  => 0,
			'groups' => array(),
		) );
	}

	$lang = function_exists( 'tema_viera_current_lang' ) ? tema_viera_current_lang() : 'es';
	$groups = array();

	// --- SERVICIOS (opciones de la landing, sin URL propia → ancla #servicios). ---
	$servicios_items = get_option( 'tema_viera_abogados_servicios_items', array() );
	$servicios_hits  = array();
	if ( is_array( $servicios_items ) ) {
		$servicios_url = function_exists( 'tema_viera_anchor_url' )
			? tema_viera_anchor_url( 'servicios' )
			: home_url( '/#servicios' );
		foreach ( $servicios_items as $servicio ) {
			$raw_titulo = $servicio['titulo'] ?? '';
			$raw_desc   = $servicio['descripcion'] ?? '';
			$titulo = tema_viera_search_t( $raw_titulo, $lang );
			$desc   = tema_viera_search_t( $raw_desc, $lang );
			if ( '' === trim( $titulo ) ) {
				continue;
			}
			if ( tema_viera_search_match( $q, $titulo . ' ' . $desc ) ) {
				$servicios_hits[] = array(
					'title'    => $titulo,
					'subtitle' => 'Servicios — ' . wp_trim_words( wp_strip_all_tags( $desc ), 10, '…' ),
					'url'      => $servicios_url,
				);
				if ( count( $servicios_hits ) >= 3 ) {
					break;
				}
			}
		}
	}
	if ( ! empty( $servicios_hits ) ) {
		$groups[] = array(
			'key'   => 'servicios',
			'label' => 'SERVICIOS',
			'count' => count( $servicios_hits ),
			'items' => $servicios_hits,
		);
	}

	// --- BLOG / NOTICIAS (post → single.php). Post de idioma único:
	// WP 's' solo busca en español (fuente DB), así que se combina con
	// match manual sobre cadenas traducidas para que el inglés funcione. ---
	$blog_posts_by_id = array();
	$blog_query = new WP_Query( array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		's'              => $q,
		'posts_per_page' => 4,
		'no_found_rows'  => true,
	) );
	if ( $blog_query->have_posts() ) {
		foreach ( $blog_query->posts as $p ) {
			$blog_posts_by_id[ (int) $p->ID ] = $p;
		}
		wp_reset_postdata();
	}
	// Complemento por traducción (cubre EN y evita depender solo del 's').
	if ( count( $blog_posts_by_id ) < 4 ) {
		$extra = get_posts( array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 30,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'suppress_filters' => false,
		) );
		foreach ( $extra as $p ) {
			$id = (int) $p->ID;
			if ( isset( $blog_posts_by_id[ $id ] ) ) {
				continue;
			}
			$t_raw = get_the_title( $id );
			$d_raw = get_post_meta( $id, '_post_descripcion', true );
			$t_tr  = tema_viera_search_t( $t_raw, $lang );
			$d_tr  = is_string( $d_raw ) ? tema_viera_search_t( $d_raw, $lang ) : '';
			if ( tema_viera_search_match( $q, $t_tr . ' ' . $d_tr . ' ' . $t_raw . ' ' . $d_raw ) ) {
				$blog_posts_by_id[ $id ] = $p;
				if ( count( $blog_posts_by_id ) >= 4 ) {
					break;
				}
			}
		}
	}
	$blog_hits = array();
	$seen_blog = array();
	foreach ( $blog_posts_by_id as $id => $p ) {
		$id = (int) $id;
		if ( isset( $seen_blog[ $id ] ) ) {
			continue;
		}
		$seen_blog[ $id ] = true;
		$titulo  = tema_viera_search_t( get_the_title( $id ), $lang );
		$enlace  = function_exists( 'tema_viera_post_permalink' ) ? tema_viera_post_permalink( $id ) : get_permalink( $id );
		$fecha   = function_exists( 'tema_viera_blog_fecha' ) ? tema_viera_blog_fecha( $id, 'corto' ) : get_the_date( '', $id );
		$blog_hits[] = array(
			'title'    => $titulo,
			'subtitle' => 'Blog · ' . $fecha,
			'url'      => $enlace,
		);
	}
	if ( ! empty( $blog_hits ) ) {
		$groups[] = array(
			'key'   => 'blog',
			'label' => 'BLOG',
			'count' => count( $blog_hits ),
			'items' => $blog_hits,
		);
	}

	// --- EQUIPO (CPT traducible por Polylang: filtrar por idioma + dedupe,
	// sin single público → todo dirige a /equipo/). ---
	$abogados_hits = array();
	$seen_nombres  = array();
	$equipo_url    = function_exists( 'tema_viera_equipo_url' ) ? tema_viera_equipo_url() : home_url( '/equipo/' );
	$query_args    = array(
		'post_type'      => 'abogado',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'suppress_filters' => false,
	);
	if ( function_exists( 'pll_get_post_language' ) || $lang ) {
		$query_args['lang'] = $lang;
	}
	$abogados_all = get_posts( $query_args );
	foreach ( $abogados_all as $ab ) {
		$id = (int) $ab->ID;
		// Solo el idioma actual: evita el duplicado ES + EN.
		if ( function_exists( 'pll_get_post_language' ) ) {
			$post_lang = pll_get_post_language( $id );
			if ( $post_lang && $post_lang !== $lang ) {
				continue;
			}
		}
		$raw_nombre = get_the_title( $id );
		$raw_cargo  = get_post_meta( $id, '_abogado_cargo', true );
		$raw_espec  = get_post_meta( $id, '_abogado_especialidad', true );
		$nombre = tema_viera_search_t( $raw_nombre, $lang );
		$cargo  = is_string( $raw_cargo ) ? tema_viera_search_t( $raw_cargo, $lang ) : '';
		$espec  = is_string( $raw_espec ) ? tema_viera_search_t( $raw_espec, $lang ) : '';
		if ( tema_viera_search_match( $q, $nombre . ' ' . $cargo . ' ' . $espec . ' ' . $raw_nombre . ' ' . $raw_cargo ) ) {
			$dedupe_key = tema_viera_search_normalize( $nombre );
			if ( isset( $seen_nombres[ $dedupe_key ] ) ) {
				continue;
			}
			$seen_nombres[ $dedupe_key ] = true;
			$abogados_hits[] = array(
				'title'    => $nombre,
				'subtitle' => $cargo ? ( 'Equipo · ' . $cargo ) : 'Equipo',
				'url'      => $equipo_url,
			);
			if ( count( $abogados_hits ) >= 3 ) {
				break;
			}
		}
	}
	if ( ! empty( $abogados_hits ) ) {
		$groups[] = array(
			'key'   => 'equipo',
			'label' => 'EQUIPO',
			'count' => count( $abogados_hits ),
			'items' => $abogados_hits,
		);
	}

	$total = 0;
	foreach ( $groups as $g ) {
		$total += count( $g['items'] );
	}

	wp_send_json_success( array(
		'query'  => $q,
		'total'  => $total,
		'groups' => $groups,
	) );
}
add_action( 'wp_ajax_tema_viera_search', 'tema_viera_search_ajax' );
add_action( 'wp_ajax_nopriv_tema_viera_search', 'tema_viera_search_ajax' );
