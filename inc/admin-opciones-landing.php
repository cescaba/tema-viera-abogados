<?php
/**
 * Panel de Opciones de Landing Page
 *
 * Crea un menú personalizado en el admin para editar todo el contenido
 * de la landing page sin tocar código.
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registrar el menú de opciones en el admin
 */
function tema_viera_add_admin_menu() {
	add_menu_page(
		esc_html__( 'Opciones Landing', 'tema-viera-abogados' ),
		esc_html__( 'Opciones Landing', 'tema-viera-abogados' ),
		'manage_options',
		'mi-tema-opciones-landing',
		'tema_viera_opciones_landing_page',
		'dashicons-admin-customizer',
		25
	);
}
add_action( 'admin_menu', 'tema_viera_add_admin_menu' );

/**
 * Registrar las opciones para que WordPress las gestione correctamente
 */
function tema_viera_register_settings() {
	// Opciones de Hero
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_hero_titulo'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_hero_subtitulo'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_hero_imagen'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_hero_btn_texto'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_hero_btn_url'
	);

	// Opciones de Sobre Nosotros
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_sobre_titulo'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_sobre_contenido'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_sobre_imagen'
	);

	// Opciones de Servicios
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_servicios_titulo'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_servicios_items'
	);

	// Opciones de Sección Abogados
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_abogados_titulo'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_abogados_subtitulo'
	);

	// Opciones de Contacto
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_contacto_titulo'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_contacto_direccion'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_contacto_telefono'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_contacto_email'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_contacto_mensaje'
	);
}
add_action( 'admin_init', 'tema_viera_register_settings' );

/**
 * Renderizar la página de opciones
 */
