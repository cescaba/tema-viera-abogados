<?php
/**
 * Integración con Polylang
 *
 * Registra los textos del tema (opciones + cadenas fijas) para que sean
 * traducibles desde Idiomas → Traducciones de cadenas, y expone helpers
 * que funcionan de forma segura aunque Polylang no esté activo.
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ¿Está Polylang activo?
 */
function tema_viera_pll_active() {
	return function_exists( 'pll__' ) && function_exists( 'pll_register_string' );
}

/**
 * Traduce una cadena con Polylang o la devuelve sin cambios.
 *
 * @param string $text Texto a traducir.
 * @return string
 */
function tema_viera_t( $text ) {
	if ( ! is_string( $text ) || '' === $text ) {
		return $text;
	}
	if ( function_exists( 'pll__' ) ) {
		return pll__( $text );
	}
	return $text;
}

/**
 * Devuelve el título (nombre) de un abogado traducido al idioma actual.
 *
 * @param int $post_id ID del abogado.
 * @return string
 */
function tema_viera_abogado_titulo( $post_id ) {
	return tema_viera_t( get_the_title( $post_id ) );
}

/**
 * Devuelve un campo de texto de un abogado traducido al idioma actual.
 * (especialidad, cargo, tag/etiqueta, biografía)
 *
 * @param int    $post_id ID del abogado.
 * @param string $field   Nombre del campo (sin prefijo `_abogado_`).
 * @return string
 */
function tema_viera_abogado_meta_t( $post_id, $field ) {
	$value = get_post_meta( (int) $post_id, '_abogado_' . $field, true );
	return is_string( $value ) ? tema_viera_t( $value ) : $value;
}

/**
 * Grupo de cadenas de Polylang para un abogado (uno por abogado, para poder
 * filtrarlo en la pantalla de traducciones de cadenas).
 *
 * @param int $post_id ID del abogado.
 * @return string
 */
function tema_viera_abogado_translation_group( $post_id ) {
	return 'Abogados · ' . get_the_title( $post_id );
}

/**
 * URL directa a la pantalla de traducciones de cadenas filtrada por el
 * abogado indicado.
 *
 * @param int $post_id ID del abogado.
 * @return string
 */
function tema_viera_abogado_translation_url( $post_id ) {
	return admin_url( 'admin.php?page=mlang_strings&group=' . rawurlencode( tema_viera_abogado_translation_group( $post_id ) ) );
}

/**
 * Estado de traducción de un abogado: cuántos campos traducibles tiene y
 * cuántos ya están traducidos al primer idioma distinto del por defecto.
 *
 * @param int $post_id ID del abogado.
 * @return array|null Array con done/total/target, o null si no hay Polylang.
 */
function tema_viera_abogado_translation_status( $post_id ) {
	if ( ! function_exists( 'pll_languages_list' ) || ! function_exists( 'pll_default_language' ) || ! function_exists( 'pll_translate_string' ) ) {
		return null;
	}

	$default = pll_default_language();
	$langs   = pll_languages_list( array( 'fields' => 'slug' ) );
	$targets = array_values( array_diff( (array) $langs, array( $default ) ) );
	if ( empty( $targets ) ) {
		return null;
	}
	$target = $targets[0];

	$sources = array(
		get_the_title( $post_id ),
		get_post_meta( $post_id, '_abogado_especialidad', true ),
		get_post_meta( $post_id, '_abogado_cargo', true ),
		get_post_meta( $post_id, '_abogado_tag', true ),
		get_post_meta( $post_id, '_abogado_biografia', true ),
	);

	$total = 0;
	$done  = 0;
	foreach ( $sources as $src ) {
		$src = (string) $src;
		if ( '' === trim( $src ) ) {
			continue;
		}
		$total++;
		$tr = pll_translate_string( $src, $target );
		if ( is_string( $tr ) && $tr !== $src ) {
			$done++;
		}
	}

	return array( 'done' => $done, 'total' => $total, 'target' => $target );
}

/**
 * Devuelve el título de una noticia (post) traducido al idioma actual.
 *
 * @param int $post_id ID del post.
 * @return string
 */
function tema_viera_post_titulo( $post_id ) {
	return tema_viera_t( get_the_title( $post_id ) );
}

/**
 * Devuelve un meta de una noticia (post) traducido al idioma actual.
 *
 * @param int    $post_id ID del post.
 * @param string $field   Nombre completo del meta (ej: `_post_descripcion`).
 * @return string
 */
function tema_viera_post_meta_t( $post_id, $field ) {
	$value = get_post_meta( (int) $post_id, $field, true );
	return is_string( $value ) ? tema_viera_t( $value ) : $value;
}

/**
 * Grupo de cadenas de Polylang para una noticia (uno por noticia).
 *
 * @param int $post_id ID del post.
 * @return string
 */
function tema_viera_post_translation_group( $post_id ) {
	return 'Noticias · ' . get_the_title( $post_id );
}

/**
 * URL directa a la pantalla de traducciones de cadenas filtrada por noticia.
 *
 * @param int $post_id ID del post.
 * @return string
 */
