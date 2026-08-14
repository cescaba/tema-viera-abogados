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
 * URL de la página de equipo en el idioma actual.
 *
 * @return string
 */
function tema_viera_equipo_url() {
	$page = get_page_by_path( 'equipo' );
	if ( $page ) {
		$url = get_permalink( tema_viera_post_translated( $page->ID ) );
		if ( $url ) {
			return $url;
		}
	}
	return home_url( '/equipo/' );
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
		'tema_viera_abogados_hero_overline'       => array( 'Hero · Sobre-título', false ),
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
		'tema_viera_abogados_agenda_pre'          => array( 'Agenda · Pre-título', false ),
		'tema_viera_abogados_agenda_titulo'       => array( 'Agenda · Título', false ),
		'tema_viera_abogados_agenda_desc'         => array( 'Agenda · Descripción', true ),
		'tema_viera_abogados_agenda_btn_txt'      => array( 'Agenda · Botón', false ),
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
		'tema_viera_abogados_detalle_rec_titulo'  => array( 'Detalle · Título reconocimientos', false ),
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

	// Servicios (array) → Landing.
	$servicios = get_option( 'tema_viera_abogados_servicios_items', array() );
	if ( is_array( $servicios ) ) {
		foreach ( $servicios as $i => $servicio ) {
			$n = $i + 1;
			tema_viera_pll_register_string( 'Servicio ' . $n . ' · Título', isset( $servicio['titulo'] ) ? $servicio['titulo'] : '', 'Landing' );
			tema_viera_pll_register_string( 'Servicio ' . $n . ' · Descripción', isset( $servicio['descripcion'] ) ? $servicio['descripcion'] : '', 'Landing', true );

			$detalles = isset( $servicio['detalles'] ) ? $servicio['detalles'] : array();
			if ( ! is_array( $detalles ) ) {
				$detalles = explode( "\n", (string) $detalles );
			}
			foreach ( $detalles as $detalle ) {
				tema_viera_pll_register_string( 'Servicio ' . $n . ' · Detalle', trim( (string) $detalle ), 'Landing' );
			}
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
		'Términos de privacidad',
		'Libro de reclamaciones',
		'Información legal',
	);
	foreach ( $ui_strings as $string ) {
		tema_viera_pll_register_string( 'UI · ' . $string, $string, 'Interfaz' );
	}
}
add_action( 'init', 'tema_viera_register_polylang_strings', 20 );

/**
 * Registra el CPT "abogado" para que Polylang lo traduzca.
 */
function tema_viera_pll_post_types( $types ) {
	$types[] = 'abogado';
	return $types;
}
add_filter( 'pll_get_post_types', 'tema_viera_pll_post_types', 10, 1 );

/**
 * Registra las taxonomías "category" y "post_tag" para Polylang.
 */
function tema_viera_pll_taxonomies( $taxonomies ) {
	$taxonomies[] = 'category';
	$taxonomies[] = 'post_tag';
	return $taxonomies;
}
add_filter( 'pll_get_taxonomies', 'tema_viera_pll_taxonomies', 10, 1 );

/**
 * Al crear/guardar la traducción de un abogado, copia los campos que no
 * dependen del idioma (email, linkedin y la imagen destacada) desde la
 * entrada fuente cuando el destino los tiene vacíos.
 *
 * Solo rellena campos vacíos, para no pisar lo que el cliente edite a mano.
 *
 * @param int     $post_id      ID del post guardado.
 * @param WP_Post $post         Objeto del post.
 * @param array   $translations Mapa idioma => ID de post traducido.
 */
function tema_viera_copy_abogado_translation_fields( $post_id, $post, $translations ) {
	if ( ! isset( $post->post_type ) || 'abogado' !== $post->post_type ) {
		return;
	}
	if ( ! is_array( $translations ) || empty( $translations ) ) {
		return;
	}

	// Busca un post hermano (en otro idioma) como fuente de datos.
	$source_id = 0;
	foreach ( $translations as $tid ) {
		$tid = (int) $tid;
		if ( $tid && $tid !== (int) $post_id ) {
			$source_id = $tid;
			break;
		}
	}
	if ( ! $source_id ) {
		return;
	}

	$meta_fields = array(
		'_abogado_email',
		'_abogado_linkedin',
	);

	foreach ( $meta_fields as $meta_key ) {
		if ( '' === get_post_meta( $post_id, $meta_key, true ) ) {
			$value = get_post_meta( $source_id, $meta_key, true );
			if ( '' !== $value ) {
				update_post_meta( $post_id, $meta_key, $value );
			}
		}
	}

	// Imagen destacada (solo si el destino no tiene una).
	if ( ! has_post_thumbnail( $post_id ) ) {
		$thumb_id = get_post_thumbnail_id( $source_id );
		if ( $thumb_id ) {
			set_post_thumbnail( $post_id, $thumb_id );
		}
	}
}
add_action( 'pll_save_post', 'tema_viera_copy_abogado_translation_fields', 20, 3 );

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