function tema_viera_opciones_landing_page() {
	// Verificar permisos
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'No tienes permiso para acceder a esta página.', 'tema-viera-abogados' ) );
	}

	// Guardar si se envió el formulario
	if ( isset( $_POST['submit'] ) && isset( $_POST['tema_viera_opciones_landing_nonce'] ) ) {
		if ( wp_verify_nonce( $_POST['tema_viera_opciones_landing_nonce'], 'tema_viera_opciones_landing_action' ) ) {
			tema_viera_procesar_opciones_landing();
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Opciones guardadas correctamente.', 'tema-viera-abogados' ) . '</p></div>';
		}
	}

	// Obtener valores actuales
	$hero_titulo           = get_option( 'tema_viera_abogados_hero_titulo', '' );
	$hero_subtitulo        = get_option( 'tema_viera_abogados_hero_subtitulo', '' );
	$hero_imagen_id        = get_option( 'tema_viera_abogados_hero_imagen', '' );
	$hero_btn_texto        = get_option( 'tema_viera_abogados_hero_btn_texto', '' );
	$hero_btn_url          = get_option( 'tema_viera_abogados_hero_btn_url', '' );

	$sobre_titulo          = get_option( 'tema_viera_abogados_sobre_titulo', '' );
	$sobre_contenido       = get_option( 'tema_viera_abogados_sobre_contenido', '' );
	$sobre_imagen_id       = get_option( 'tema_viera_abogados_sobre_imagen', '' );

	$servicios_titulo      = get_option( 'tema_viera_abogados_servicios_titulo', '' );
	$servicios_items       = get_option( 'tema_viera_abogados_servicios_items', array() );

	$abogados_titulo       = get_option( 'tema_viera_abogados_abogados_titulo', '' );
	$abogados_subtitulo    = get_option( 'tema_viera_abogados_abogados_subtitulo', '' );

	$contacto_titulo       = get_option( 'tema_viera_abogados_contacto_titulo', '' );
	$contacto_direccion    = get_option( 'tema_viera_abogados_contacto_direccion', '' );
	$contacto_telefono     = get_option( 'tema_viera_abogados_contacto_telefono', '' );
	$contacto_email        = get_option( 'tema_viera_abogados_contacto_email', '' );
	$contacto_mensaje      = get_option( 'tema_viera_abogados_contacto_mensaje', '' );

	// Obtener URLs de imágenes si existen
	$hero_imagen_url = $hero_imagen_id ? wp_get_attachment_url( $hero_imagen_id ) : '';
	$sobre_imagen_url = $sobre_imagen_id ? wp_get_attachment_url( $sobre_imagen_id ) : '';
	?>

	<div class="wrap">
		<h1><?php esc_html_e( 'Opciones de Landing Page', 'tema-viera-abogados' ); ?></h1>

		<form method="post" id="mi-tema-opciones-form">
			<?php wp_nonce_field( 'tema_viera_opciones_landing_action', 'tema_viera_opciones_landing_nonce' ); ?>

			<style>
				.mi-tema-form-section {
					background: #fff;
					padding: 20px;
					margin: 20px 0;
					border: 1px solid #e0e0e0;
					border-radius: 4px;
				}
				.mi-tema-form-section h2 {
					margin-top: 0;
					color: #1a3a52;
					border-bottom: 2px solid #d4af37;
					padding-bottom: 10px;
				}
				.mi-tema-form-group {
					margin-bottom: 20px;
				}
				.mi-tema-form-group label {
					display: block;
					margin-bottom: 5px;
					font-weight: 600;
					color: #333;
				}
				.mi-tema-form-group input[type="text"],
				.mi-tema-form-group input[type="email"],
				.mi-tema-form-group input[type="url"],
				.mi-tema-form-group textarea {
					width: 100%;
					max-width: 500px;
					padding: 8px;
					border: 1px solid #ddd;
					border-radius: 4px;
				}
				.mi-tema-form-group textarea {
					min-height: 100px;
					resize: vertical;
					max-width: 100%;
				}
				.mi-tema-image-preview {
					margin-top: 10px;
					max-width: 300px;
				}
				.mi-tema-image-preview img {
					max-width: 100%;
					height: auto;
					border-radius: 4px;
				}
				.mi-tema-btn-upload {
					background: #0073aa;
					color: white;
					padding: 8px 16px;
					border-radius: 4px;
					cursor: pointer;
					border: none;
					font-size: 14px;
					margin-right: 10px;
				}
				.mi-tema-btn-upload:hover {
					background: #005a87;
				}
				.mi-tema-btn-remove {
					background: #dc3545;
					color: white;
					padding: 8px 16px;
					border-radius: 4px;
					cursor: pointer;
					border: none;
					font-size: 14px;
				}
				.mi-tema-btn-remove:hover {
					background: #c82333;
				}
				.mi-tema-servicios-container {
					background: #f9f9f9;
					padding: 20px;
					border-radius: 4px;
					border-left: 4px solid #d4af37;
				}
				.mi-tema-servicio-item {
					background: #fff;
					padding: 15px;
					margin-bottom: 15px;
					border-radius: 4px;
					border: 1px solid #ddd;
					position: relative;
				}
				.mi-tema-servicio-item .btn-remove-servicio {
					position: absolute;
					top: 10px;
					right: 10px;
					background: #dc3545;
					color: white;
					border: none;
					padding: 5px 10px;
					border-radius: 3px;
					cursor: pointer;
					font-size: 12px;
				}
				.mi-tema-servicio-item .btn-remove-servicio:hover {
					background: #c82333;
				}
				.submit {
					margin-top: 30px;
				}
				.submit button {
					background: #1a3a52;
					color: white;
					padding: 12px 30px;
					border: none;
					border-radius: 4px;
					cursor: pointer;
					font-size: 16px;
					font-weight: 600;
				}
				.submit button:hover {
					background: #0f1419;
				}
			</style>

			<!-- SECCIÓN HERO -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección Hero', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="hero_titulo"><?php esc_html_e( 'Título Principal', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="hero_titulo" name="hero_titulo" value="<?php echo esc_attr( $hero_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="hero_subtitulo"><?php esc_html_e( 'Subtítulo / Descripción', 'tema-viera-abogados' ); ?></label>
					<textarea id="hero_subtitulo" name="hero_subtitulo"><?php echo esc_textarea( $hero_subtitulo ); ?></textarea>
				</div>

				<div class="mi-tema-form-group">
					<label><?php esc_html_e( 'Imagen de Fondo', 'tema-viera-abogados' ); ?></label>
					<input type="hidden" id="hero_imagen" name="hero_imagen" value="<?php echo esc_attr( $hero_imagen_id ); ?>" />
					<button type="button" class="mi-tema-btn-upload" onclick="tema_viera_upload_media('hero_imagen')">
						<?php esc_html_e( 'Seleccionar Imagen', 'tema-viera-abogados' ); ?>
					</button>
					<?php if ( $hero_imagen_url ) : ?>
						<button type="button" class="mi-tema-btn-remove" onclick="tema_viera_remove_media('hero_imagen')">
							<?php esc_html_e( 'Eliminar Imagen', 'tema-viera-abogados' ); ?>
						</button>
						<div class="mi-tema-image-preview">
							<img id="hero_imagen_preview" src="<?php echo esc_url( $hero_imagen_url ); ?>" alt="" />
						</div>
					<?php endif; ?>
				</div>

				<div class="mi-tema-form-group">
					<label for="hero_btn_texto"><?php esc_html_e( 'Texto del Botón CTA', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="hero_btn_texto" name="hero_btn_texto" value="<?php echo esc_attr( $hero_btn_texto ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="hero_btn_url"><?php esc_html_e( 'URL del Botón CTA', 'tema-viera-abogados' ); ?></label>
					<input type="url" id="hero_btn_url" name="hero_btn_url" value="<?php echo esc_attr( $hero_btn_url ); ?>" />
				</div>
			</div>

			<!-- SECCIÓN SOBRE NOSOTROS -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección Sobre Nosotros', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="sobre_titulo"><?php esc_html_e( 'Título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="sobre_titulo" name="sobre_titulo" value="<?php echo esc_attr( $sobre_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="sobre_contenido"><?php esc_html_e( 'Contenido', 'tema-viera-abogados' ); ?></label>
					<?php
					wp_editor(
						wp_kses_post( $sobre_contenido ),
						'sobre_contenido',
						array(
							'textarea_name' => 'sobre_contenido',
							'media_buttons' => true,
							'teeny'         => false,
						)
					);
					?>
				</div>

				<div class="mi-tema-form-group">
					<label><?php esc_html_e( 'Imagen', 'tema-viera-abogados' ); ?></label>
					<input type="hidden" id="sobre_imagen" name="sobre_imagen" value="<?php echo esc_attr( $sobre_imagen_id ); ?>" />
					<button type="button" class="mi-tema-btn-upload" onclick="tema_viera_upload_media('sobre_imagen')">
						<?php esc_html_e( 'Seleccionar Imagen', 'tema-viera-abogados' ); ?>
					</button>
					<?php if ( $sobre_imagen_url ) : ?>
						<button type="button" class="mi-tema-btn-remove" onclick="tema_viera_remove_media('sobre_imagen')">
							<?php esc_html_e( 'Eliminar Imagen', 'tema-viera-abogados' ); ?>
						</button>
						<div class="mi-tema-image-preview">
							<img id="sobre_imagen_preview" src="<?php echo esc_url( $sobre_imagen_url ); ?>" alt="" />
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- SECCIÓN SERVICIOS -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección Servicios', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="servicios_titulo"><?php esc_html_e( 'Título de la Sección', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="servicios_titulo" name="servicios_titulo" value="<?php echo esc_attr( $servicios_titulo ); ?>" />
				</div>

				<div class="mi-tema-servicios-container">
					<p><strong><?php esc_html_e( 'Servicios (Máximo 6)', 'tema-viera-abogados' ); ?></strong></p>
					<div id="servicios-list">
						<?php
						if ( ! empty( $servicios_items ) && is_array( $servicios_items ) ) {
							foreach ( $servicios_items as $index => $servicio ) {
								tema_viera_render_servicio_item( $index, $servicio );
							}
						}
						?>
					</div>

					<?php
					$current_count = ! empty( $servicios_items ) ? count( $servicios_items ) : 0;
					if ( $current_count < 6 ) {
						?>
						<button type="button" id="btn-add-servicio" class="button button-primary">
							<?php esc_html_e( '+ Agregar Servicio', 'tema-viera-abogados' ); ?>
						</button>
						<?php
					}
					?>
				</div>
			</div>

			<!-- SECCIÓN ABOGADOS -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección Listado de Abogados', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="abogados_titulo"><?php esc_html_e( 'Título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="abogados_titulo" name="abogados_titulo" value="<?php echo esc_attr( $abogados_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="abogados_subtitulo"><?php esc_html_e( 'Subtítulo', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="abogados_subtitulo" name="abogados_subtitulo" value="<?php echo esc_attr( $abogados_subtitulo ); ?>" />
				</div>
			</div>

			<!-- SECCIÓN CONTACTO -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección Contacto', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="contacto_titulo"><?php esc_html_e( 'Título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="contacto_titulo" name="contacto_titulo" value="<?php echo esc_attr( $contacto_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="contacto_direccion"><?php esc_html_e( 'Dirección', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="contacto_direccion" name="contacto_direccion" value="<?php echo esc_attr( $contacto_direccion ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="contacto_telefono"><?php esc_html_e( 'Teléfono', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="contacto_telefono" name="contacto_telefono" value="<?php echo esc_attr( $contacto_telefono ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="contacto_email"><?php esc_html_e( 'Email', 'tema-viera-abogados' ); ?></label>
					<input type="email" id="contacto_email" name="contacto_email" value="<?php echo esc_attr( $contacto_email ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="contacto_mensaje"><?php esc_html_e( 'Mensaje o Descripción', 'tema-viera-abogados' ); ?></label>
					<textarea id="contacto_mensaje" name="contacto_mensaje"><?php echo esc_textarea( $contacto_mensaje ); ?></textarea>
				</div>
			</div>

			<div class="submit">
				<button type="submit" name="submit" class="button button-primary button-large">
					<?php esc_html_e( 'Guardar Cambios', 'tema-viera-abogados' ); ?>
				</button>
			</div>
		</form>
	</div>

	<script>
		// Variable global para rastrear el índice de servicios
		var servicioIndex = <?php echo isset( $servicios_items ) ? count( (array) $servicios_items ) : 0; ?>;

		// Agregar un nuevo servicio dinámicamente
		document.getElementById('btn-add-servicio').addEventListener('click', function( e ) {
			e.preventDefault();
			var container = document.getElementById('servicios-list');
			var html = `
				<div class="mi-tema-servicio-item" data-index="${servicioIndex}">
					<button type="button" class="btn-remove-servicio" onclick="removeServicio(${servicioIndex})">Eliminar</button>
					<div style="margin-bottom: 10px;">
						<label>Título del Servicio</label>
						<input type="text" name="servicios[${servicioIndex}][titulo]" value="" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
					</div>
					<div style="margin-bottom: 10px;">
						<label>Descripción</label>
						<textarea name="servicios[${servicioIndex}][descripcion]" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-height: 80px;"></textarea>
					</div>
					<div>
						<label>Icono (emoji o clase)</label>
						<input type="text" name="servicios[${servicioIndex}][icono]" placeholder="⚖️ o fa-balance-scale" value="" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
					</div>
				</div>
			`;
			container.insertAdjacentHTML('beforeend', html);
			servicioIndex++;

			// Deshabilitar botón si hay 6 servicios
			if ( container.querySelectorAll('.mi-tema-servicio-item').length >= 6 ) {
				document.getElementById('btn-add-servicio').style.display = 'none';
			}
		});

		// Remover un servicio
		function removeServicio( index ) {
			var item = document.querySelector('[data-index="' + index + '"]');
			if ( item ) {
				item.remove();
				var btn = document.getElementById('btn-add-servicio');
				if ( btn && document.getElementById('servicios-list').querySelectorAll('.mi-tema-servicio-item').length < 6 ) {
					btn.style.display = 'inline-block';
				}
			}
		}

		// Función para subir medios
		var miTemaMediaFrame;
		function tema_viera_upload_media( fieldId ) {
			if ( miTemaMediaFrame ) {
				miTemaMediaFrame.open();
				return;
			}

			miTemaMediaFrame = wp.media({
				title: '<?php esc_html_e( 'Seleccionar Imagen', 'tema-viera-abogados' ); ?>',
				button: { text: '<?php esc_html_e( 'Usar esta imagen', 'tema-viera-abogados' ); ?>' },
				multiple: false,
				library: { type: 'image' }
			});

			miTemaMediaFrame.on( 'select', function() {
				var attachment = miTemaMediaFrame.state().get('selection').first().toJSON();
				document.getElementById( fieldId ).value = attachment.id;
				document.getElementById( fieldId + '_preview' ).src = attachment.url;
				document.getElementById( fieldId + '_preview' ).parentElement.style.display = 'block';
			});

			miTemaMediaFrame.open();
		}

		// Función para remover imagen
		function tema_viera_remove_media( fieldId ) {
			document.getElementById( fieldId ).value = '';
			var preview = document.getElementById( fieldId + '_preview' );
			if ( preview ) {
				preview.parentElement.style.display = 'none';
			}
		}
	</script>
	<?php
}

/**
 * Renderizar un item individual de servicio
 *
 * @param int $index Índice del servicio
 * @param array $servicio Datos del servicio
 */
function tema_viera_render_servicio_item( $index, $servicio ) {
	$titulo      = isset( $servicio['titulo'] ) ? $servicio['titulo'] : '';
	$descripcion = isset( $servicio['descripcion'] ) ? $servicio['descripcion'] : '';
	$icono       = isset( $servicio['icono'] ) ? $servicio['icono'] : '';
	?>
	<div class="mi-tema-servicio-item" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="btn-remove-servicio" onclick="removeServicio(<?php echo esc_attr( $index ); ?>)">
			<?php esc_html_e( 'Eliminar', 'tema-viera-abogados' ); ?>
		</button>
		<div style="margin-bottom: 10px;">
			<label><?php esc_html_e( 'Título del Servicio', 'tema-viera-abogados' ); ?></label>
			<input type="text" name="servicios[<?php echo esc_attr( $index ); ?>][titulo]" value="<?php echo esc_attr( $titulo ); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
		</div>
		<div style="margin-bottom: 10px;">
			<label><?php esc_html_e( 'Descripción', 'tema-viera-abogados' ); ?></label>
			<textarea name="servicios[<?php echo esc_attr( $index ); ?>][descripcion]" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-height: 80px;"><?php echo esc_textarea( $descripcion ); ?></textarea>
		</div>
		<div>
			<label><?php esc_html_e( 'Icono (emoji o clase)', 'tema-viera-abogados' ); ?></label>
			<input type="text" name="servicios[<?php echo esc_attr( $index ); ?>][icono]" placeholder="⚖️ o fa-balance-scale" value="<?php echo esc_attr( $icono ); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
		</div>
	</div>
	<?php
}

/**
 * Procesar y guardar las opciones de la landing
 */
function tema_viera_procesar_opciones_landing() {
	// Verificar permisos
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Procesar Hero
	if ( isset( $_POST['hero_titulo'] ) ) {
		update_option( 'tema_viera_abogados_hero_titulo', sanitize_text_field( $_POST['hero_titulo'] ) );
	}
	if ( isset( $_POST['hero_subtitulo'] ) ) {
		update_option( 'tema_viera_abogados_hero_subtitulo', wp_kses_post( $_POST['hero_subtitulo'] ) );
	}
	if ( isset( $_POST['hero_imagen'] ) ) {
		update_option( 'tema_viera_abogados_hero_imagen', intval( $_POST['hero_imagen'] ) );
	}
	if ( isset( $_POST['hero_btn_texto'] ) ) {
		update_option( 'tema_viera_abogados_hero_btn_texto', sanitize_text_field( $_POST['hero_btn_texto'] ) );
	}
	if ( isset( $_POST['hero_btn_url'] ) ) {
		update_option( 'tema_viera_abogados_hero_btn_url', esc_url_raw( $_POST['hero_btn_url'] ) );
	}

	// Procesar Sobre Nosotros
	if ( isset( $_POST['sobre_titulo'] ) ) {
		update_option( 'tema_viera_abogados_sobre_titulo', sanitize_text_field( $_POST['sobre_titulo'] ) );
	}
	if ( isset( $_POST['sobre_contenido'] ) ) {
		update_option( 'tema_viera_abogados_sobre_contenido', wp_kses_post( $_POST['sobre_contenido'] ) );
	}
	if ( isset( $_POST['sobre_imagen'] ) ) {
		update_option( 'tema_viera_abogados_sobre_imagen', intval( $_POST['sobre_imagen'] ) );
	}

	// Procesar Servicios
	if ( isset( $_POST['servicios_titulo'] ) ) {
		update_option( 'tema_viera_abogados_servicios_titulo', sanitize_text_field( $_POST['servicios_titulo'] ) );
	}
	if ( isset( $_POST['servicios'] ) ) {
		$servicios_items = array();
		foreach ( $_POST['servicios'] as $servicio ) {
			$servicios_items[] = array(
				'titulo'      => sanitize_text_field( $servicio['titulo'] ),
				'descripcion' => wp_kses_post( $servicio['descripcion'] ),
				'icono'       => sanitize_text_field( $servicio['icono'] ),
			);
		}
		update_option( 'tema_viera_abogados_servicios_items', $servicios_items );
	}

	// Procesar Abogados
	if ( isset( $_POST['abogados_titulo'] ) ) {
		update_option( 'tema_viera_abogados_abogados_titulo', sanitize_text_field( $_POST['abogados_titulo'] ) );
	}
	if ( isset( $_POST['abogados_subtitulo'] ) ) {
		update_option( 'tema_viera_abogados_abogados_subtitulo', sanitize_text_field( $_POST['abogados_subtitulo'] ) );
	}

	// Procesar Contacto
	if ( isset( $_POST['contacto_titulo'] ) ) {
		update_option( 'tema_viera_abogados_contacto_titulo', sanitize_text_field( $_POST['contacto_titulo'] ) );
	}
	if ( isset( $_POST['contacto_direccion'] ) ) {
		update_option( 'tema_viera_abogados_contacto_direccion', sanitize_text_field( $_POST['contacto_direccion'] ) );
	}
	if ( isset( $_POST['contacto_telefono'] ) ) {
		update_option( 'tema_viera_abogados_contacto_telefono', sanitize_text_field( $_POST['contacto_telefono'] ) );
	}
	if ( isset( $_POST['contacto_email'] ) ) {
		update_option( 'tema_viera_abogados_contacto_email', sanitize_email( $_POST['contacto_email'] ) );
	}
	if ( isset( $_POST['contacto_mensaje'] ) ) {
		update_option( 'tema_viera_abogados_contacto_mensaje', wp_kses_post( $_POST['contacto_mensaje'] ) );
	}
}