function tema_viera_post_translation_url( $post_id ) {
	return admin_url( 'admin.php?page=mlang_strings&group=' . rawurlencode( tema_viera_post_translation_group( $post_id ) ) );
}

/**
 * Estado de traducción de una noticia: campos traducibles y ya traducidos.
 *
 * @param int $post_id ID del post.
 * @return array|null
 */
function tema_viera_post_translation_status( $post_id ) {
	if ( ! function_exists( 'pll_languages_list' ) || ! function_exists( 'pll_default_language' ) || ! function_exists( 'pll_translate_string' ) ) {
		return null;
	}

	$default = pll_default_language();
	$langs   = pll_languages_list( array( 'fields' => 'slug' ) );
	$targets = array_values( array_diff( (array) $langs, array( $default ) ) );
	if ( empty( $targets ) ) {
		return null;
	}
	$target = $targets[0];

	$sources = array(
		get_the_title( $post_id ),
		get_post_meta( $post_id, '_post_descripcion', true ),
		get_post_meta( $post_id, '_post_area_practica', true ),
		get_post_field( 'post_content', $post_id ),
	);

	$total = 0;
	$done  = 0;
	foreach ( $sources as $src ) {
		$src = (string) $src;
		if ( '' === trim( $src ) ) {
			continue;
		}
		$total++;
		$tr = pll_translate_string( $src, $target );
		if ( is_string( $tr ) && $tr !== $src ) {
			$done++;
		}
	}

	return array( 'done' => $done, 'total' => $total, 'target' => $target );
}

/**
 * Idioma actual (teniendo en cuenta AJAX del blog).
 *
 * @return string Slug del idioma (ej: 'es', 'en').
 */
function tema_viera_current_lang() {
	// El AJAX del blog envía el idioma explícitamente (ver js/main.js).
	if ( ! empty( $_REQUEST['pll_lang'] ) && is_string( $_REQUEST['pll_lang'] ) ) {
		$req = sanitize_key( wp_unslash( $_REQUEST['pll_lang'] ) );
		if ( function_exists( 'pll_languages_list' ) && in_array( $req, (array) pll_languages_list(), true ) ) {
			return $req;
		}
	}
	if ( function_exists( 'pll_current_language' ) ) {
		$lang = pll_current_language();
		if ( is_string( $lang ) && '' !== $lang ) {
			return $lang;
		}
	}
	// Fallback: detectar /en/ en la URL de referencia (peticiones AJAX).
	if ( ! empty( $_SERVER['HTTP_REFERER'] ) && is_string( $_SERVER['HTTP_REFERER'] ) ) {
		$ref = wp_unslash( $_SERVER['HTTP_REFERER'] );
		if ( preg_match( '#/en(/|$|\?|\#)#', $ref ) ) {
			return 'en';
		}
	}
	return function_exists( 'pll_default_language' ) ? (string) pll_default_language() : 'es';
}

/**
 * Home URL para un idioma dado (respeta el prefijo /en/ de Polylang).
 *
 * @param string|null $lang Slug del idioma. Null = idioma actual.
 * @return string
 */
function tema_viera_home_url( $lang = null ) {
	if ( function_exists( 'pll_home_url' ) ) {
		$target = $lang ? $lang : tema_viera_current_lang();
		$url    = pll_home_url( $target );
		if ( is_string( $url ) && '' !== $url ) {
			return trailingslashit( $url );
		}
	}
	return trailingslashit( home_url( '/' ) );
}

/**
 * Intercambia el home (ES ↔ EN) de una URL para mantener el mismo path
 * en el otro idioma. Ej: /mi-noticia/ → /en/mi-noticia/.
 *
 * Se usa para contenidos de idioma único (noticias/posts y taxonomías,
 * excluidos de la traducción de Polylang por diseño): la misma entrada
 * existe en ambos idiomas y solo cambia el prefijo.
 *
 * @param string      $url    URL original.
 * @param string|null $target Idioma destino. Null = el otro idioma.
 * @return string
 */
function tema_viera_swap_home_lang( $url, $target = null ) {
	if ( ! is_string( $url ) || '' === $url ) {
		return $url;
	}
	if ( ! function_exists( 'pll_home_url' ) || ! function_exists( 'pll_default_language' ) ) {
		return $url;
	}

	$current = tema_viera_current_lang();
	$default = (string) pll_default_language();
	if ( '' === $default ) {
		return $url;
	}

	if ( null === $target ) {
		$langs = function_exists( 'pll_languages_list' ) ? (array) pll_languages_list() : array( $default );
		$target = ( $current === $default && count( $langs ) > 1 ) ? $langs[0] : $default;
		foreach ( (array) $langs as $slug ) {
			if ( $slug !== $current ) {
				$target = $slug;
				break;
			}
		}
	}

	$home_target  = trailingslashit( (string) pll_home_url( $target ) );
	$home_default = trailingslashit( (string) pll_home_url( $default ) );
	$home_current = trailingslashit( (string) pll_home_url( $current ) );

	// Caso habitual: la URL cuelga del home actual o del home por defecto.
	foreach ( array_unique( array( $home_current, $home_default ) ) as $home_from ) {
		if ( '' !== $home_from && 0 === strpos( $url, $home_from ) ) {
			return $home_target . substr( $url, strlen( $home_from ) );
		}
	}

	return $url;
}

