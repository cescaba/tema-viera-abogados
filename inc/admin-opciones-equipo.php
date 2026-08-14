<?php
/**
 * Panel de Opciones de Página Equipo
 *
 * Crea un menú independiente en el admin para editar
 * el contenido de la página "Equipo" (template).
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function tema_viera_add_admin_menu_equipo() {
	add_menu_page(
		esc_html__( 'Opciones Equipo', 'tema-viera-abogados' ),
		esc_html__( 'Opciones Equipo', 'tema-viera-abogados' ),
		'manage_options',
		'mi-tema-opciones-equipo',
		'tema_viera_opciones_equipo_page',
		'dashicons-groups',
		26
	);
}
add_action( 'admin_menu', 'tema_viera_add_admin_menu_equipo' );

function tema_viera_equipo_admin_enqueue_scripts( $hook ) {
	if ( 'toplevel_page_mi-tema-opciones-equipo' !== $hook ) {
		return;
	}
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'tema_viera_equipo_admin_enqueue_scripts' );

function tema_viera_register_equipo_settings() {
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_perfil_pre' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_perfil_nombre' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_perfil_cargo' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_perfil_cita' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_perfil_cita_autor' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_perfil_pre_logos' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_perfil_img' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_perfil_logos' );

	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_detalle_pre' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_detalle_titulo' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_detalle_contenido' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_detalle_rec_titulo' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_sidebar_esp_titulo' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_sidebar_esp_items' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_sidebar_mem_titulo' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_sidebar_mem_items' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_sidebar_correo_tit' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_sidebar_correo' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_sidebar_linkedin' );

	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_equipo_grid_tit' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_equipo_grid_desc' );
	register_setting( 'tema_viera_opciones_equipo', 'tema_viera_abogados_equipo_grid_ids' );
}
add_action( 'admin_init', 'tema_viera_register_equipo_settings' );

function tema_viera_opciones_equipo_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'No tienes permiso para acceder a esta página.', 'tema-viera-abogados' ) );
	}

	if ( isset( $_POST['submit'] ) && isset( $_POST['tema_viera_opciones_equipo_nonce'] ) ) {
		if ( wp_verify_nonce( $_POST['tema_viera_opciones_equipo_nonce'], 'tema_viera_opciones_equipo_action' ) ) {
			tema_viera_procesar_opciones_equipo();
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Opciones guardadas correctamente.', 'tema-viera-abogados' ) . '</p></div>';
		}
	}

	$perfil_pre_titulo    = get_option( 'tema_viera_abogados_perfil_pre', '' );
	$perfil_nombre        = get_option( 'tema_viera_abogados_perfil_nombre', '' );
	$perfil_cargo         = get_option( 'tema_viera_abogados_perfil_cargo', '' );
	$perfil_cita          = get_option( 'tema_viera_abogados_perfil_cita', '' );
	$perfil_cita_autor    = get_option( 'tema_viera_abogados_perfil_cita_autor', '' );
	$perfil_pre_logos     = get_option( 'tema_viera_abogados_perfil_pre_logos', '' );
	$perfil_img_id        = get_option( 'tema_viera_abogados_perfil_img', '' );
	$perfil_logos_ids     = get_option( 'tema_viera_abogados_perfil_logos', array() );
	$perfil_img_url       = $perfil_img_id ? wp_get_attachment_url( $perfil_img_id ) : '';

	$detalle_pre_titulo   = get_option( 'tema_viera_abogados_detalle_pre', '' );
	$detalle_titulo       = get_option( 'tema_viera_abogados_detalle_titulo', '' );
	$detalle_contenido    = get_option( 'tema_viera_abogados_detalle_contenido', '' );
	$detalle_rec_titulo   = get_option( 'tema_viera_abogados_detalle_rec_titulo', '' );

	$sidebar_esp_titulo   = get_option( 'tema_viera_abogados_sidebar_esp_titulo', '' );
	$sidebar_esp_items    = get_option( 'tema_viera_abogados_sidebar_esp_items', array() );
	$sidebar_mem_titulo   = get_option( 'tema_viera_abogados_sidebar_mem_titulo', '' );
	$sidebar_mem_items    = get_option( 'tema_viera_abogados_sidebar_mem_items', array() );
	$sidebar_correo_tit   = get_option( 'tema_viera_abogados_sidebar_correo_tit', '' );
	$sidebar_correo       = get_option( 'tema_viera_abogados_sidebar_correo', '' );
	$sidebar_linkedin     = get_option( 'tema_viera_abogados_sidebar_linkedin', '' );

	$equipo_grid_titulo   = get_option( 'tema_viera_abogados_equipo_grid_tit', '' );
	$equipo_grid_desc     = get_option( 'tema_viera_abogados_equipo_grid_desc', '' );
	$equipo_grid_ids      = get_option( 'tema_viera_abogados_equipo_grid_ids', array() );
	?>

	<div class="wrap">
		<h1><?php esc_html_e( 'Opciones de Página Equipo', 'tema-viera-abogados' ); ?></h1>
		<?php tema_viera_translation_button( 'Página Equipo' ); ?>

		<form method="post" id="mi-tema-opciones-equipo-form">
			<?php wp_nonce_field( 'tema_viera_opciones_equipo_action', 'tema_viera_opciones_equipo_nonce' ); ?>

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
				.mi-tema-btn-upload:hover { background: #005a87; }
				.mi-tema-btn-remove {
					background: #dc3545;
					color: white;
					padding: 8px 16px;
					border-radius: 4px;
					cursor: pointer;
					border: none;
					font-size: 14px;
				}
				.mi-tema-btn-remove:hover { background: #c82333; }
				.submit { margin-top: 30px; }
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
				.submit button:hover { background: #0f1419; }
			</style>

			<!-- HERO PERFIL -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Hero — Perfil Principal', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="perfil_pre_titulo"><?php esc_html_e( 'Pre-título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="perfil_pre_titulo" name="perfil_pre_titulo" value="<?php echo esc_attr( $perfil_pre_titulo ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="perfil_nombre"><?php esc_html_e( 'Nombre (acepta HTML como &lt;br&gt;)', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="perfil_nombre" name="perfil_nombre" value="<?php echo esc_attr( $perfil_nombre ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="perfil_cargo"><?php esc_html_e( 'Cargo', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="perfil_cargo" name="perfil_cargo" value="<?php echo esc_attr( $perfil_cargo ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="perfil_cita"><?php esc_html_e( 'Cita / Testimonio', 'tema-viera-abogados' ); ?></label>
					<textarea id="perfil_cita" name="perfil_cita"><?php echo esc_textarea( $perfil_cita ); ?></textarea>
				</div>
				<div class="mi-tema-form-group">
					<label for="perfil_cita_autor"><?php esc_html_e( 'Autor de la cita', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="perfil_cita_autor" name="perfil_cita_autor" value="<?php echo esc_attr( $perfil_cita_autor ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="perfil_pre_logos"><?php esc_html_e( 'Texto sobre los logos', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="perfil_pre_logos" name="perfil_pre_logos" value="<?php echo esc_attr( $perfil_pre_logos ); ?>" />
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'Fotografía principal', 'tema-viera-abogados' ); ?></h3>
				<div class="mi-tema-form-group">
					<input type="hidden" id="perfil_img" name="perfil_img" value="<?php echo esc_attr( $perfil_img_id ); ?>" />
					<button type="button" class="mi-tema-btn-upload" onclick="eqUploadMedia('perfil_img')">
						<?php esc_html_e( 'Seleccionar Imagen', 'tema-viera-abogados' ); ?>
					</button>
					<?php if ( $perfil_img_url ) : ?>
						<button type="button" class="mi-tema-btn-remove" onclick="eqRemoveMedia('perfil_img')">
							<?php esc_html_e( 'Eliminar Imagen', 'tema-viera-abogados' ); ?>
						</button>
						<div class="mi-tema-image-preview">
							<img id="perfil_img_preview" src="<?php echo esc_url( $perfil_img_url ); ?>" alt="" />
						</div>
					<?php endif; ?>
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'Logos de Reconocimientos', 'tema-viera-abogados' ); ?></h3>
				<div class="mi-tema-form-group">
					<input type="hidden" id="perfil_logos" name="perfil_logos" value="<?php echo esc_attr( json_encode( $perfil_logos_ids ) ); ?>" />
					<button type="button" class="mi-tema-btn-upload" onclick="eqUploadPerfilLogos()">
						<?php esc_html_e( 'Seleccionar Imágenes', 'tema-viera-abogados' ); ?>
					</button>
					<div id="perfil-logos-preview" class="mi-tema-image-preview" style="display:<?php echo ! empty( $perfil_logos_ids ) ? 'flex' : 'none'; ?>; flex-wrap:wrap; gap:10px; margin-top:10px;">
						<?php if ( ! empty( $perfil_logos_ids ) && is_array( $perfil_logos_ids ) ) : ?>
							<?php foreach ( $perfil_logos_ids as $logo_id ) :
								$logo_url = wp_get_attachment_url( $logo_id );
								if ( $logo_url ) : ?>
									<div style="position:relative;display:inline-block;">
										<img src="<?php echo esc_url( $logo_url ); ?>" style="max-width:100px;height:auto;border-radius:4px;" />
										<button type="button" style="position:absolute;top:-5px;right:-5px;background:#dc3545;color:#fff;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:12px;line-height:20px;text-align:center;" onclick="eqRemovePerfilLogo(this)">&times;</button>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<!-- DETALLE Y SIDEBAR -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Detalle y Sidebar', 'tema-viera-abogados' ); ?></h2>

				<h3 style="color:#1a3a52;"><?php esc_html_e( 'Columna de Contenido', 'tema-viera-abogados' ); ?></h3>
				<div class="mi-tema-form-group">
					<label for="detalle_pre_titulo"><?php esc_html_e( 'Pre-título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="detalle_pre_titulo" name="detalle_pre_titulo" value="<?php echo esc_attr( $detalle_pre_titulo ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="detalle_titulo"><?php esc_html_e( 'Título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="detalle_titulo" name="detalle_titulo" value="<?php echo esc_attr( $detalle_titulo ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="detalle_contenido"><?php esc_html_e( 'Contenido (HTML permitido)', 'tema-viera-abogados' ); ?></label>
					<textarea id="detalle_contenido" name="detalle_contenido" style="min-height:200px;"><?php echo esc_textarea( $detalle_contenido ); ?></textarea>
				</div>
				<div class="mi-tema-form-group">
					<label for="detalle_rec_titulo"><?php esc_html_e( 'Título de Reconocimientos', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="detalle_rec_titulo" name="detalle_rec_titulo" value="<?php echo esc_attr( $detalle_rec_titulo ); ?>" />
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'Sidebar — Especialidades', 'tema-viera-abogados' ); ?></h3>
				<div class="mi-tema-form-group">
					<label for="sidebar_esp_titulo"><?php esc_html_e( 'Título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="sidebar_esp_titulo" name="sidebar_esp_titulo" value="<?php echo esc_attr( $sidebar_esp_titulo ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="sidebar_esp_items"><?php esc_html_e( 'Ítems (uno por línea)', 'tema-viera-abogados' ); ?></label>
					<textarea id="sidebar_esp_items" name="sidebar_esp_items" style="min-height:120px;"><?php
						if ( is_array( $sidebar_esp_items ) ) {
							echo esc_textarea( implode( "\n", $sidebar_esp_items ) );
						} else {
							echo esc_textarea( $sidebar_esp_items );
						}
					?></textarea>
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'Sidebar — Membresías', 'tema-viera-abogados' ); ?></h3>
				<div class="mi-tema-form-group">
					<label for="sidebar_mem_titulo"><?php esc_html_e( 'Título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="sidebar_mem_titulo" name="sidebar_mem_titulo" value="<?php echo esc_attr( $sidebar_mem_titulo ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="sidebar_mem_items"><?php esc_html_e( 'Ítems (uno por línea)', 'tema-viera-abogados' ); ?></label>
					<textarea id="sidebar_mem_items" name="sidebar_mem_items" style="min-height:100px;"><?php
						if ( is_array( $sidebar_mem_items ) ) {
							echo esc_textarea( implode( "\n", $sidebar_mem_items ) );
						} else {
							echo esc_textarea( $sidebar_mem_items );
						}
					?></textarea>
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'Sidebar — Contacto', 'tema-viera-abogados' ); ?></h3>
				<div class="mi-tema-form-group">
					<label for="sidebar_correo_tit"><?php esc_html_e( 'Título de Correo', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="sidebar_correo_tit" name="sidebar_correo_tit" value="<?php echo esc_attr( $sidebar_correo_tit ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="sidebar_correo"><?php esc_html_e( 'Correo electrónico', 'tema-viera-abogados' ); ?></label>
					<input type="email" id="sidebar_correo" name="sidebar_correo" value="<?php echo esc_attr( $sidebar_correo ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="sidebar_linkedin"><?php esc_html_e( 'LinkedIn URL', 'tema-viera-abogados' ); ?></label>
					<input type="url" id="sidebar_linkedin" name="sidebar_linkedin" value="<?php echo esc_attr( $sidebar_linkedin ); ?>" />
				</div>
			</div>

			<!-- GRILLA DE EQUIPO -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Grilla de Equipo', 'tema-viera-abogados' ); ?></h2>
				<p class="description" style="margin-bottom:15px;"><?php esc_html_e( 'Configura el título, descripción y selecciona qué abogados del CPT se muestran en la grilla.', 'tema-viera-abogados' ); ?></p>

				<div class="mi-tema-form-group">
					<label for="equipo_grid_tit"><?php esc_html_e( 'Título de la sección', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="equipo_grid_tit" name="equipo_grid_tit" value="<?php echo esc_attr( $equipo_grid_titulo ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="equipo_grid_desc"><?php esc_html_e( 'Descripción (HTML permitido)', 'tema-viera-abogados' ); ?></label>
					<textarea id="equipo_grid_desc" name="equipo_grid_desc" style="min-height:80px;"><?php echo esc_textarea( $equipo_grid_desc ); ?></textarea>
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'Abogados en la grilla', 'tema-viera-abogados' ); ?></h3>
				<p class="description" style="margin-bottom:15px;"><?php esc_html_e( 'Selecciona los abogados que aparecerán en la grilla. Se mostrarán en el mismo orden que en el CPT.', 'tema-viera-abogados' ); ?></p>

				<div class="mi-tema-form-group">
					<div style="max-height:350px; overflow-y:auto; border:1px solid #ddd; padding:15px; border-radius:4px; background:#f9f9f9; max-width:500px;">
						<?php
						$abogados_equipo = new WP_Query( array(
							'post_type'      => 'abogado',
							'posts_per_page' => -1,
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
						) );
						if ( $abogados_equipo->have_posts() ) :
							while ( $abogados_equipo->have_posts() ) :
								$abogados_equipo->the_post();
								$checked = ( is_array( $equipo_grid_ids ) && in_array( get_the_ID(), $equipo_grid_ids ) ) ? 'checked' : '';
								?>
								<label style="display:flex; align-items:center; gap:8px; padding:6px 0; cursor:pointer;">
									<input type="checkbox" name="equipo_grid_ids[]" value="<?php echo esc_attr( get_the_ID() ); ?>" <?php echo $checked; ?> />
									<?php
									$thumb_id = get_post_thumbnail_id();
									if ( $thumb_id ) {
										$thumb_url = wp_get_attachment_image_url( $thumb_id, array( 40, 40 ) );
										echo '<img src="' . esc_url( $thumb_url ) . '" alt="" style="width:32px;height:32px;border-radius:50%;object-fit:cover;" />';
									}
									?>
									<span><?php echo esc_html( get_the_title() ); ?></span>
									<?php
									$abogado_cargo = get_post_meta( get_the_ID(), '_abogado_cargo', true );
									if ( $abogado_cargo ) {
										echo '<span style="color:#888;font-size:12px;">(' . esc_html( $abogado_cargo ) . ')</span>';
									}
									?>
								</label>
								<?php
							endwhile;
							wp_reset_postdata();
						else :
						?>
							<p style="color:#999;"><?php esc_html_e( 'No hay abogados registrados. Créalos en la sección "Abogados" del menú.', 'tema-viera-abogados' ); ?></p>
						<?php endif; ?>
					</div>
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
		var eqMediaFrame;

		function eqUploadMedia( fieldId ) {
			if ( eqMediaFrame ) {
				eqMediaFrame.open();
				return;
			}
			eqMediaFrame = wp.media({
				title: 'Seleccionar Imagen',
				button: { text: 'Usar esta imagen' },
				multiple: false,
				library: { type: 'image' }
			});
			eqMediaFrame.on( 'select', function() {
				var attachment = eqMediaFrame.state().get('selection').first().toJSON();
				document.getElementById( fieldId ).value = attachment.id;
				document.getElementById( fieldId + '_preview' ).src = attachment.url;
				document.getElementById( fieldId + '_preview' ).parentElement.style.display = 'block';
			});
			eqMediaFrame.open();
		}

		function eqRemoveMedia( fieldId ) {
			document.getElementById( fieldId ).value = '';
			var preview = document.getElementById( fieldId + '_preview' );
			if ( preview ) {
				preview.parentElement.style.display = 'none';
			}
		}

		var perfilLogoIds = <?php echo ! empty( $perfil_logos_ids ) ? json_encode( array_map( 'intval', (array) $perfil_logos_ids ) ) : '[]'; ?>;
		var perfilLogosFrame;

		function eqUploadPerfilLogos() {
			if ( perfilLogosFrame ) {
				perfilLogosFrame.open();
				return;
			}
			perfilLogosFrame = wp.media({
				title: 'Seleccionar Logos',
				button: { text: 'Agregar a la galería' },
				multiple: true,
				library: { type: 'image' }
			});
			perfilLogosFrame.on( 'select', function() {
				var selections = perfilLogosFrame.state().get('selection');
				selections.each( function( attachment ) {
					attachment = attachment.toJSON();
					if ( perfilLogoIds.indexOf( attachment.id ) === -1 ) {
						perfilLogoIds.push( attachment.id );
					}
				});
				eqRenderPerfilLogos();
				eqUpdatePerfilLogosField();
			});
			perfilLogosFrame.open();
		}

		function eqRenderPerfilLogos() {
			var container = document.getElementById('perfil-logos-preview');
			container.innerHTML = '';
			if ( perfilLogoIds.length === 0 ) {
				container.style.display = 'none';
				return;
			}
			container.style.display = 'flex';
			perfilLogoIds.forEach( function( id ) {
				var att = wp.media.attachment( id );
				var url = att.get('url') || att.get('icon');
				var div = document.createElement('div');
				div.style.position = 'relative';
				div.style.display = 'inline-block';
				var img = document.createElement('img');
				img.src = url;
				img.style.maxWidth = '100px';
				img.style.height = 'auto';
				img.style.borderRadius = '4px';
				var btn = document.createElement('button');
				btn.type = 'button';
				btn.style.cssText = 'position:absolute;top:-5px;right:-5px;background:#dc3545;color:#fff;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:12px;line-height:20px;text-align:center;';
				btn.innerHTML = '&times;';
				btn.onclick = function() {
					var idx = perfilLogoIds.indexOf( id );
					if ( idx !== -1 ) perfilLogoIds.splice( idx, 1 );
					eqRenderPerfilLogos();
					eqUpdatePerfilLogosField();
				};
				div.appendChild( img );
				div.appendChild( btn );
				container.appendChild( div );
			});
		}

		function eqUpdatePerfilLogosField() {
			document.getElementById('perfil_logos').value = JSON.stringify( perfilLogoIds );
		}

		function eqRemovePerfilLogo( btn ) {
			var parent = btn.parentElement;
			var img = parent.querySelector('img');
			var url = img.getAttribute('src');
			var idToRemove = null;
			perfilLogoIds.forEach( function( id ) {
				var att = wp.media.attachment( id );
				if ( att.get('url') === url || att.get('icon') === url ) {
					idToRemove = id;
				}
			});
			if ( idToRemove !== null ) {
				var idx = perfilLogoIds.indexOf( idToRemove );
				if ( idx !== -1 ) perfilLogoIds.splice( idx, 1 );
			}
			parent.remove();
			if ( perfilLogoIds.length === 0 ) {
				document.getElementById('perfil-logos-preview').style.display = 'none';
			}
			eqUpdatePerfilLogosField();
		}
	</script>
	<?php
}

function tema_viera_procesar_opciones_equipo() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['perfil_pre_titulo'] ) ) {
		update_option( 'tema_viera_abogados_perfil_pre', sanitize_text_field( $_POST['perfil_pre_titulo'] ) );
	}
	if ( isset( $_POST['perfil_nombre'] ) ) {
		update_option( 'tema_viera_abogados_perfil_nombre', wp_kses_post( $_POST['perfil_nombre'] ) );
	}
	if ( isset( $_POST['perfil_cargo'] ) ) {
		update_option( 'tema_viera_abogados_perfil_cargo', sanitize_text_field( $_POST['perfil_cargo'] ) );
	}
	if ( isset( $_POST['perfil_cita'] ) ) {
		update_option( 'tema_viera_abogados_perfil_cita', sanitize_text_field( $_POST['perfil_cita'] ) );
	}
	if ( isset( $_POST['perfil_cita_autor'] ) ) {
		update_option( 'tema_viera_abogados_perfil_cita_autor', sanitize_text_field( $_POST['perfil_cita_autor'] ) );
	}
	if ( isset( $_POST['perfil_pre_logos'] ) ) {
		update_option( 'tema_viera_abogados_perfil_pre_logos', sanitize_text_field( $_POST['perfil_pre_logos'] ) );
	}
	if ( isset( $_POST['perfil_img'] ) ) {
		update_option( 'tema_viera_abogados_perfil_img', intval( $_POST['perfil_img'] ) );
	}
	if ( isset( $_POST['perfil_logos'] ) ) {
		$decoded = json_decode( wp_unslash( $_POST['perfil_logos'] ), true );
		update_option( 'tema_viera_abogados_perfil_logos', is_array( $decoded ) ? array_map( 'intval', $decoded ) : array() );
	}

	if ( isset( $_POST['detalle_pre_titulo'] ) ) {
		update_option( 'tema_viera_abogados_detalle_pre', sanitize_text_field( $_POST['detalle_pre_titulo'] ) );
	}
	if ( isset( $_POST['detalle_titulo'] ) ) {
		update_option( 'tema_viera_abogados_detalle_titulo', sanitize_text_field( $_POST['detalle_titulo'] ) );
	}
	if ( isset( $_POST['detalle_contenido'] ) ) {
		update_option( 'tema_viera_abogados_detalle_contenido', wp_kses_post( $_POST['detalle_contenido'] ) );
	}
	if ( isset( $_POST['detalle_rec_titulo'] ) ) {
		update_option( 'tema_viera_abogados_detalle_rec_titulo', sanitize_text_field( $_POST['detalle_rec_titulo'] ) );
	}

	if ( isset( $_POST['sidebar_esp_titulo'] ) ) {
		update_option( 'tema_viera_abogados_sidebar_esp_titulo', sanitize_text_field( $_POST['sidebar_esp_titulo'] ) );
	}
	if ( isset( $_POST['sidebar_esp_items'] ) ) {
		$items = array_filter( array_map( 'trim', explode( "\n", sanitize_textarea_field( $_POST['sidebar_esp_items'] ) ) ) );
		update_option( 'tema_viera_abogados_sidebar_esp_items', array_values( $items ) );
	}
	if ( isset( $_POST['sidebar_mem_titulo'] ) ) {
		update_option( 'tema_viera_abogados_sidebar_mem_titulo', sanitize_text_field( $_POST['sidebar_mem_titulo'] ) );
	}
	if ( isset( $_POST['sidebar_mem_items'] ) ) {
		$items = array_filter( array_map( 'trim', explode( "\n", sanitize_textarea_field( $_POST['sidebar_mem_items'] ) ) ) );
		update_option( 'tema_viera_abogados_sidebar_mem_items', array_values( $items ) );
	}
	if ( isset( $_POST['sidebar_correo_tit'] ) ) {
		update_option( 'tema_viera_abogados_sidebar_correo_tit', sanitize_text_field( $_POST['sidebar_correo_tit'] ) );
	}
	if ( isset( $_POST['sidebar_correo'] ) ) {
		update_option( 'tema_viera_abogados_sidebar_correo', sanitize_email( $_POST['sidebar_correo'] ) );
	}
	if ( isset( $_POST['sidebar_linkedin'] ) ) {
		update_option( 'tema_viera_abogados_sidebar_linkedin', esc_url_raw( $_POST['sidebar_linkedin'] ) );
	}

	if ( isset( $_POST['equipo_grid_tit'] ) ) {
		update_option( 'tema_viera_abogados_equipo_grid_tit', sanitize_text_field( $_POST['equipo_grid_tit'] ) );
	}
	if ( isset( $_POST['equipo_grid_desc'] ) ) {
		update_option( 'tema_viera_abogados_equipo_grid_desc', wp_kses_post( $_POST['equipo_grid_desc'] ) );
	}
	if ( isset( $_POST['equipo_grid_ids'] ) && is_array( $_POST['equipo_grid_ids'] ) ) {
		$grid_ids = array_map( 'intval', $_POST['equipo_grid_ids'] );
		$grid_ids = array_filter( $grid_ids, function( $id ) { return $id > 0; } );
		update_option( 'tema_viera_abogados_equipo_grid_ids', array_values( $grid_ids ) );
	} else {
		update_option( 'tema_viera_abogados_equipo_grid_ids', array() );
	}
}
