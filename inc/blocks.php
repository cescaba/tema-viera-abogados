<?php
/**
 * Bloques de Gutenberg personalizados + migración del cuerpo de noticias.
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renderizado del bloque "Cita con autor" (viera/cita-abogado).
 *
 * @param array $attributes Atributos del bloque.
 * @return string
 */
function tema_viera_render_cita_abogado( $attributes ) {
	$attributes = wp_parse_args( $attributes, array(
		'cita'    => '',
		'autorId' => 0,
	) );

	$cita     = tema_viera_t( trim( (string) $attributes['cita'] ) );
	$autor_id = absint( $attributes['autorId'] );

	$nombre = '';
	$cargo  = '';
	if ( $autor_id && get_post( $autor_id ) ) {
		$nombre = tema_viera_abogado_titulo( $autor_id );
		$cargo  = tema_viera_abogado_meta_t( $autor_id, 'cargo' );
	}

	ob_start();
	?>
	<blockquote class="sp-quote">
		<p><?php echo esc_html( $cita ); ?></p>
		<?php if ( $nombre ) : ?>
			<cite>
				<span class="sp-quote-name"><?php echo esc_html( $nombre ); ?></span>
				<?php if ( $cargo ) : ?>
					<span class="sp-quote-cargo"><?php echo esc_html( $cargo ); ?></span>
				<?php endif; ?>
			</cite>
		<?php endif; ?>
	</blockquote>
	<?php
	return ob_get_clean();
}

/**
 * Registra el bloque personalizado y su script del editor.
 */
function tema_viera_register_cita_abogado_block() {
	wp_register_script(
		'tema-viera-cita-abogado-block',
		TEMA_VIERA_ABOGADOS_URL . '/js/cita-abogado.js',
		array( 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-data', 'wp-element', 'wp-i18n' ),
		TEMA_VIERA_ABOGADOS_VERSION,
		true
	);

	register_block_type( 'viera/cita-abogado', array(
		'editor_script'   => 'tema-viera-cita-abogado-block',
		'render_callback' => 'tema_viera_render_cita_abogado',
	) );
}
add_action( 'init', 'tema_viera_register_cita_abogado_block' );

/**
 * Migración de una sola vez: convierte los bloques del metabox
 * (_post_bloques) en bloques de Gutenberg dentro de post_content.
 */
function tema_viera_migrate_post_bloques() {
	if ( get_option( 'tema_viera_bloques_migrated' ) ) {
		return;
	}

	if ( ! function_exists( 'serialize_block' ) ) {
		return;
	}

	$posts = get_posts( array(
		'post_type'      => 'post',
		'posts_per_page' => -1,
		'post_status'    => 'any',
		'meta_key'       => '_post_bloques',
	) );

	foreach ( $posts as $post ) {
		$bloques = get_post_meta( $post->ID, '_post_bloques', true );
		if ( ! is_array( $bloques ) || empty( $bloques ) ) {
			continue;
		}

		// No sobrescribir contenido existente.
		if ( '' !== trim( (string) $post->post_content ) ) {
			continue;
		}

		$blocks = array();

		foreach ( $bloques as $bloque ) {
			$bloque = wp_parse_args( (array) $bloque, array(
				'subtitulo'   => '',
				'descripcion' => '',
				'cita'        => '',
				'cita_autor'  => 0,
				'lista'       => '',
			) );

			$subtitulo = trim( (string) $bloque['subtitulo'] );
			if ( '' !== $subtitulo ) {
				$html = '<h2 class="wp-block-heading">' . esc_html( $subtitulo ) . '</h2>';
				$blocks[] = array(
					'blockName'    => 'core/heading',
					'attrs'        => array( 'level' => 2 ),
					'innerBlocks'  => array(),
					'innerHTML'    => $html,
					'innerContent' => array( $html ),
				);
			}

			$descripcion = trim( (string) $bloque['descripcion'] );
			if ( '' !== $descripcion ) {
				$parrafos = preg_split( '/\n\s*\n/', $descripcion );
				foreach ( $parrafos as $parrafo ) {
					$parrafo = trim( $parrafo );
					if ( '' === $parrafo ) {
						continue;
					}
					$html = '<p>' . wp_kses_post( $parrafo ) . '</p>';
					$blocks[] = array(
						'blockName'    => 'core/paragraph',
						'attrs'        => array(),
						'innerBlocks'  => array(),
						'innerHTML'    => $html,
						'innerContent' => array( $html ),
					);
				}
			}

			$cita = trim( (string) $bloque['cita'] );
			if ( '' !== $cita ) {
				$blocks[] = array(
					'blockName'    => 'viera/cita-abogado',
					'attrs'        => array(
						'cita'    => $cita,
						'autorId' => absint( $bloque['cita_autor'] ),
					),
					'innerBlocks'  => array(),
					'innerHTML'    => '',
					'innerContent' => array(),
				);
			}

			$lista = trim( (string) $bloque['lista'] );
			if ( '' !== $lista ) {
				$items = array_filter( array_map( 'trim', explode( "\n", $lista ) ) );
				if ( ! empty( $items ) ) {
					$lis = '';
					foreach ( $items as $item ) {
						$lis .= '<li>' . esc_html( $item ) . '</li>';
					}
					$html = '<ul class="wp-block-list">' . $lis . '</ul>';
					$blocks[] = array(
						'blockName'    => 'core/list',
						'attrs'        => array(),
						'innerBlocks'  => array(),
						'innerHTML'    => $html,
						'innerContent' => array( $html ),
					);
				}
			}
		}

		if ( ! empty( $blocks ) ) {
			$content = '';
			foreach ( $blocks as $block ) {
				$content .= serialize_block( $block );
			}

			wp_update_post( array(
				'ID'           => $post->ID,
				'post_content' => $content,
			) );

			delete_post_meta( $post->ID, '_post_bloques' );
		}
	}

	update_option( 'tema_viera_bloques_migrated', 1 );
}
add_action( 'admin_init', 'tema_viera_migrate_post_bloques' );

/**
 * Comando WP-CLI opcional: wp viera migrate-bloques
 */
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'viera migrate-bloques', function() {
		delete_option( 'tema_viera_bloques_migrated' );
		tema_viera_migrate_post_bloques();
		WP_CLI::success( 'Migración de bloques completada.' );
	} );
}