/**
 * Permalink de una noticia/post en el idioma actual.
 *
 * Los posts están excluidos de la traducción de Polylang (una sola entrada,
 * textos traducidos como cadenas), así que get_permalink() siempre devuelve
 * la URL en español. Esta función le aplica el prefijo /en/ cuando toca.
 *
 * @param int $post_id ID del post.
 * @return string
 */
function tema_viera_post_permalink( $post_id ) {
	$url = get_permalink( (int) $post_id );
	if ( ! $url ) {
		return '';
	}
	if ( ! function_exists( 'pll_current_language' ) ) {
		return $url;
	}
	$current = tema_viera_current_lang();
	$default = function_exists( 'pll_default_language' ) ? (string) pll_default_language() : 'es';
	if ( $current && $default && $current !== $default ) {
		$url = tema_viera_swap_home_lang( $url, $current );
	}
	return $url;
}

/**
 * URL de la página actual pero en el idioma destino, sin pasar por home.
 *
 * - Si Polylang conoce la traducción (páginas, portada, abogados), usa su URL.
 * - Si Polylang devuelve el home por falta de traducción (noticias, blog sin
 *   traducir, archivos de categoría), reconstruye la misma ruta con el home
 *   del idioma destino y conserva la query string (?cat=...).
 *
 * @param string $target Slug del idioma destino ('es' | 'en').
 * @return string
 */
function tema_viera_switch_url( $target ) {
	$target = sanitize_key( (string) $target );
	if ( '' === $target ) {
		return home_url( '/' );
	}

	$pll_url = '';
	if ( function_exists( 'pll_the_languages' ) ) {
		$langs = pll_the_languages( array( 'raw' => 1 ) );
		if ( is_array( $langs ) ) {
			foreach ( $langs as $l ) {
				if ( isset( $l['slug'] ) && $l['slug'] === $target && ! empty( $l['url'] ) ) {
					$pll_url = $l['url'];
					break;
				}
			}
		}
	}

	$target_home = function_exists( 'pll_home_url' )
		? trailingslashit( (string) pll_home_url( $target ) )
		: trailingslashit( home_url( '/' ) );

	$is_translatable_context = false;
	if ( is_singular( 'post' ) || is_category() || is_tag() || is_tax() ) {
		// Contenidos de idioma único por diseño: Polylang siempre devuelve home.
		$is_translatable_context = false;
	} elseif ( is_singular() || is_page() || is_front_page() || is_home() ) {
		$is_translatable_context = true;
	}

	// Noticias y taxonomías: misma entrada, solo cambia el prefijo.
	if ( is_singular( 'post' ) && get_the_ID() ) {
		$canon = get_permalink( get_the_ID() );
		if ( $canon ) {
			return tema_viera_swap_home_lang( $canon, $target );
		}
	}
	if ( is_category() || is_tag() || is_tax() ) {
		$term_url = get_term_link( get_queried_object() );
		if ( $term_url && ! is_wp_error( $term_url ) ) {
			return tema_viera_swap_home_lang( $term_url, $target );
		}
	}

	// Si hay traducción real (la URL no es el home), usarla.
	if ( '' !== $pll_url ) {
		$norm_pll  = trailingslashit( strtok( $pll_url, '?#' ) );
		$norm_home = trailingslashit( strtok( $target_home, '?#' ) );
		$is_home_fallback = ( $norm_pll === $norm_home );
		$current_is_home  = is_front_page() || is_home();

		if ( ! $is_home_fallback || $current_is_home ) {
			return $pll_url;
		}
		// Hay fallback a home pero estamos en contenido traducible con
		// traducción existente no detectada (raro): si el objeto actual tiene
		// traducción, usarla antes del fallback manual.
		if ( $is_translatable_context && is_singular() && function_exists( 'pll_get_post' ) ) {
			$tr = pll_get_post( get_the_ID(), $target );
			if ( $tr ) {
				$permalink = get_permalink( $tr );
				if ( $permalink ) {
					return $permalink;
				}
			}
		}
	}

	// Fallback manual: misma ruta (?cat= incluido) bajo el home destino.
	global $wp;
	$request = isset( $wp->request ) ? trim( (string) $wp->request, '/' ) : '';
	if ( '' === $request && ! empty( $_SERVER['REQUEST_URI'] ) ) {
		$request = trim( wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ), '/' );
		$site_path = trim( wp_parse_url( site_url( '/' ), PHP_URL_PATH ), '/' );
		if ( '' !== $site_path && 0 === strpos( $request, $site_path ) ) {
			$request = trim( substr( $request, strlen( $site_path ) ), '/' );
		}
	}
	// Quitar el prefijo de idioma actual (/en/...) para no duplicarlo.
	if ( function_exists( 'pll_languages_list' ) ) {
		foreach ( (array) pll_languages_list() as $slug ) {
			$slug = (string) $slug;
			if ( '' !== $slug && ( $request === $slug || 0 === strpos( $request, $slug . '/' ) ) ) {
				$request = trim( substr( $request, strlen( $slug ) ), '/' );
				break;
			}
		}
	}

	$qs = '';
	if ( ! empty( $_SERVER['QUERY_STRING'] ) && is_string( $_SERVER['QUERY_STRING'] ) ) {
		$qs = '?' . ltrim( wp_unslash( $_SERVER['QUERY_STRING'] ), '?&' );
	}

	return $target_home . $request . $qs;
}

