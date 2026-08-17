<?php
/**
 * Meta Boxes para Posts (Entradas)
 *
 * Agrega campos extra a las entradas: subtítulo y área de práctica
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tema_viera_register_post_metabox() {
	add_meta_box(
		'tema_viera_post_info',
		esc_html__( 'Información de la Noticia', 'tema-viera-abogados' ),
		'tema_viera_render_post_metabox',
		'post',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'tema_viera_register_post_metabox' );

function tema_viera_render_post_metabox( $post ) {
	wp_nonce_field( 'tema_viera_post_nonce', 'tema_viera_post_nonce_field' );

	$subtitulo        = get_post_meta( $post->ID, '_post_subtitulo', true );
	$area_practica    = get_post_meta( $post->ID, '_post_area_practica', true );
	?>

	<style>
		.tema-viera-post-field { margin-bottom: 20px; }
		.tema-viera-post-field label { display: block; margin-bottom: 5px; font-weight: 600; color: #333; }
		.tema-viera-post-field input, .tema-viera-post-field textarea {
			width: 100%; max-width: 500px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;
		}
		.tema-viera-post-field input:focus, .tema-viera-post-field textarea:focus {
			outline: none; border-color: #d4af37; box-shadow: 0 0 5px rgba(212, 175, 55, 0.3);
		}
		.tema-viera-help-text { font-size: 12px; color: #999; margin-top: 3px; }
	</style>

	<div class="tema-viera-post-field">
		<label for="tema_viera_post_subtitulo">
			<?php esc_html_e( 'Subtítulo', 'tema-viera-abogados' ); ?>
		</label>
		<input type="text" id="tema_viera_post_subtitulo" name="tema_viera_post_subtitulo"
			value="<?php echo esc_attr( $subtitulo ); ?>"
			placeholder="<?php esc_attr_e( 'Texto que aparece debajo del título', 'tema-viera-abogados' ); ?>" />
		<div class="tema-viera-help-text">
			<?php esc_html_e( 'Se muestra como etiqueta en las tarjetas del landing y debajo del título en la página de detalle.', 'tema-viera-abogados' ); ?>
		</div>
	</div>

	<div class="tema-viera-post-field">
		<label for="tema_viera_post_area_practica">
			<?php esc_html_e( 'Área de práctica', 'tema-viera-abogados' ); ?>
		</label>
		<input type="text" id="tema_viera_post_area_practica" name="tema_viera_post_area_practica"
			value="<?php echo esc_attr( $area_practica ); ?>"
			placeholder="<?php esc_attr_e( 'Ej: Derecho Penal, Corporativo, Litigios', 'tema-viera-abogados' ); ?>" />
		<div class="tema-viera-help-text">
			<?php esc_html_e( 'Clasificación del caso o noticia.', 'tema-viera-abogados' ); ?>
		</div>
	</div>

	<?php if ( function_exists( 'pll_register_string' ) && function_exists( 'tema_viera_post_translation_group' ) ) : ?>
		<div class="tema-viera-post-field" style="border-top: 1px solid #eee; padding-top: 15px;">
			<?php tema_viera_translation_button( tema_viera_post_translation_group( $post->ID ) ); ?>
		</div>
	<?php endif; ?>
	<?php
}

function tema_viera_save_post_metabox( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['tema_viera_post_nonce_field'] ) ||
		 ! wp_verify_nonce( $_POST['tema_viera_post_nonce_field'], 'tema_viera_post_nonce' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['tema_viera_post_subtitulo'] ) ) {
		update_post_meta( $post_id, '_post_subtitulo', sanitize_text_field( $_POST['tema_viera_post_subtitulo'] ) );
	}

	if ( isset( $_POST['tema_viera_post_area_practica'] ) ) {
		update_post_meta( $post_id, '_post_area_practica', sanitize_text_field( $_POST['tema_viera_post_area_practica'] ) );
	}
}
add_action( 'save_post', 'tema_viera_save_post_metabox' );

/**
 * Columna "Traducción" en el listado de entradas.
 */
function tema_viera_posts_admin_columns( $columns ) {
	$columns['traduccion'] = esc_html__( 'Traducción', 'tema-viera-abogados' );
	return $columns;
}
add_filter( 'manage_post_posts_columns', 'tema_viera_posts_admin_columns' );

/**
 * Contenido de la columna "Traducción" en el listado de entradas.
 */
function tema_viera_posts_admin_columns_content( $column, $post_id ) {
	if ( 'traduccion' !== $column ) {
		return;
	}
	if ( ! function_exists( 'tema_viera_post_translation_status' ) ) {
		echo '-';
		return;
	}
	$status = tema_viera_post_translation_status( $post_id );
	if ( null === $status ) {
		echo '-';
		return;
	}

	$enlace = function_exists( 'tema_viera_post_translation_url' )
		? tema_viera_post_translation_url( $post_id )
		: '';
	if ( $enlace ) {
		echo '<a href="' . esc_url( $enlace ) . '">' . esc_html__( 'Traducir', 'tema-viera-abogados' ) . '</a> ';
	}

	if ( $status['total'] > 0 ) {
		$completo = ( $status['done'] >= $status['total'] );
		echo '<span style="color:' . ( $completo ? '#46b450' : '#dba617' ) . ';">'
			. esc_html( $status['done'] . '/' . $status['total'] )
			. '</span>';
	} else {
		echo '-';
	}
}
add_action( 'manage_posts_custom_column', 'tema_viera_posts_admin_columns_content', 10, 2 );