/* =====================================================
   Traducción del contenido de noticias (por bloque)
   ===================================================== */

/**
 * Extrae el texto de un bloque de encabezado (core/heading).
 */
function tema_viera_block_heading_text( $block ) {
	$html = isset( $block['innerHTML'] ) ? $block['innerHTML'] : '';
	if ( preg_match( '~<h[1-6][^>]*>(.*)</h[1-6]>~s', $html, $m ) ) {
		return html_entity_decode( $m[1], ENT_QUOTES, 'UTF-8' );
	}
	return html_entity_decode( wp_strip_all_tags( $html ), ENT_QUOTES, 'UTF-8' );
}

/**
 * Devuelve el bloque de encabezado con un texto nuevo.
 */
function tema_viera_block_set_heading_text( $block, $text ) {
	$level = isset( $block['attrs']['level'] ) ? absint( $block['attrs']['level'] ) : 2;
	$html  = '<h' . $level . ' class="wp-block-heading">' . esc_html( $text ) . '</h' . $level . '>';
	$block['innerHTML'] = $html;
	if ( isset( $block['innerContent'][0] ) ) {
		$block['innerContent'][0] = $html;
	}
	return $block;
}

/**
 * Extrae el texto de un párrafo (core/paragraph).
 */
function tema_viera_block_paragraph_text( $block ) {
	$html = isset( $block['innerHTML'] ) ? $block['innerHTML'] : '';
	if ( preg_match( '~<p>(.*)</p>~s', $html, $m ) ) {
		return $m[1];
	}
	return $html;
}

/**
 * Devuelve el párrafo con un texto nuevo.
 */
function tema_viera_block_set_paragraph_text( $block, $text ) {
	$html = '<p>' . wp_kses_post( $text ) . '</p>';
	$block['innerHTML'] = $html;
	if ( isset( $block['innerContent'][0] ) ) {
		$block['innerContent'][0] = $html;
	}
	return $block;
}

/**
 * Extrae los ítems de una lista plana (core/list sin inner blocks).
 */
function tema_viera_block_list_items( $block ) {
	$html = isset( $block['innerHTML'] ) ? $block['innerHTML'] : '';
	if ( preg_match_all( '~<li>(.*?)</li>~s', $html, $m ) ) {
		return array_map( function( $item ) {
			return html_entity_decode( $item, ENT_QUOTES, 'UTF-8' );
		}, $m[1] );
	}
	return array();
}

/**
 * Devuelve la lista plana con ítems nuevos.
 */
function tema_viera_block_set_list_items( $block, $items ) {
	$lis = '';
	foreach ( (array) $items as $item ) {
		$lis .= '<li>' . esc_html( $item ) . '</li>';
	}
	$html = '<ul class="wp-block-list">' . $lis . '</ul>';
	$block['innerHTML'] = $html;
	if ( isset( $block['innerContent'][0] ) ) {
		$block['innerContent'][0] = $html;
	}
	return $block;
}

/**
 * Extrae el texto de un ítem de lista (core/list-item).
 */
function tema_viera_block_list_item_text( $block ) {
	$html = isset( $block['innerHTML'] ) ? $block['innerHTML'] : '';
	if ( preg_match( '~<li>(.*)</li>~s', $html, $m ) ) {
		return $m[1];
	}
	return $html;
}

/**
 * Devuelve el ítem de lista con un texto nuevo.
 */