/**
 * Devuelve el ID del post traducido al idioma actual (o el original si no hay traducción).
 *
 * @param int $post_id ID del post original.
 * @return int
 */
function tema_viera_post_translated( $post_id ) {
	$post_id = (int) $post_id;
	if ( ! $post_id ) {
		return $post_id;
	}
	if ( function_exists( 'pll_get_post' ) && function_exists( 'pll_current_language' ) ) {
		$lang       = pll_current_language();
		$translated = $lang ? pll_get_post( $post_id, $lang ) : 0;
		if ( $translated ) {
			return $translated;
		}
	}
	return $post_id;
}

/**
 * URL con ancla (#seccion) del home en el idioma actual.
 *
 * Garantiza el prefijo /en/ sin depender del filtro de home_url de Polylang.
 * Ej: https://tusitio.com/en/#agendar-cita
 *
 * @param string $anchor Nombre del ancla sin # (ej: 'agendar-cita').
 * @return string
 */
function tema_viera_anchor_url( $anchor ) {
	$anchor = ltrim( (string) $anchor, '#/' );
	$home   = function_exists( 'tema_viera_home_url' ) ? tema_viera_home_url() : trailingslashit( home_url( '/' ) );
	return $home . '#' . $anchor;
}

/**
 * URL de la página de equipo en el idioma actual.
 *
 * @return string
 */
function tema_viera_equipo_url() {
	$page = get_page_by_path( 'equipo' );
	if ( $page ) {
		$translated_id = tema_viera_post_translated( $page->ID );
		$url = get_permalink( $translated_id );
		if ( $url ) {
			// Si la página no tiene traducción al idioma actual, get_permalink
			// devuelve la URL en español: aplicar el prefijo /en/.
			if ( $translated_id === (int) $page->ID ) {
				$url = tema_viera_swap_home_lang( $url, tema_viera_current_lang() );
			}
			return $url;
		}
	}
	return tema_viera_swap_home_lang( home_url( '/equipo/' ), tema_viera_current_lang() );
}

/**
 * URL de la página de Términos y Condiciones en el idioma actual.
 *
 * @return string
 */
function tema_viera_terminos_url() {
	$page = get_pages( array(
		'meta_key'   => '_wp_page_template',
		'meta_value' => 'page-terminos.php',
		'number'     => 1,
	) );

	if ( ! empty( $page ) ) {
		$translated_id = tema_viera_post_translated( $page[0]->ID );
		$url = get_permalink( $translated_id );
		if ( $url ) {
			if ( $translated_id === (int) $page[0]->ID ) {
				$url = tema_viera_swap_home_lang( $url, tema_viera_current_lang() );
			}
			return $url;
		}
	}

	$page = get_page_by_path( 'terminos-y-condiciones' );
	if ( $page ) {
		$translated_id = tema_viera_post_translated( $page->ID );
		$url = get_permalink( $translated_id );
		if ( $url ) {
			if ( $translated_id === (int) $page->ID ) {
				$url = tema_viera_swap_home_lang( $url, tema_viera_current_lang() );
			}
			return $url;
		}
	}

	return tema_viera_swap_home_lang( home_url( '/terminos-y-condiciones/' ), tema_viera_current_lang() );
}

/**
 * Registra una cadena en Polylang (con guard de seguridad).
 *
 * @param string $name      Nombre único de la cadena (columna "Name").
 * @param string $string    Cadena fuente (español).
 * @param string $context   Grupo (columna "Group" / filtro del admin).
 * @param bool   $multiline Mostrar como textarea en el admin.
 */
function tema_viera_pll_register_string( $name, $string, $context = 'Tema Viera', $multiline = false ) {
	if ( ! is_string( $string ) || '' === trim( $string ) ) {
		return;
	}
	if ( function_exists( 'pll_register_string' ) ) {
		pll_register_string( $name, $string, $context, $multiline );
	}
}

/**
 * Registra todos los textos traducibles del tema en Polylang,
 * agrupados por página (Landing, Página Equipo, Interfaz).
 */
