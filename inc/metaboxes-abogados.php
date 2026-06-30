<?php
/**
 * Meta Boxes para el CPT Abogados
 *
 * Define los meta boxes nativos de WordPress para capturar información
 * adicional de cada abogado (especialidad, contacto, biografía, etc.)
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registrar el meta box para información del abogado
 */
function tema_viera_register_abogado_metabox() {
	add_meta_box(
		'tema_viera_abogado_info',
		esc_html__( 'Información del Abogado', 'tema-viera-abogados' ),
		'tema_viera_render_abogado_metabox',
		'abogado',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'tema_viera_register_abogado_metabox' );

/**
 * Renderizar el formulario del meta box de abogados
 *
 * @param WP_Post $post El objeto del post actual
 */
function tema_viera_render_abogado_metabox( $post ) {
	// Verificar nonce por seguridad (se verifica al guardar)
	wp_nonce_field( 'tema_viera_abogado_nonce', 'tema_viera_abogado_nonce_field' );

	// Obtener los valores guardados previamente
	$especialidad = tema_viera_get_abogado_meta( $post->ID, 'especialidad' );
	$email        = tema_viera_get_abogado_meta( $post->ID, 'email' );
	$telefono     = tema_viera_get_abogado_meta( $post->ID, 'telefono' );
	$linkedin     = tema_viera_get_abogado_meta( $post->ID, 'linkedin' );
	$biografia    = tema_viera_get_abogado_meta( $post->ID, 'biografia' );

	?>
	<div class="mi-tema-abogado-metabox">
		<style>
			.mi-tema-abogado-metabox {
				margin: 0;
			}
			.mi-tema-abogado-field {
				margin-bottom: 20px;
			}
			.mi-tema-abogado-field label {
				display: block;
				margin-bottom: 5px;
				font-weight: 600;
				color: #333;
			}
			.mi-tema-abogado-field input,
			.mi-tema-abogado-field textarea {
				width: 100%;
				padding: 8px;
				border: 1px solid #ddd;
				border-radius: 4px;
				font-family: inherit;
			}
			.mi-tema-abogado-field input:focus,
			.mi-tema-abogado-field textarea:focus {
				outline: none;
				border-color: #d4af37;
				box-shadow: 0 0 5px rgba(212, 175, 55, 0.3);
			}
			.mi-tema-abogado-field textarea {
				min-height: 120px;
				resize: vertical;
			}
			.mi-tema-help-text {
				font-size: 12px;
				color: #999;
				margin-top: 3px;
			}
		</style>

		<!-- Campo: Especialidad -->
		<div class="mi-tema-abogado-field">
			<label for="tema_viera_especialidad">
				<?php esc_html_e( 'Especialidad', 'tema-viera-abogados' ); ?>
			</label>
			<input
				type="text"
				id="tema_viera_especialidad"
				name="tema_viera_especialidad"
				value="<?php echo esc_attr( $especialidad ); ?>"
				placeholder="<?php esc_attr_e( 'Ej: Derecho Mercantil', 'tema-viera-abogados' ); ?>"
			/>
			<div class="mi-tema-help-text">
				<?php esc_html_e( 'Especialidad legal del abogado', 'tema-viera-abogados' ); ?>
			</div>
		</div>

		<!-- Campo: Email -->
		<div class="mi-tema-abogado-field">
			<label for="tema_viera_email">
				<?php esc_html_e( 'Email', 'tema-viera-abogados' ); ?>
			</label>
			<input
				type="email"
				id="tema_viera_email"
				name="tema_viera_email"
				value="<?php echo esc_attr( $email ); ?>"
				placeholder="<?php esc_attr_e( 'correo@estudio.com', 'tema-viera-abogados' ); ?>"
			/>
			<div class="mi-tema-help-text">
				<?php esc_html_e( 'Email de contacto del abogado', 'tema-viera-abogados' ); ?>
			</div>
		</div>

		<!-- Campo: Teléfono -->
		<div class="mi-tema-abogado-field">
			<label for="tema_viera_telefono">
				<?php esc_html_e( 'Teléfono', 'tema-viera-abogados' ); ?>
			</label>
			<input
				type="text"
				id="tema_viera_telefono"
				name="tema_viera_telefono"
				value="<?php echo esc_attr( $telefono ); ?>"
				placeholder="<?php esc_attr_e( '+34 900 123 456', 'tema-viera-abogados' ); ?>"
			/>
			<div class="mi-tema-help-text">
				<?php esc_html_e( 'Teléfono de contacto', 'tema-viera-abogados' ); ?>
			</div>
		</div>

		<!-- Campo: LinkedIn -->
		<div class="mi-tema-abogado-field">
			<label for="tema_viera_linkedin">
				<?php esc_html_e( 'Perfil LinkedIn', 'tema-viera-abogados' ); ?>
			</label>
			<input
				type="url"
				id="tema_viera_linkedin"
				name="tema_viera_linkedin"
				value="<?php echo esc_attr( $linkedin ); ?>"
				placeholder="<?php esc_attr_e( 'https://linkedin.com/in/nombre', 'tema-viera-abogados' ); ?>"
			/>
			<div class="mi-tema-help-text">
				<?php esc_html_e( 'URL del perfil LinkedIn (opcional)', 'tema-viera-abogados' ); ?>
			</div>
		</div>

		<!-- Campo: Biografía (Editor Enriquecido) -->
		<div class="mi-tema-abogado-field">
			<label for="tema_viera_biografia">
				<?php esc_html_e( 'Biografía', 'tema-viera-abogados' ); ?>
			</label>
			<?php
			wp_editor(
				wp_kses_post( $biografia ),
				'tema_viera_biografia',
				array(
					'textarea_name' => 'tema_viera_biografia',
					'media_buttons' => true,
					'teeny'         => false,
					'tinymce'       => array(
						'toolbar1' => 'bold,italic,underline,strikethrough,separator,bullist,numlist,blockquote,separator,link,unlink,separator,undo,redo',
					),
				)
			);
			?>
			<div class="mi-tema-help-text">
				<?php esc_html_e( 'Biografía detallada del abogado', 'tema-viera-abogados' ); ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Guardar los valores del meta box de abogados
 *
 * @param int $post_id ID del post que se está guardando
 */
function tema_viera_save_abogado_metabox( $post_id ) {
	// Verificar autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Verificar nonce
	if ( ! isset( $_POST['tema_viera_abogado_nonce_field'] ) ||
		 ! wp_verify_nonce( $_POST['tema_viera_abogado_nonce_field'], 'tema_viera_abogado_nonce' ) ) {
		return;
	}

	// Verificar permisos del usuario
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Procesar y guardar especialidad
	if ( isset( $_POST['tema_viera_especialidad'] ) ) {
		$especialidad = sanitize_text_field( $_POST['tema_viera_especialidad'] );
		update_post_meta( $post_id, '_abogado_especialidad', $especialidad );
	}

	// Procesar y guardar email
	if ( isset( $_POST['tema_viera_email'] ) ) {
		$email = sanitize_email( $_POST['tema_viera_email'] );
		update_post_meta( $post_id, '_abogado_email', $email );
	}

	// Procesar y guardar teléfono
	if ( isset( $_POST['tema_viera_telefono'] ) ) {
		$telefono = sanitize_text_field( $_POST['tema_viera_telefono'] );
		update_post_meta( $post_id, '_abogado_telefono', $telefono );
	}

	// Procesar y guardar LinkedIn
	if ( isset( $_POST['tema_viera_linkedin'] ) ) {
		$linkedin = esc_url_raw( $_POST['tema_viera_linkedin'] );
		update_post_meta( $post_id, '_abogado_linkedin', $linkedin );
	}

	// Procesar y guardar biografía (permitir HTML básico)
	if ( isset( $_POST['tema_viera_biografia'] ) ) {
		$biografia = wp_kses_post( $_POST['tema_viera_biografia'] );
		update_post_meta( $post_id, '_abogado_biografia', $biografia );
	}
}
add_action( 'save_post_abogado', 'tema_viera_save_abogado_metabox' );

/**
 * Agregar columnas personalizadas al listado de abogados en el admin
 *
 * @param array $columns Columnas existentes
 * @return array Columnas modificadas
 */
function tema_viera_abogados_admin_columns( $columns ) {
	// Insertar nuevas columnas después del título
	$new_columns = array();
	foreach ( $columns as $key => $value ) {
		$new_columns[ $key ] = $value;
		if ( 'title' === $key ) {
			$new_columns['especialidad'] = esc_html__( 'Especialidad', 'tema-viera-abogados' );
			$new_columns['email']        = esc_html__( 'Email', 'tema-viera-abogados' );
		}
	}
	return $new_columns;
}
add_filter( 'manage_abogado_posts_columns', 'tema_viera_abogados_admin_columns' );

/**
 * Renderizar el contenido de las columnas personalizadas
 *
 * @param string $column El nombre de la columna
 * @param int $post_id ID del post
 */
function tema_viera_abogados_admin_columns_content( $column, $post_id ) {
	switch ( $column ) {
		case 'especialidad':
			$especialidad = tema_viera_get_abogado_meta( $post_id, 'especialidad' );
			echo esc_html( $especialidad ? $especialidad : '-' );
			break;

		case 'email':
			$email = tema_viera_get_abogado_meta( $post_id, 'email' );
			if ( $email ) {
				echo '<a href="' . esc_attr( 'mailto:' . $email ) . '">' . esc_html( $email ) . '</a>';
			} else {
				echo '-';
			}
			break;
	}
}
add_action( 'manage_abogado_posts_custom_column', 'tema_viera_abogados_admin_columns_content', 10, 2 );

/**
 * Hacer que las columnas del listado de abogados sean ordenables
 *
 * @param array $sortable Columnas ordenables
 * @return array Columnas modificadas
 */
function tema_viera_abogados_sortable_columns( $sortable ) {
	$sortable['especialidad'] = 'especialidad';
	return $sortable;
}
add_filter( 'manage_edit-abogado_sortable_columns', 'tema_viera_abogados_sortable_columns' );