function tema_viera_block_set_list_item_text( $block, $text ) {
	$html = '<li>' . wp_kses_post( $text ) . '</li>';
	$block['innerHTML'] = $html;
	if ( isset( $block['innerContent'][0] ) ) {
		$block['innerContent'][0] = $html;
	}
	return $block;
}

/**
 * Recorre los bloques y aplica un callback a cada texto traducible.
 *
 * @param array    $blocks   Bloques devueltos por parse_blocks().
 * @param callable $callback function( $type, $value ) => $value.
 * @return array Bloques modificados.
 */
function tema_viera_map_block_texts( $blocks, $callback ) {
	foreach ( $blocks as $i => $block ) {
		$name = isset( $block['blockName'] ) ? $block['blockName'] : '';

		if ( ! empty( $block['innerBlocks'] ) ) {
			$block['innerBlocks'] = tema_viera_map_block_texts( $block['innerBlocks'], $callback );
		}

		if ( 'core/heading' === $name ) {
			$text  = tema_viera_block_heading_text( $block );
			$block = tema_viera_block_set_heading_text( $block, call_user_func( $callback, 'heading', $text ) );
		} elseif ( 'core/paragraph' === $name ) {
			$text  = tema_viera_block_paragraph_text( $block );
			$block = tema_viera_block_set_paragraph_text( $block, call_user_func( $callback, 'paragraph', $text ) );
		} elseif ( 'core/list' === $name ) {
			if ( ! empty( $block['innerBlocks'] ) ) {
				// Formato nuevo (ítems como inner blocks): ya traducidos arriba,
				// no reconstruir para no romper innerContent.
			} else {
				// Formato plano (li en innerHTML): extraer y reconstruir.
				$items = tema_viera_block_list_items( $block );
				foreach ( $items as $k => $item ) {
					$items[ $k ] = call_user_func( $callback, 'list_item', $item );
				}
				$block = tema_viera_block_set_list_items( $block, $items );
			}
		} elseif ( 'core/list-item' === $name ) {
			$text  = tema_viera_block_list_item_text( $block );
			$block = tema_viera_block_set_list_item_text( $block, call_user_func( $callback, 'list_item', $text ) );
		} elseif ( 'viera/cita-abogado' === $name ) {
			$attrs = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();
			$cita  = isset( $attrs['cita'] ) ? (string) $attrs['cita'] : '';
			$attrs['cita'] = call_user_func( $callback, 'cita', $cita );
			$block['attrs'] = $attrs;
		}

		$blocks[ $i ] = $block;
	}
	return $blocks;
}

/**
 * Imprime el contenido de una noticia en el idioma actual.
 *
 * Si la noticia tiene contenido en inglés propio, se usa ese; si no,
 * se traduce el contenido en español por bloques (cadenas compartidas).
 */
function tema_viera_the_post_content() {
	$post_id = get_the_ID();

	if ( function_exists( 'tema_viera_current_lang' ) && 'en' === tema_viera_current_lang() ) {
		$en = get_post_meta( $post_id, '_post_content_en', true );
		if ( is_string( $en ) && '' !== trim( $en ) ) {
			echo apply_filters( 'the_content', $en );
			return;
		}
	}

	$content = get_post_field( 'post_content', $post_id );

	if ( function_exists( 'parse_blocks' ) && function_exists( 'serialize_blocks' ) ) {
		$blocks  = parse_blocks( $content );
		$blocks  = tema_viera_map_block_texts( $blocks, function( $type, $value ) {
			return tema_viera_t( $value );
		} );
		$content = serialize_blocks( $blocks );
	} else {
		$content = tema_viera_t( $content );
	}

	echo apply_filters( 'the_content', $content );
}

/**
 * Devuelve el texto plano (sin markup de bloques) de una noticia, ya traducido.
 * Se usa para extractos y contadores de lectura.
 *
 * @param int $post_id ID del post.
 * @return string
 */
function tema_viera_post_content_plain( $post_id ) {
	$post_id = (int) $post_id;

	// Contenido en inglés propio de la noticia (tiene prioridad).
	if ( function_exists( 'tema_viera_current_lang' ) && 'en' === tema_viera_current_lang() ) {
		$en = get_post_meta( $post_id, '_post_content_en', true );
		if ( is_string( $en ) && '' !== trim( $en ) ) {
			return trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $en ) ) );
		}
	}

	$content = get_post_field( 'post_content', $post_id );

	if ( ! function_exists( 'parse_blocks' ) ) {
		return wp_strip_all_tags( preg_replace( '/<!--.*?-->/s', '', $content ) );
	}

	$parts = array();
	$blocks = parse_blocks( $content );
	tema_viera_map_block_texts( $blocks, function( $type, $value ) use ( &$parts ) {
		$parts[] = wp_strip_all_tags( tema_viera_t( $value ) );
		return $value;
	} );

	return trim( implode( ' ', array_filter( $parts ) ) );
}