function tema_viera_register_polylang_strings() {
	if ( ! tema_viera_pll_active() ) {
		return;
	}

	// Grupo "Landing" (front-page.php). key => array( nombre, multiline ).
	$landing = array(
		'tema_viera_abogados_hero_titulo'         => array( 'Hero · Título', false ),
		'tema_viera_abogados_hero_subtitulo'      => array( 'Hero · Subtítulo', false ),
		'tema_viera_abogados_hero_btn1_texto'     => array( 'Hero · Botón 1', false ),
		'tema_viera_abogados_hero_btn2_texto'     => array( 'Hero · Botón 2', false ),
		'tema_viera_abogados_sobre_titulo'        => array( 'Sobre · Título', false ),
		'tema_viera_abogados_sobre_contenido'     => array( 'Sobre · Contenido', true ),
		'tema_viera_abogados_servicios_titulo'    => array( 'Servicios · Título', false ),
		'tema_viera_abogados_abogados_titulo'     => array( 'Abogados · Título', false ),
		'tema_viera_abogados_abogados_subtitulo'  => array( 'Abogados · Subtítulo', false ),
		'tema_viera_abogados_contacto_titulo'     => array( 'Contacto · Título', false ),
		'tema_viera_abogados_contacto_mensaje'    => array( 'Contacto · Mensaje', false ),
		'tema_viera_abogados_contacto_direccion'  => array( 'Contacto · Dirección', false ),
		'tema_viera_abogados_texto_animado_1'     => array( 'Texto animado · Línea 1', false ),
		'tema_viera_abogados_texto_animado_2'     => array( 'Texto animado · Línea 2', false ),
		'tema_viera_abogados_exp_pre_titulo'      => array( 'Experiencia · Pre-título', false ),
		'tema_viera_abogados_exp_titulo'          => array( 'Experiencia · Título', false ),
		'tema_viera_abogados_exp_subtitulo'       => array( 'Experiencia · Subtítulo', false ),
		'tema_viera_abogados_clientes_titulo'     => array( 'Clientes · Título', false ),
		'tema_viera_abogados_equipo_pre'          => array( 'Equipo · Pre-título', false ),
		'tema_viera_abogados_equipo_titulo'       => array( 'Equipo · Título', false ),
		'tema_viera_abogados_equipo_enlace_txt'   => array( 'Equipo · Texto del enlace', false ),
		'tema_viera_abogados_kpi_1_label'         => array( 'KPI 1 · Etiqueta', false ),
		'tema_viera_abogados_kpi_2_label'         => array( 'KPI 2 · Etiqueta', false ),
		'tema_viera_abogados_kpi_3_label'         => array( 'KPI 3 · Etiqueta', false ),
		'tema_viera_abogados_kpi_4_label'         => array( 'KPI 4 · Etiqueta', false ),
		'tema_viera_abogados_agenda_pre'          => array( 'Agenda · Pre-título', false ),
		'tema_viera_abogados_agenda_titulo'       => array( 'Agenda · Título', false ),
		'tema_viera_abogados_agenda_desc'         => array( 'Agenda · Descripción', true ),
		'tema_viera_abogados_badge1_titulo'       => array( 'Badge 1 · Título', false ),
		'tema_viera_abogados_badge1_sub'          => array( 'Badge 1 · Subtítulo', false ),
		'tema_viera_abogados_badge2_titulo'       => array( 'Badge 2 · Título', false ),
		'tema_viera_abogados_badge2_sub'          => array( 'Badge 2 · Subtítulo', false ),
		'tema_viera_abogados_badge3_titulo'       => array( 'Badge 3 · Título', false ),
		'tema_viera_abogados_badge3_sub'          => array( 'Badge 3 · Subtítulo', false ),
		'tema_viera_abogados_citas_zona'          => array( 'Citas · Zona horaria', false ),
		'tema_viera_abogados_citas_form_titulo'   => array( 'Citas · Título formulario', false ),
		'tema_viera_abogados_citas_form_sub'      => array( 'Citas · Subtítulo formulario', false ),
		'tema_viera_abogados_citas_nota'          => array( 'Citas · Nota formulario', false ),
		'tema_viera_abogados_citas_btn_txt'       => array( 'Citas · Botón', false ),
		'tema_viera_abogados_citas_wa_msg'        => array( 'Citas · Mensaje WhatsApp', true ),
		'tema_viera_abogados_noticias_pre'        => array( 'Noticias · Pre-título', false ),
		'tema_viera_abogados_noticias_titulo'     => array( 'Noticias · Título', false ),
		'tema_viera_abogados_noticias_btn'        => array( 'Noticias · Botón', false ),
	);

	// Grupo "Página Equipo" (page-equipo.php).
	$equipo_page = array(
		'tema_viera_abogados_perfil_pre'          => array( 'Perfil · Pre-título', false ),
		'tema_viera_abogados_perfil_nombre'       => array( 'Perfil · Nombre', false ),
		'tema_viera_abogados_perfil_cargo'        => array( 'Perfil · Cargo', false ),
		'tema_viera_abogados_perfil_cita'         => array( 'Perfil · Cita', false ),
		'tema_viera_abogados_perfil_cita_autor'   => array( 'Perfil · Autor de la cita', false ),
		'tema_viera_abogados_perfil_pre_logos'    => array( 'Perfil · Pre-logos', false ),
		'tema_viera_abogados_detalle_pre'         => array( 'Detalle · Pre-título', false ),
		'tema_viera_abogados_detalle_titulo'      => array( 'Detalle · Título', false ),
		'tema_viera_abogados_detalle_contenido'   => array( 'Detalle · Contenido', true ),
		'tema_viera_abogados_sidebar_esp_titulo'  => array( 'Sidebar · Título especialidades', false ),
		'tema_viera_abogados_sidebar_mem_titulo'  => array( 'Sidebar · Título membresías', false ),
		'tema_viera_abogados_sidebar_correo_tit'  => array( 'Sidebar · Título correo', false ),
		'tema_viera_abogados_equipo_grid_tit'     => array( 'Grid equipo · Título', false ),
		'tema_viera_abogados_equipo_grid_desc'    => array( 'Grid equipo · Descripción', true ),
	);

	foreach ( $landing as $key => $cfg ) {
		tema_viera_pll_register_string( $cfg[0], get_option( $key, '' ), 'Landing', $cfg[1] );
	}

	foreach ( $equipo_page as $key => $cfg ) {
		tema_viera_pll_register_string( $cfg[0], get_option( $key, '' ), 'Página Equipo', $cfg[1] );
	}

	// Grupo "Términos y Condiciones" (page-terminos.php).
	// Se usa el getter con defaults para que el grupo exista
	// aunque aún no se haya guardado la página de opciones.
	$terminos = array(
		array( 'key' => 'pre',    'name' => 'Términos · Pre-título',  'multiline' => false ),
		array( 'key' => 'titulo', 'name' => 'Términos · Título',      'multiline' => false ),
		array( 'key' => 'fecha',  'name' => 'Términos · Fecha',       'multiline' => false ),
		array( 'key' => 'toc',    'name' => 'Términos · Índice',      'multiline' => false ),
		array( 'key' => 'intro',  'name' => 'Términos · Introducción', 'multiline' => true ),
	);

	foreach ( $terminos as $cfg ) {
		$value = function_exists( 'tema_viera_get_terminos_option' )
			? tema_viera_get_terminos_option( $cfg['key'] )
			: get_option( 'tema_viera_abogados_terminos_' . $cfg['key'], '' );
		tema_viera_pll_register_string( $cfg['name'], $value, 'Términos', $cfg['multiline'] );
	}

	// Grupo "Blog" (page-blog.php).
	$blog = array(
		'Blog · Título'                          => 'Casos, noticias y actualidad legal',
		'Blog · Descripción'                     => 'Análisis, novedades regulatorias y actualizaciones de nuestro equipo sobre los temas legales más relevantes para tu empresa.',
		'Blog · Todos'                           => 'Todos',
		'Blog · Cargar más'                      => 'CARGAR MÁS ARTÍCULOS',
		'Blog · Leer artículo'                   => 'Leer artículo completo',
		'Blog · min de lectura'                  => 'min de lectura',
		'Blog · Categoría Litigios Civiles'      => 'Litigios Civiles',
		'Blog · Categoría Litigios Administrativos' => 'Litigios Administrativos',
		'Blog · Categoría Litigios Penales'      => 'Litigios Penales',
		'Blog · Categoría Litigios Laborales'    => 'Litigios Laborales',
		'Blog · Categoría Reconocimientos'       => 'Reconocimientos',
	);

	foreach ( $blog as $name => $string ) {
		tema_viera_pll_register_string( $name, $string, 'Blog' );
	}

	// Secciones de Términos (array). Con defaults para que existan
	// aunque aún no se haya guardado la página de opciones.
	$terminos_secciones = function_exists( 'tema_viera_get_terminos_option' )
		? tema_viera_get_terminos_option( 'secciones' )
		: get_option( 'tema_viera_abogados_terminos_secciones', array() );
	if ( is_array( $terminos_secciones ) ) {
		foreach ( $terminos_secciones as $i => $seccion ) {
			$n = $i + 1;
			tema_viera_pll_register_string( 'Términos ' . $n . ' · Título', isset( $seccion['titulo'] ) ? $seccion['titulo'] : '', 'Términos' );
			tema_viera_pll_register_string( 'Términos ' . $n . ' · Contenido', isset( $seccion['contenido'] ) ? $seccion['contenido'] : '', 'Términos', true );
		}
	}

	// Servicios (array) → Landing.
	$servicios = get_option( 'tema_viera_abogados_servicios_items', array() );
	if ( is_array( $servicios ) ) {
		foreach ( $servicios as $i => $servicio ) {
			$n = $i + 1;
			tema_viera_pll_register_string( 'Servicio ' . $n . ' · Título', isset( $servicio['titulo'] ) ? $servicio['titulo'] : '', 'Landing' );
			tema_viera_pll_register_string( 'Servicio ' . $n . ' · Descripción', isset( $servicio['descripcion'] ) ? $servicio['descripcion'] : '', 'Landing', true );
		}
	}

	// Sectores / Experiencia (array) → Landing.
	$sectores = get_option( 'tema_viera_abogados_sectores_items', array() );
	if ( is_array( $sectores ) ) {
		foreach ( $sectores as $i => $sector ) {
			$n = $i + 1;
			tema_viera_pll_register_string( 'Sector ' . $n . ' · Título', isset( $sector['titulo'] ) ? $sector['titulo'] : '', 'Landing' );
			tema_viera_pll_register_string( 'Sector ' . $n . ' · Descripción', isset( $sector['descripcion'] ) ? $sector['descripcion'] : '', 'Landing', true );
		}
	}

	// Listas del sidebar (arrays) → Página Equipo.
	$sidebar_esp = get_option( 'tema_viera_abogados_sidebar_esp_items', array() );
	if ( is_array( $sidebar_esp ) ) {
		foreach ( $sidebar_esp as $i => $item ) {
			tema_viera_pll_register_string( 'Especialidad ' . ( $i + 1 ), $item, 'Página Equipo' );
		}
	}

	$sidebar_mem = get_option( 'tema_viera_abogados_sidebar_mem_items', array() );
	if ( is_array( $sidebar_mem ) ) {
		foreach ( $sidebar_mem as $i => $item ) {
			tema_viera_pll_register_string( 'Membresía ' . ( $i + 1 ), $item, 'Página Equipo' );
		}
	}

	// Cadenas fijas de la interfaz (header, footer, botones) → Interfaz.
	$ui_strings = array(
		'INICIO',
		'SERVICIOS',
		'EXPERIENCIA',
		'EQUIPO',
		'CONVERSEMOS',
		'MENU',
		'PRIVACIDAD Y LEGAL',
		'CONTACTO',
		'SEGUIR',
		'INSTAGRAM',
		'LINKEDIN',
		'RECONOCIMIENTOS',
		'INTERNACIONALES',
		'VER MÁS',
		'OCULTAR',
		'FUNDADOR',
		'Servicio',
		'Experiencia',
		'Equipo',
		'Blog',
		'Términos y Condiciones',
		'Libro de reclamaciones',
		'Información legal',
		'COMPARTIR',
		'ESCRITO POR',
		'Artículos relacionados',
	);
	foreach ( $ui_strings as $string ) {
		tema_viera_pll_register_string( 'UI · ' . $string, $string, 'Interfaz' );
	}
}
add_action( 'init', 'tema_viera_register_polylang_strings', 20 );

/**
 * Registra los campos de texto de cada abogado como cadenas de Polylang
 * (grupo "Abogados") para poder traducirlos sin duplicar el post.
 *
 * Solo se registran los abogados en el idioma por defecto; el resto se
 * ignora para no duplicar cadenas fuente.
 */
function tema_viera_register_abogado_strings() {
	if ( ! tema_viera_pll_active() ) {
		return;
	}

	$default_lang = function_exists( 'pll_default_language' ) ? pll_default_language() : '';

	$abogados = get_posts( array(
		'post_type'      => 'abogado',
		'posts_per_page' => -1,
		'post_status'    => 'any',
	) );

	// Términos compartidos: se registran una sola vez (sin duplicados).
	$cargos         = array();
	$etiquetas      = array();
	$especialidades = array();

	foreach ( $abogados as $abogado ) {
		$id = (int) $abogado->ID;

		// Solo registra la entrada en el idioma por defecto como fuente.
		if ( $default_lang && function_exists( 'pll_get_post_language' ) ) {
			$post_lang = pll_get_post_language( $id );
			if ( $post_lang && $post_lang !== $default_lang ) {
				continue;
			}
		}

		// Únicos por abogado → grupo del abogado.
		tema_viera_pll_register_string( 'Abogado ' . $id . ' · Nombre', get_the_title( $id ), tema_viera_abogado_translation_group( $id ) );
		tema_viera_pll_register_string( 'Abogado ' . $id . ' · Biografía', get_post_meta( $id, '_abogado_biografia', true ), tema_viera_abogado_translation_group( $id ), true );

		// Compartidos → se recogen para registrarlos una sola vez.
		$cargo        = trim( (string) get_post_meta( $id, '_abogado_cargo', true ) );
		$tag          = trim( (string) get_post_meta( $id, '_abogado_tag', true ) );
		$especialidad = trim( (string) get_post_meta( $id, '_abogado_especialidad', true ) );

		if ( '' !== $cargo )        { $cargos[ $cargo ]         = true; }
		if ( '' !== $tag )          { $etiquetas[ $tag ]        = true; }
		if ( '' !== $especialidad ) { $especialidades[ $especialidad ] = true; }
	}

	foreach ( array_keys( $cargos ) as $cargo ) {
		tema_viera_pll_register_string( 'Cargo · ' . $cargo, $cargo, 'Abogados · Términos' );
	}
	foreach ( array_keys( $etiquetas ) as $tag ) {
		tema_viera_pll_register_string( 'Etiqueta · ' . $tag, $tag, 'Abogados · Términos' );
	}
	foreach ( array_keys( $especialidades ) as $esp ) {
		tema_viera_pll_register_string( 'Especialidad · ' . $esp, $esp, 'Abogados · Términos' );
	}
}
add_action( 'init', 'tema_viera_register_abogado_strings', 30 );

/**
 * Registra los campos de texto de cada noticia (post) como cadenas de
 * Polylang (grupo "Noticias · {título}") para traducirlas sin duplicar el post.
 *
 * Solo se registran las noticias en el idioma por defecto como fuente.
 */
function tema_viera_register_post_strings() {
	if ( ! tema_viera_pll_active() ) {
		return;
	}

	$default_lang = function_exists( 'pll_default_language' ) ? pll_default_language() : '';

	$posts = get_posts( array(
		'post_type'      => 'post',
		'posts_per_page' => -1,
		'post_status'    => 'any',
	) );

	foreach ( $posts as $p ) {
		$id = (int) $p->ID;

		if ( $default_lang && function_exists( 'pll_get_post_language' ) ) {
			$post_lang = pll_get_post_language( $id );
			if ( $post_lang && $post_lang !== $default_lang ) {
				continue;
			}
		}

		$fields = array(
			'Título'           => get_the_title( $id ),
			'Descripción'     => get_post_meta( $id, '_post_descripcion', true ),
			'Área de práctica' => get_post_meta( $id, '_post_area_practica', true ),
		);
		$group = tema_viera_post_translation_group( $id );

		foreach ( $fields as $label => $value ) {
			tema_viera_pll_register_string( 'Noticia ' . $id . ' · ' . $label, $value, $group );
		}

		// Registrar el cuerpo del artículo por bloque (texto limpio, sin markup).
		if ( function_exists( 'parse_blocks' ) && function_exists( 'tema_viera_map_block_texts' ) ) {
			$labels = array(
				'heading'   => 'Subtítulo',
				'paragraph' => 'Párrafo',
				'list_item' => 'Lista',
				'cita'      => 'Cita',
			);
			$counts = array();

			$blocks = parse_blocks( get_post_field( 'post_content', $id ) );
			tema_viera_map_block_texts( $blocks, function( $type, $value ) use ( &$counts, $labels, $id, $group ) {
				if ( ! isset( $counts[ $type ] ) ) {
					$counts[ $type ] = 0;
				}
				$counts[ $type ]++;
				$label = 'Noticia ' . $id . ' · ' . $labels[ $type ] . ' ' . $counts[ $type ];
				tema_viera_pll_register_string( $label, $value, $group, ( 'paragraph' === $type ) );
				return $value;
			} );
		}
	}
}
add_action( 'init', 'tema_viera_register_post_strings', 30 );

/**
 * Registra el nombre de cada categoría de noticias como cadena de Polylang
 * (grupo "Blog") para que se pueda traducir desde
 * Idiomas → Traducciones de cadenas sin duplicar categorías por idioma.
 *
 * Las categorías base ya están registradas; aquí se cubren también las
 * personalizadas creadas en Entradas → Categorías.
 */
function tema_viera_register_category_strings() {
	if ( ! tema_viera_pll_active() ) {
		return;
	}

	$terms = get_terms( array(
		'taxonomy'   => 'category',
		'hide_empty' => false,
	) );
	if ( is_wp_error( $terms ) || ! is_array( $terms ) ) {
		return;
	}

	foreach ( $terms as $term ) {
		tema_viera_pll_register_string( 'Categoría · ' . $term->name, $term->name, 'Blog' );
	}
}
add_action( 'init', 'tema_viera_register_category_strings', 30 );

/**
 * Evita que Polylang traduzca las entradas (post) creando copias por idioma;
 * ahora sus textos se traducen como cadenas.
 */
function tema_viera_pll_post_types( $types ) {
	$types = array_values( array_diff( (array) $types, array( 'post' ) ) );
	return $types;
}
add_filter( 'pll_get_post_types', 'tema_viera_pll_post_types', 10, 1 );

/**
 * Evita que Polylang traduzca categorías y etiquetas (un solo set de categorías del blog).
 */
function tema_viera_pll_taxonomies( $taxonomies ) {
	$taxonomies = array_values( array_diff( (array) $taxonomies, array( 'category', 'post_tag' ) ) );
	return $taxonomies;
}
add_filter( 'pll_get_taxonomies', 'tema_viera_pll_taxonomies', 10, 1 );

/**
 * Imprime un botón "Traducir al inglés →" que enlaza a la pantalla de
 * traducciones de cadenas de Polylang, ya filtrada por grupo.
 *
 * @param string $group Grupo/contexto (Landing, Página Equipo, Interfaz).
 */
function tema_viera_translation_button( $group = 'Landing' ) {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	$url = admin_url( 'admin.php?page=mlang_strings&group=' . rawurlencode( $group ) );
	?>
	<p style="margin: 12px 0 0;">
		<a class="button" href="<?php echo esc_url( $url ); ?>">
			<?php esc_html_e( 'Traducir al inglés →', 'tema-viera-abogados' ); ?>
		</a>
	</p>
	<?php
}
