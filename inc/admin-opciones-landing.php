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
 * Cargar scripts de medios en la página de opciones
 */
function tema_viera_admin_enqueue_scripts( $hook ) {
	if ( 'toplevel_page_mi-tema-opciones-landing' !== $hook ) {
		return;
	}
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'tema_viera_admin_enqueue_scripts' );

/**
 * Registrar las opciones para que WordPress las gestione correctamente
 */
function tema_viera_register_settings() {
	// Opciones de Hero
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_hero_overline'
	);
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
		'tema_viera_abogados_hero_btn1_texto'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_hero_btn2_texto'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_awards_logos'
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

	// Opción del Logo
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_logo'
	);

	// Opciones de Contacto
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

	// Opciones de Texto Animado
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_texto_animado_1'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_texto_animado_2'
	);

	// Opciones de Experiencia / Sectores
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_exp_pre_titulo'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_exp_titulo'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_exp_subtitulo'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_sectores_items'
	);

	// Opciones de Clientes
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_clientes_titulo'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_clientes_logos'
	);

	// Opciones de Equipo / Fundador
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_equipo_pre'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_equipo_titulo'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_equipo_enlace_txt'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_equipo_enlace_url'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_fundador_post_id'
	);
	register_setting(
		'tema_viera_opciones_landing',
		'tema_viera_abogados_equipo_seleccionados'
	);

	// Opciones de KPIs
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_kpi_1_prefix' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_kpi_1_num' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_kpi_1_suffix' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_kpi_1_label' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_kpi_2_prefix' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_kpi_2_num' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_kpi_2_suffix' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_kpi_2_label' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_kpi_3_prefix' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_kpi_3_num' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_kpi_3_suffix' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_kpi_3_label' );

	// Opciones de Agenda / Cita
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_agenda_pre' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_agenda_titulo' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_agenda_desc' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_agenda_btn_txt' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_agenda_btn_url' );

	// Opciones de Noticias
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_noticias_pre' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_noticias_titulo' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_noticias_btn' );

	// Opciones de Redes Sociales (Footer)
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_social_ig' );
	register_setting( 'tema_viera_opciones_landing', 'tema_viera_abogados_social_in' );
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
	$logo_id               = get_option( 'tema_viera_abogados_logo', '' );
	$hero_overline         = get_option( 'tema_viera_abogados_hero_overline', '' );
	$hero_titulo           = get_option( 'tema_viera_abogados_hero_titulo', '' );
	$hero_subtitulo        = get_option( 'tema_viera_abogados_hero_subtitulo', '' );
	$hero_imagen_id        = get_option( 'tema_viera_abogados_hero_imagen', '' );
	$hero_btn1_texto       = get_option( 'tema_viera_abogados_hero_btn1_texto', '' );
	$hero_btn2_texto       = get_option( 'tema_viera_abogados_hero_btn2_texto', '' );
	$awards_logos_ids      = get_option( 'tema_viera_abogados_awards_logos', array() );

	$servicios_titulo      = get_option( 'tema_viera_abogados_servicios_titulo', '' );
	$servicios_items       = get_option( 'tema_viera_abogados_servicios_items', array() );

	$texto_animado_1       = get_option( 'tema_viera_abogados_texto_animado_1', 'RESOLVEMOS LO QUE' );
	$texto_animado_2       = get_option( 'tema_viera_abogados_texto_animado_2', 'OTROS NO PUEDEN' );

	$abogados_titulo       = get_option( 'tema_viera_abogados_abogados_titulo', '' );
	$abogados_subtitulo    = get_option( 'tema_viera_abogados_abogados_subtitulo', '' );

	$contacto_direccion    = get_option( 'tema_viera_abogados_contacto_direccion', '' );
	$contacto_telefono     = get_option( 'tema_viera_abogados_contacto_telefono', '' );
	$contacto_email        = get_option( 'tema_viera_abogados_contacto_email', '' );

	$exp_pre_titulo        = get_option( 'tema_viera_abogados_exp_pre_titulo', '' );
	$exp_titulo            = get_option( 'tema_viera_abogados_exp_titulo', '' );
	$exp_subtitulo         = get_option( 'tema_viera_abogados_exp_subtitulo', '' );
	$sectores_items        = get_option( 'tema_viera_abogados_sectores_items', array() );

	$clientes_titulo       = get_option( 'tema_viera_abogados_clientes_titulo', '' );
	$clientes_logos_ids    = get_option( 'tema_viera_abogados_clientes_logos', array() );

	$equipo_pre_titulo     = get_option( 'tema_viera_abogados_equipo_pre', '' );
	$equipo_titulo         = get_option( 'tema_viera_abogados_equipo_titulo', '' );
	$equipo_enlace_txt     = get_option( 'tema_viera_abogados_equipo_enlace_txt', '' );
	$equipo_enlace_url     = get_option( 'tema_viera_abogados_equipo_enlace_url', '' );
	$fundador_post_id      = get_option( 'tema_viera_abogados_fundador_post_id', '' );
	$equipo_seleccionados  = get_option( 'tema_viera_abogados_equipo_seleccionados', array() );

	$kpi_1_prefix = get_option( 'tema_viera_abogados_kpi_1_prefix', '+' );
	$kpi_1_num    = get_option( 'tema_viera_abogados_kpi_1_num', '50' );
	$kpi_1_suffix = get_option( 'tema_viera_abogados_kpi_1_suffix', '' );
	$kpi_1_label  = get_option( 'tema_viera_abogados_kpi_1_label', 'Empresas asesoradas' );
	$kpi_2_prefix = get_option( 'tema_viera_abogados_kpi_2_prefix', '+' );
	$kpi_2_num    = get_option( 'tema_viera_abogados_kpi_2_num', '35' );
	$kpi_2_suffix = get_option( 'tema_viera_abogados_kpi_2_suffix', '' );
	$kpi_2_label  = get_option( 'tema_viera_abogados_kpi_2_label', 'Años de experiencia' );
	$kpi_3_prefix = get_option( 'tema_viera_abogados_kpi_3_prefix', '' );
	$kpi_3_num    = get_option( 'tema_viera_abogados_kpi_3_num', '100' );
	$kpi_3_suffix = get_option( 'tema_viera_abogados_kpi_3_suffix', '%' );
	$kpi_3_label  = get_option( 'tema_viera_abogados_kpi_3_label', 'Clientes satisfechos' );

	$agenda_pre_titulo = get_option( 'tema_viera_abogados_agenda_pre', 'AGENDA UNA REUNIÓN' );
	$agenda_titulo     = get_option( 'tema_viera_abogados_agenda_titulo', 'HABLEMOS DE TU CASO' );
	$agenda_desc       = get_option( 'tema_viera_abogados_agenda_desc', 'Agenda una reunión con nuestro equipo legal de forma rápida y sencilla. Estamos listos para escucharte y ayudarte.' );
	$agenda_btn_txt    = get_option( 'tema_viera_abogados_agenda_btn_txt', 'AGENDA UNA CITA >' );
	$agenda_btn_url    = get_option( 'tema_viera_abogados_agenda_btn_url', '#plugin-reserva' );

	$noticias_pre_titulo = get_option( 'tema_viera_abogados_noticias_pre', 'MÁS SOBRE NOSOTROS' );
	$noticias_titulo     = get_option( 'tema_viera_abogados_noticias_titulo', 'CASOS, NOTICIAS Y MÁS' );
	$noticias_btn        = get_option( 'tema_viera_abogados_noticias_btn', 'CARGAR MÁS ∨' );

	$social_ig = get_option( 'tema_viera_abogados_social_ig', '#' );
	$social_in = get_option( 'tema_viera_abogados_social_in', '#' );

	// Obtener URLs de imágenes si existen
	$logo_url = $logo_id ? wp_get_attachment_url( $logo_id ) : '';
	$hero_imagen_url = $hero_imagen_id ? wp_get_attachment_url( $hero_imagen_id ) : '';
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

			<!-- SECCIÓN LOGO -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Logo del Sitio', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label><?php esc_html_e( 'Logo', 'tema-viera-abogados' ); ?></label>
					<input type="hidden" id="logo" name="logo" value="<?php echo esc_attr( $logo_id ); ?>" />
					<button type="button" class="mi-tema-btn-upload" onclick="tema_viera_upload_media('logo')">
						<?php esc_html_e( 'Seleccionar Logo', 'tema-viera-abogados' ); ?>
					</button>
					<?php if ( $logo_url ) : ?>
						<button type="button" class="mi-tema-btn-remove" onclick="tema_viera_remove_media('logo')">
							<?php esc_html_e( 'Eliminar Logo', 'tema-viera-abogados' ); ?>
						</button>
						<div class="mi-tema-image-preview">
							<img id="logo_preview" src="<?php echo esc_url( $logo_url ); ?>" alt="<?php esc_attr_e( 'Logo', 'tema-viera-abogados' ); ?>" />
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- SECCIÓN HERO -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección Hero', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="hero_overline"><?php esc_html_e( 'Texto Superior (overline)', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="hero_overline" name="hero_overline" value="<?php echo esc_attr( $hero_overline ); ?>" />
				</div>

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

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'Botón 1 — lleva a #servicios', 'tema-viera-abogados' ); ?></h3>

				<div class="mi-tema-form-group">
					<label for="hero_btn1_texto"><?php esc_html_e( 'Texto del Botón 1', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="hero_btn1_texto" name="hero_btn1_texto" value="<?php echo esc_attr( $hero_btn1_texto ); ?>" />
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'Botón 2 — lleva a #contacto', 'tema-viera-abogados' ); ?></h3>

				<div class="mi-tema-form-group">
					<label for="hero_btn2_texto"><?php esc_html_e( 'Texto del Botón 2', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="hero_btn2_texto" name="hero_btn2_texto" value="<?php echo esc_attr( $hero_btn2_texto ); ?>" />
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'Reconocimientos (Awards)', 'tema-viera-abogados' ); ?></h3>

				<div class="mi-tema-form-group">
					<label><?php esc_html_e( 'Logos de Reconocimientos', 'tema-viera-abogados' ); ?></label>
					<input type="hidden" id="awards_logos" name="awards_logos" value="<?php echo esc_attr( json_encode( $awards_logos_ids ) ); ?>" />
					<button type="button" class="mi-tema-btn-upload" onclick="tema_viera_upload_awards()">
						<?php esc_html_e( 'Seleccionar Imágenes', 'tema-viera-abogados' ); ?>
					</button>
					<div id="awards-preview" class="mi-tema-image-preview" style="display:<?php echo ! empty( $awards_logos_ids ) ? 'flex' : 'none'; ?>; flex-wrap:wrap; gap:10px; margin-top:10px;">
						<?php if ( ! empty( $awards_logos_ids ) && is_array( $awards_logos_ids ) ) : ?>
							<?php foreach ( $awards_logos_ids as $logo_id ) : 
								$logo_url = wp_get_attachment_url( $logo_id );
								if ( $logo_url ) : ?>
									<div style="position:relative;display:inline-block;">
										<img src="<?php echo esc_url( $logo_url ); ?>" style="max-width:100px;height:auto;border-radius:4px;" />
										<button type="button" style="position:absolute;top:-5px;right:-5px;background:#dc3545;color:#fff;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:12px;line-height:20px;text-align:center;" onclick="removeAwardLogo(this)">&times;</button>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<p class="description" style="margin-top:5px;"><?php esc_html_e( 'Selecciona las imágenes de los reconocimientos internacionales.', 'tema-viera-abogados' ); ?></p>
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

			<!-- SECCIÓN TEXTO ANIMADO -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección Texto Animado', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="texto_animado_1"><?php esc_html_e( 'Línea Superior (entra por izquierda)', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="texto_animado_1" name="texto_animado_1" value="<?php echo esc_attr( $texto_animado_1 ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="texto_animado_2"><?php esc_html_e( 'Línea Inferior (entra por derecha)', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="texto_animado_2" name="texto_animado_2" value="<?php echo esc_attr( $texto_animado_2 ); ?>" />
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

			<!-- SECCIÓN EXPERIENCIA / SECTORES -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección Experiencia — Nuestra Experiencia', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="exp_pre_titulo"><?php esc_html_e( 'Pre-título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="exp_pre_titulo" name="exp_pre_titulo" value="<?php echo esc_attr( $exp_pre_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="exp_titulo"><?php esc_html_e( 'Título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="exp_titulo" name="exp_titulo" value="<?php echo esc_attr( $exp_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="exp_subtitulo"><?php esc_html_e( 'Subtítulo', 'tema-viera-abogados' ); ?></label>
					<textarea id="exp_subtitulo" name="exp_subtitulo"><?php echo esc_textarea( $exp_subtitulo ); ?></textarea>
				</div>

				<div class="mi-tema-servicios-container">
					<p><strong><?php esc_html_e( 'Sectores', 'tema-viera-abogados' ); ?></strong></p>
					<div id="sectores-list">
						<?php
						if ( ! empty( $sectores_items ) && is_array( $sectores_items ) ) {
							foreach ( $sectores_items as $index => $sector ) {
								tema_viera_render_sector_item( $index, $sector );
							}
						}
						?>
					</div>

					<button type="button" id="btn-add-sector" class="button button-primary">
						<?php esc_html_e( '+ Agregar Sector', 'tema-viera-abogados' ); ?>
					</button>
				</div>
			</div>

			<!-- SECCIÓN CLIENTES -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección Clientes', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="clientes_titulo"><?php esc_html_e( 'Título de la Sección', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="clientes_titulo" name="clientes_titulo" value="<?php echo esc_attr( $clientes_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label><?php esc_html_e( 'Logos de Clientes', 'tema-viera-abogados' ); ?></label>
					<input type="hidden" id="clientes_logos" name="clientes_logos" value="<?php echo esc_attr( json_encode( $clientes_logos_ids ) ); ?>" />
					<button type="button" class="mi-tema-btn-upload" onclick="tema_viera_upload_clientes()">
						<?php esc_html_e( 'Seleccionar Imágenes', 'tema-viera-abogados' ); ?>
					</button>
					<div id="clientes-preview" class="mi-tema-image-preview" style="display:<?php echo ! empty( $clientes_logos_ids ) ? 'flex' : 'none'; ?>; flex-wrap:wrap; gap:10px; margin-top:10px;">
						<?php if ( ! empty( $clientes_logos_ids ) && is_array( $clientes_logos_ids ) ) : ?>
							<?php foreach ( $clientes_logos_ids as $logo_id ) : 
								$logo_url = wp_get_attachment_url( $logo_id );
								if ( $logo_url ) : ?>
									<div style="position:relative;display:inline-block;">
										<img src="<?php echo esc_url( $logo_url ); ?>" style="max-width:100px;height:auto;border-radius:4px;" />
										<button type="button" style="position:absolute;top:-5px;right:-5px;background:#dc3545;color:#fff;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:12px;line-height:20px;text-align:center;" onclick="removeClienteLogo(this)">&times;</button>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<p class="description" style="margin-top:5px;"><?php esc_html_e( 'Selecciona los logos de los clientes.', 'tema-viera-abogados' ); ?></p>
				</div>
			</div>

			<!-- SECCIÓN FOOTER -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Footer', 'tema-viera-abogados' ); ?></h2>

				<h3 style="color:#1a3a52;"><?php esc_html_e( 'Contacto', 'tema-viera-abogados' ); ?></h3>

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

				<h3 style="margin-top:25px;color:#1a3a52;"><?php esc_html_e( 'Redes Sociales', 'tema-viera-abogados' ); ?></h3>

				<div class="mi-tema-form-group">
					<label for="social_ig"><?php esc_html_e( 'Instagram URL', 'tema-viera-abogados' ); ?></label>
					<input type="url" id="social_ig" name="social_ig" value="<?php echo esc_attr( $social_ig ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="social_in"><?php esc_html_e( 'LinkedIn URL', 'tema-viera-abogados' ); ?></label>
					<input type="url" id="social_in" name="social_in" value="<?php echo esc_attr( $social_in ); ?>" />
				</div>
			</div>

			<!-- SECCIÓN EQUIPO / FUNDADOR -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección Equipo — Nuestro Equipo', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="equipo_pre_titulo"><?php esc_html_e( 'Pre-título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="equipo_pre_titulo" name="equipo_pre_titulo" value="<?php echo esc_attr( $equipo_pre_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="equipo_titulo"><?php esc_html_e( 'Título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="equipo_titulo" name="equipo_titulo" value="<?php echo esc_attr( $equipo_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="equipo_enlace_txt"><?php esc_html_e( 'Texto del enlace', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="equipo_enlace_txt" name="equipo_enlace_txt" value="<?php echo esc_attr( $equipo_enlace_txt ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="equipo_enlace_url"><?php esc_html_e( 'URL del enlace', 'tema-viera-abogados' ); ?></label>
					<input type="url" id="equipo_enlace_url" name="equipo_enlace_url" value="<?php echo esc_attr( $equipo_enlace_url ); ?>" />
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'Fundador', 'tema-viera-abogados' ); ?></h3>
				<p class="description" style="margin-bottom:15px;"><?php esc_html_e( 'Selecciona un abogado del CPT para mostrar como fundador destacado. Asegúrate de haber creado al abogado en la sección "Abogados" previamente.', 'tema-viera-abogados' ); ?></p>

				<div class="mi-tema-form-group">
					<label for="fundador_post_id"><?php esc_html_e( 'Abogado Fundador', 'tema-viera-abogados' ); ?></label>
					<select id="fundador_post_id" name="fundador_post_id" style="max-width:500px;">
						<option value=""><?php esc_html_e( '— Ninguno —', 'tema-viera-abogados' ); ?></option>
						<?php
						$abogados_query = new WP_Query( array(
							'post_type'      => 'abogado',
							'posts_per_page' => -1,
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
						) );
						if ( $abogados_query->have_posts() ) :
							while ( $abogados_query->have_posts() ) :
								$abogados_query->the_post();
								$selected = ( get_the_ID() == $fundador_post_id ) ? 'selected' : '';
								?>
								<option value="<?php echo esc_attr( get_the_ID() ); ?>" <?php echo $selected; ?>>
									<?php echo esc_html( get_the_title() ); ?>
								</option>
								<?php
							endwhile;
							wp_reset_postdata();
						endif;
						?>
					</select>
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'Miembros del Equipo', 'tema-viera-abogados' ); ?></h3>
				<p class="description" style="margin-bottom:15px;"><?php esc_html_e( 'Selecciona los abogados que aparecerán en la sección de equipo. Se mostrarán en el mismo orden que tienen en el CPT.', 'tema-viera-abogados' ); ?></p>

				<div class="mi-tema-form-group">
					<div style="max-height:300px; overflow-y:auto; border:1px solid #ddd; padding:15px; border-radius:4px; background:#f9f9f9; max-width:500px;">
						<?php
						$abogados_query2 = new WP_Query( array(
							'post_type'      => 'abogado',
							'posts_per_page' => -1,
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
						) );
						if ( $abogados_query2->have_posts() ) :
							while ( $abogados_query2->have_posts() ) :
								$abogados_query2->the_post();
								$checked = ( is_array( $equipo_seleccionados ) && in_array( get_the_ID(), $equipo_seleccionados ) ) ? 'checked' : '';
								?>
								<label style="display:flex; align-items:center; gap:8px; padding:6px 0; cursor:pointer;">
									<input type="checkbox" name="equipo_seleccionados[]" value="<?php echo esc_attr( get_the_ID() ); ?>" <?php echo $checked; ?> />
									<?php
									$thumb_id = get_post_thumbnail_id();
									if ( $thumb_id ) {
										$thumb_url = wp_get_attachment_image_url( $thumb_id, array(40, 40) );
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
						else:
						?>
							<p style="color:#999;"><?php esc_html_e( 'No hay abogados registrados aún. Créalos en la sección "Abogados".', 'tema-viera-abogados' ); ?></p>
						<?php endif; ?>
					</div>
					<p class="description" style="margin-top:5px;"><?php esc_html_e( 'Marca los abogados que quieres mostrar en esta sección. El fundador seleccionado arriba se excluirá automáticamente.', 'tema-viera-abogados' ); ?></p>
				</div>
			</div>

			<!-- SECCIÓN KPIs -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección KPIs — Indicadores', 'tema-viera-abogados' ); ?></h2>

				<h3 style="margin-top:20px;color:#1a3a52;"><?php esc_html_e( 'KPI 1', 'tema-viera-abogados' ); ?></h3>
				<div class="mi-tema-form-group">
					<label for="kpi_1_prefix"><?php esc_html_e( 'Prefijo (ej: +)', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="kpi_1_prefix" name="kpi_1_prefix" value="<?php echo esc_attr( $kpi_1_prefix ); ?>" maxlength="5" />
				</div>
				<div class="mi-tema-form-group">
					<label for="kpi_1_num"><?php esc_html_e( 'Número', 'tema-viera-abogados' ); ?> <span style="color:red;">*</span></label>
					<input type="text" id="kpi_1_num" name="kpi_1_num" value="<?php echo esc_attr( $kpi_1_num ); ?>" required pattern="[0-9]+" />
				</div>
				<div class="mi-tema-form-group">
					<label for="kpi_1_suffix"><?php esc_html_e( 'Sufijo (ej: %, K)', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="kpi_1_suffix" name="kpi_1_suffix" value="<?php echo esc_attr( $kpi_1_suffix ); ?>" maxlength="5" />
				</div>
				<div class="mi-tema-form-group">
					<label for="kpi_1_label"><?php esc_html_e( 'Etiqueta', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="kpi_1_label" name="kpi_1_label" value="<?php echo esc_attr( $kpi_1_label ); ?>" />
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'KPI 2', 'tema-viera-abogados' ); ?></h3>
				<div class="mi-tema-form-group">
					<label for="kpi_2_prefix"><?php esc_html_e( 'Prefijo (ej: +)', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="kpi_2_prefix" name="kpi_2_prefix" value="<?php echo esc_attr( $kpi_2_prefix ); ?>" maxlength="5" />
				</div>
				<div class="mi-tema-form-group">
					<label for="kpi_2_num"><?php esc_html_e( 'Número', 'tema-viera-abogados' ); ?> <span style="color:red;">*</span></label>
					<input type="text" id="kpi_2_num" name="kpi_2_num" value="<?php echo esc_attr( $kpi_2_num ); ?>" required pattern="[0-9]+" />
				</div>
				<div class="mi-tema-form-group">
					<label for="kpi_2_suffix"><?php esc_html_e( 'Sufijo (ej: %, K)', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="kpi_2_suffix" name="kpi_2_suffix" value="<?php echo esc_attr( $kpi_2_suffix ); ?>" maxlength="5" />
				</div>
				<div class="mi-tema-form-group">
					<label for="kpi_2_label"><?php esc_html_e( 'Etiqueta', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="kpi_2_label" name="kpi_2_label" value="<?php echo esc_attr( $kpi_2_label ); ?>" />
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'KPI 3', 'tema-viera-abogados' ); ?></h3>
				<div class="mi-tema-form-group">
					<label for="kpi_3_prefix"><?php esc_html_e( 'Prefijo (ej: +)', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="kpi_3_prefix" name="kpi_3_prefix" value="<?php echo esc_attr( $kpi_3_prefix ); ?>" maxlength="5" />
				</div>
				<div class="mi-tema-form-group">
					<label for="kpi_3_num"><?php esc_html_e( 'Número', 'tema-viera-abogados' ); ?> <span style="color:red;">*</span></label>
					<input type="text" id="kpi_3_num" name="kpi_3_num" value="<?php echo esc_attr( $kpi_3_num ); ?>" required pattern="[0-9]+" />
				</div>
				<div class="mi-tema-form-group">
					<label for="kpi_3_suffix"><?php esc_html_e( 'Sufijo (ej: %, K)', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="kpi_3_suffix" name="kpi_3_suffix" value="<?php echo esc_attr( $kpi_3_suffix ); ?>" maxlength="5" />
				</div>
				<div class="mi-tema-form-group">
					<label for="kpi_3_label"><?php esc_html_e( 'Etiqueta', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="kpi_3_label" name="kpi_3_label" value="<?php echo esc_attr( $kpi_3_label ); ?>" />
				</div>
			</div>

			<!-- SECCIÓN AGENDAR CITA -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección Agendar Cita', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="agenda_pre_titulo"><?php esc_html_e( 'Pre-título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="agenda_pre_titulo" name="agenda_pre_titulo" value="<?php echo esc_attr( $agenda_pre_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="agenda_titulo"><?php esc_html_e( 'Título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="agenda_titulo" name="agenda_titulo" value="<?php echo esc_attr( $agenda_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="agenda_desc"><?php esc_html_e( 'Descripción', 'tema-viera-abogados' ); ?></label>
					<textarea id="agenda_desc" name="agenda_desc"><?php echo esc_textarea( $agenda_desc ); ?></textarea>
				</div>

				<div class="mi-tema-form-group">
					<label for="agenda_btn_txt"><?php esc_html_e( 'Texto del Botón', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="agenda_btn_txt" name="agenda_btn_txt" value="<?php echo esc_attr( $agenda_btn_txt ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="agenda_btn_url"><?php esc_html_e( 'URL del Botón', 'tema-viera-abogados' ); ?></label>
					<input type="url" id="agenda_btn_url" name="agenda_btn_url" value="<?php echo esc_attr( $agenda_btn_url ); ?>" />
				</div>
			</div>

			<!-- SECCIÓN NOTICIAS -->
			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Sección Noticias y Casos', 'tema-viera-abogados' ); ?></h2>

				<div class="mi-tema-form-group">
					<label for="noticias_pre_titulo"><?php esc_html_e( 'Pre-título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="noticias_pre_titulo" name="noticias_pre_titulo" value="<?php echo esc_attr( $noticias_pre_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="noticias_titulo"><?php esc_html_e( 'Título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="noticias_titulo" name="noticias_titulo" value="<?php echo esc_attr( $noticias_titulo ); ?>" />
				</div>

				<div class="mi-tema-form-group">
					<label for="noticias_btn"><?php esc_html_e( 'Texto botón "Cargar Más"', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="noticias_btn" name="noticias_btn" value="<?php echo esc_attr( $noticias_btn ); ?>" />
				</div>

				<h3 style="margin-top:30px;color:#1a3a52;"><?php esc_html_e( 'Noticias - Origen de datos', 'tema-viera-abogados' ); ?></h3>

				<div class="mi-tema-servicios-container">
					<p style="margin-bottom:10px;">
						<strong><?php esc_html_e( 'Las noticias ahora se gestionan desde Posts (Entradas) del blog.', 'tema-viera-abogados' ); ?></strong>
					</p>
					<p style="margin-bottom:8px;">
						<?php esc_html_e( 'Para que una noticia aparezca en el landing:', 'tema-viera-abogados' ); ?>
					</p>
					<ol style="margin-left:20px; margin-bottom:10px;">
						<li><?php esc_html_e( 'Ve a Entradas > Agregar nueva.', 'tema-viera-abogados' ); ?></li>
						<li><?php esc_html_e( 'Escribe el contenido de la noticia.', 'tema-viera-abogados' ); ?></li>
						<li><?php esc_html_e( 'Asigna una imagen destacada.', 'tema-viera-abogados' ); ?></li>
						<li><?php esc_html_e( 'En "Categorías", selecciona la categoría "Destacados".', 'tema-viera-abogados' ); ?></li>
						<li><?php esc_html_e( 'Publica la entrada.', 'tema-viera-abogados' ); ?></li>
					</ol>
					<p>
						<?php esc_html_e( 'Las 6 noticias más recientes de la categoría "Destacados" se mostrarán automáticamente en el landing.', 'tema-viera-abogados' ); ?>
					</p>
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
						<label>Titulo del Servicio</label>
						<input type="text" name="servicios[${servicioIndex}][titulo]" value="" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
					</div>
					<div style="margin-bottom: 10px;">
						<label>Descripcion</label>
						<textarea name="servicios[${servicioIndex}][descripcion]" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-height: 80px;"></textarea>
					</div>
					<div>
						<label>Detalles (uno por línea. Usa **texto** para negrita)</label>
						<textarea name="servicios[${servicioIndex}][detalles]" placeholder="Un elemento por linea para los bullet points" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-height: 80px;"></textarea>
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

		// Variable global para rastrear el índice de sectores
		var sectorIndex = <?php echo isset( $sectores_items ) ? count( (array) $sectores_items ) : 0; ?>;

		// Agregar un nuevo sector dinámicamente
		var btnAddSector = document.getElementById('btn-add-sector');
		if (btnAddSector) {
			btnAddSector.addEventListener('click', function( e ) {
				e.preventDefault();
				var container = document.getElementById('sectores-list');
				var html = '<div class="mi-tema-servicio-item mi-tema-sector-item" data-index="' + sectorIndex + '">' +
					'<button type="button" class="btn-remove-servicio" onclick="removeSector(' + sectorIndex + ')">Eliminar</button>' +
					'<div style="margin-bottom: 10px;">' +
						'<label>Título del Sector</label>' +
						'<input type="text" name="sectores[' + sectorIndex + '][titulo]" value="" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />' +
					'</div>' +
					'<div style="margin-bottom: 10px;">' +
						'<label>Descripción</label>' +
						'<textarea name="sectores[' + sectorIndex + '][descripcion]" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-height: 80px;"></textarea>' +
					'</div>' +
					'<div>' +
						'<label>Imagen del Sector</label>' +
						'<div>' +
							'<input type="hidden" id="sector_img_' + sectorIndex + '" name="sectores[' + sectorIndex + '][imagen]" value="" />' +
							'<div class="mi-tema-img-preview" style="display: none; margin-bottom: 8px;">' +
								'<img id="sector_img_' + sectorIndex + '_preview" src="" style="max-width: 150px; max-height: 100px; display: block;" />' +
								'<button type="button" class="button button-small" onclick="tema_viera_remove_media(\'sector_img_' + sectorIndex + '\')" style="margin-top: 5px;">Quitar imagen</button>' +
							'</div>' +
							'<button type="button" class="button" onclick="tema_viera_upload_sector_media(\'sector_img_' + sectorIndex + '\')">Subir Imagen</button>' +
						'</div>' +
					'</div>' +
				'</div>';
				container.insertAdjacentHTML('beforeend', html);
				sectorIndex++;
			});
		}

		// Remover un sector
		function removeSector( index ) {
			var item = document.querySelector('.mi-tema-sector-item[data-index="' + index + '"]');
			if ( item ) {
				item.remove();
			}
		}

		// Función para subir medios (para logo y hero)
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

		// Función para subir imagen de sector (crea frame nuevo cada vez)
		function tema_viera_upload_sector_media( fieldId ) {
			var frame = wp.media({
				title: '<?php esc_html_e( 'Seleccionar Imagen', 'tema-viera-abogados' ); ?>',
				button: { text: '<?php esc_html_e( 'Usar esta imagen', 'tema-viera-abogados' ); ?>' },
				multiple: false,
				library: { type: 'image' }
			});

			frame.on( 'select', function() {
				var attachment = frame.state().get('selection').first().toJSON();
				document.getElementById( fieldId ).value = attachment.id;
				document.getElementById( fieldId + '_preview' ).src = attachment.url;
				document.getElementById( fieldId + '_preview' ).parentElement.style.display = 'block';
			});

			frame.open();
		}

		// Función para remover imagen
		function tema_viera_remove_media( fieldId ) {
			document.getElementById( fieldId ).value = '';
			var preview = document.getElementById( fieldId + '_preview' );
			if ( preview ) {
				preview.parentElement.style.display = 'none';
			}
		}

		// Variables para la galería de awards
		var awardsLogoIds = <?php echo ! empty( $awards_logos_ids ) ? json_encode( array_map( 'intval', (array) $awards_logos_ids ) ) : '[]'; ?>;
		var awardsMediaFrame;

		function tema_viera_upload_awards() {
			if ( awardsMediaFrame ) {
				awardsMediaFrame.open();
				return;
			}

			awardsMediaFrame = wp.media({
				title: '<?php esc_html_e( 'Seleccionar Logos de Reconocimientos', 'tema-viera-abogados' ); ?>',
				button: { text: '<?php esc_html_e( 'Agregar a la galería', 'tema-viera-abogados' ); ?>' },
				multiple: true,
				library: { type: 'image' }
			});

			awardsMediaFrame.on( 'select', function() {
				var selections = awardsMediaFrame.state().get('selection');
				selections.each( function( attachment ) {
					attachment = attachment.toJSON();
					if ( awardsLogoIds.indexOf( attachment.id ) === -1 ) {
						awardsLogoIds.push( attachment.id );
					}
				});
				renderAwardsPreview();
				updateAwardsField();
			});

			awardsMediaFrame.open();
		}

		function renderAwardsPreview() {
			var container = document.getElementById('awards-preview');
			container.innerHTML = '';
			if ( awardsLogoIds.length === 0 ) {
				container.style.display = 'none';
				return;
			}
			container.style.display = 'flex';
			awardsLogoIds.forEach( function( id ) {
				var wpMediaAttachment = wp.media.attachment( id );
				var url = wpMediaAttachment.get('url');
				if ( ! url ) {
					url = wpMediaAttachment.get('icon');
				}
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
				btn.style.position = 'absolute';
				btn.style.top = '-5px';
				btn.style.right = '-5px';
				btn.style.background = '#dc3545';
				btn.style.color = '#fff';
				btn.style.border = 'none';
				btn.style.borderRadius = '50%';
				btn.style.width = '20px';
				btn.style.height = '20px';
				btn.style.cursor = 'pointer';
				btn.style.fontSize = '12px';
				btn.style.lineHeight = '20px';
				btn.style.textAlign = 'center';
				btn.innerHTML = '&times;';
				btn.onclick = function() {
					var idx = awardsLogoIds.indexOf( id );
					if ( idx !== -1 ) {
						awardsLogoIds.splice( idx, 1 );
					}
					renderAwardsPreview();
					updateAwardsField();
				};
				div.appendChild( img );
				div.appendChild( btn );
				container.appendChild( div );
			});
		}

		function updateAwardsField() {
			document.getElementById('awards_logos').value = JSON.stringify( awardsLogoIds );
		}

		function removeAwardLogo( btn ) {
			var parent = btn.parentElement;
			var img = parent.querySelector('img');
			var url = img.getAttribute('src');
			// Find the matching ID by iterating over known IDs
			var idToRemove = null;
			awardsLogoIds.forEach( function( id ) {
				var wpMediaAttachment = wp.media.attachment( id );
				if ( wpMediaAttachment.get('url') === url || wpMediaAttachment.get('icon') === url ) {
					idToRemove = id;
				}
			});
			if ( idToRemove !== null ) {
				var idx = awardsLogoIds.indexOf( idToRemove );
				if ( idx !== -1 ) {
					awardsLogoIds.splice( idx, 1 );
				}
			}
			parent.remove();
			if ( awardsLogoIds.length === 0 ) {
				document.getElementById('awards-preview').style.display = 'none';
			}
			updateAwardsField();
		}

		// Variables para la galería de clientes
		var clientesLogoIds = <?php echo ! empty( $clientes_logos_ids ) ? json_encode( array_map( 'intval', (array) $clientes_logos_ids ) ) : '[]'; ?>;
		var clientesMediaFrame;

		function tema_viera_upload_clientes() {
			if ( clientesMediaFrame ) {
				clientesMediaFrame.open();
				return;
			}
			clientesMediaFrame = wp.media({
				title: '<?php esc_html_e( 'Seleccionar Logos de Clientes', 'tema-viera-abogados' ); ?>',
				button: { text: '<?php esc_html_e( 'Agregar a la galería', 'tema-viera-abogados' ); ?>' },
				multiple: true,
				library: { type: 'image' }
			});
			clientesMediaFrame.on( 'select', function() {
				var selections = clientesMediaFrame.state().get('selection');
				selections.each( function( attachment ) {
					attachment = attachment.toJSON();
					if ( clientesLogoIds.indexOf( attachment.id ) === -1 ) {
						clientesLogoIds.push( attachment.id );
					}
				});
				renderClientesPreview();
				updateClientesField();
			});
			clientesMediaFrame.open();
		}

		function renderClientesPreview() {
			var container = document.getElementById('clientes-preview');
			container.innerHTML = '';
			if ( clientesLogoIds.length === 0 ) {
				container.style.display = 'none';
				return;
			}
			container.style.display = 'flex';
			clientesLogoIds.forEach( function( id ) {
				var wpMediaAttachment = wp.media.attachment( id );
				var url = wpMediaAttachment.get('url') || wpMediaAttachment.get('icon');
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
				btn.style.position = 'absolute';
				btn.style.top = '-5px';
				btn.style.right = '-5px';
				btn.style.background = '#dc3545';
				btn.style.color = '#fff';
				btn.style.border = 'none';
				btn.style.borderRadius = '50%';
				btn.style.width = '20px';
				btn.style.height = '20px';
				btn.style.cursor = 'pointer';
				btn.style.fontSize = '12px';
				btn.style.lineHeight = '20px';
				btn.style.textAlign = 'center';
				btn.innerHTML = '&times;';
				btn.onclick = function() {
					var idx = clientesLogoIds.indexOf( id );
					if ( idx !== -1 ) {
						clientesLogoIds.splice( idx, 1 );
					}
					renderClientesPreview();
					updateClientesField();
				};
				div.appendChild( img );
				div.appendChild( btn );
				container.appendChild( div );
			});
		}

		function updateClientesField() {
			document.getElementById('clientes_logos').value = JSON.stringify( clientesLogoIds );
		}

		function removeClienteLogo( btn ) {
			var parent = btn.parentElement;
			var img = parent.querySelector('img');
			var url = img.getAttribute('src');
			var idToRemove = null;
			clientesLogoIds.forEach( function( id ) {
				var wpMediaAttachment = wp.media.attachment( id );
				if ( wpMediaAttachment.get('url') === url || wpMediaAttachment.get('icon') === url ) {
					idToRemove = id;
				}
			});
			if ( idToRemove !== null ) {
				var idx = clientesLogoIds.indexOf( idToRemove );
				if ( idx !== -1 ) {
					clientesLogoIds.splice( idx, 1 );
				}
			}
			parent.remove();
			if ( clientesLogoIds.length === 0 ) {
				document.getElementById('clientes-preview').style.display = 'none';
			}
			updateClientesField();
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
	$detalles    = isset( $servicio['detalles'] ) ? $servicio['detalles'] : '';
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
			<label><?php esc_html_e( 'Detalles (uno por línea. Usa **texto** para negrita)', 'tema-viera-abogados' ); ?></label>
			<textarea name="servicios[<?php echo esc_attr( $index ); ?>][detalles]" placeholder="Un elemento por línea para los bullet points" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-height: 80px;"><?php echo esc_textarea( $detalles ); ?></textarea>
		</div>
	</div>
	<?php
}

/**
 * Renderizar un item individual de sector (experiencia)
 *
 * @param int $index Índice del sector
 * @param array $sector Datos del sector
 */
function tema_viera_render_sector_item( $index, $sector ) {
	$titulo       = isset( $sector['titulo'] ) ? $sector['titulo'] : '';
	$descripcion  = isset( $sector['descripcion'] ) ? $sector['descripcion'] : '';
	$imagen_id    = isset( $sector['imagen'] ) ? $sector['imagen'] : '';
	$imagen_url   = $imagen_id ? wp_get_attachment_url( $imagen_id ) : '';
	?>
	<div class="mi-tema-servicio-item mi-tema-sector-item" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="btn-remove-servicio" onclick="removeSector(<?php echo esc_attr( $index ); ?>)">
			<?php esc_html_e( 'Eliminar', 'tema-viera-abogados' ); ?>
		</button>
		<div style="margin-bottom: 10px;">
			<label><?php esc_html_e( 'Título del Sector', 'tema-viera-abogados' ); ?></label>
			<input type="text" name="sectores[<?php echo esc_attr( $index ); ?>][titulo]" value="<?php echo esc_attr( $titulo ); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
		</div>
		<div style="margin-bottom: 10px;">
			<label><?php esc_html_e( 'Descripción', 'tema-viera-abogados' ); ?></label>
			<textarea name="sectores[<?php echo esc_attr( $index ); ?>][descripcion]" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-height: 80px;"><?php echo esc_textarea( $descripcion ); ?></textarea>
		</div>
		<div>
			<label><?php esc_html_e( 'Imagen del Sector', 'tema-viera-abogados' ); ?></label>
			<div>
				<input type="hidden" id="sector_img_<?php echo esc_attr( $index ); ?>" name="sectores[<?php echo esc_attr( $index ); ?>][imagen]" value="<?php echo esc_attr( $imagen_id ); ?>" />
				<div class="mi-tema-img-preview" style="<?php echo $imagen_url ? '' : 'display: none;'; ?> margin-bottom: 8px;">
					<img id="sector_img_<?php echo esc_attr( $index ); ?>_preview" src="<?php echo esc_url( $imagen_url ); ?>" style="max-width: 150px; max-height: 100px; display: block;" />
					<button type="button" class="button button-small" onclick="tema_viera_remove_media('sector_img_<?php echo esc_attr( $index ); ?>')" style="margin-top: 5px;">
						<?php esc_html_e( 'Quitar imagen', 'tema-viera-abogados' ); ?>
					</button>
				</div>
				<button type="button" class="button" onclick="tema_viera_upload_sector_media('sector_img_<?php echo esc_attr( $index ); ?>')">
					<?php esc_html_e( 'Subir Imagen', 'tema-viera-abogados' ); ?>
				</button>
			</div>
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

	// Procesar Logo
	if ( isset( $_POST['logo'] ) ) {
		update_option( 'tema_viera_abogados_logo', intval( $_POST['logo'] ) );
	}

	// Procesar Hero
	if ( isset( $_POST['hero_overline'] ) ) {
		update_option( 'tema_viera_abogados_hero_overline', sanitize_text_field( $_POST['hero_overline'] ) );
	}
	if ( isset( $_POST['hero_titulo'] ) ) {
		update_option( 'tema_viera_abogados_hero_titulo', sanitize_text_field( $_POST['hero_titulo'] ) );
	}
	if ( isset( $_POST['hero_subtitulo'] ) ) {
		update_option( 'tema_viera_abogados_hero_subtitulo', wp_kses_post( $_POST['hero_subtitulo'] ) );
	}
	if ( isset( $_POST['hero_imagen'] ) ) {
		update_option( 'tema_viera_abogados_hero_imagen', intval( $_POST['hero_imagen'] ) );
	}
	if ( isset( $_POST['hero_btn1_texto'] ) ) {
		update_option( 'tema_viera_abogados_hero_btn1_texto', sanitize_text_field( $_POST['hero_btn1_texto'] ) );
	}
	if ( isset( $_POST['hero_btn2_texto'] ) ) {
		update_option( 'tema_viera_abogados_hero_btn2_texto', sanitize_text_field( $_POST['hero_btn2_texto'] ) );
	}
	if ( isset( $_POST['awards_logos'] ) ) {
		$decoded = json_decode( wp_unslash( $_POST['awards_logos'] ), true );
		update_option( 'tema_viera_abogados_awards_logos', is_array( $decoded ) ? array_map( 'intval', $decoded ) : array() );
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
			'detalles'    => isset( $servicio['detalles'] ) ? sanitize_textarea_field( $servicio['detalles'] ) : '',
		);
		}
		update_option( 'tema_viera_abogados_servicios_items', $servicios_items );
	}

	// Procesar Texto Animado
	if ( isset( $_POST['texto_animado_1'] ) ) {
		update_option( 'tema_viera_abogados_texto_animado_1', sanitize_text_field( $_POST['texto_animado_1'] ) );
	}
	if ( isset( $_POST['texto_animado_2'] ) ) {
		update_option( 'tema_viera_abogados_texto_animado_2', sanitize_text_field( $_POST['texto_animado_2'] ) );
	}

	// Procesar Abogados
	if ( isset( $_POST['abogados_titulo'] ) ) {
		update_option( 'tema_viera_abogados_abogados_titulo', sanitize_text_field( $_POST['abogados_titulo'] ) );
	}
	if ( isset( $_POST['abogados_subtitulo'] ) ) {
		update_option( 'tema_viera_abogados_abogados_subtitulo', sanitize_text_field( $_POST['abogados_subtitulo'] ) );
	}

	// Procesar Experiencia / Sectores
	if ( isset( $_POST['exp_pre_titulo'] ) ) {
		update_option( 'tema_viera_abogados_exp_pre_titulo', sanitize_text_field( $_POST['exp_pre_titulo'] ) );
	}
	if ( isset( $_POST['exp_titulo'] ) ) {
		update_option( 'tema_viera_abogados_exp_titulo', sanitize_text_field( $_POST['exp_titulo'] ) );
	}
	if ( isset( $_POST['exp_subtitulo'] ) ) {
		update_option( 'tema_viera_abogados_exp_subtitulo', sanitize_text_field( $_POST['exp_subtitulo'] ) );
	}
	if ( isset( $_POST['sectores'] ) ) {
		$sectores_items = array();
		foreach ( $_POST['sectores'] as $sector ) {
			$sectores_items[] = array(
				'titulo'      => sanitize_text_field( $sector['titulo'] ),
				'descripcion' => isset( $sector['descripcion'] ) ? wp_kses_post( $sector['descripcion'] ) : '',
				'imagen'      => isset( $sector['imagen'] ) ? intval( $sector['imagen'] ) : 0,
			);
		}
		update_option( 'tema_viera_abogados_sectores_items', $sectores_items );
	}

	// Procesar Clientes
	if ( isset( $_POST['clientes_titulo'] ) ) {
		update_option( 'tema_viera_abogados_clientes_titulo', sanitize_text_field( $_POST['clientes_titulo'] ) );
	}
	if ( isset( $_POST['clientes_logos'] ) ) {
		$decoded = json_decode( wp_unslash( $_POST['clientes_logos'] ), true );
		update_option( 'tema_viera_abogados_clientes_logos', is_array( $decoded ) ? array_map( 'intval', $decoded ) : array() );
	}

	// Procesar Contacto
	if ( isset( $_POST['contacto_direccion'] ) ) {
		update_option( 'tema_viera_abogados_contacto_direccion', sanitize_text_field( $_POST['contacto_direccion'] ) );
	}
	if ( isset( $_POST['contacto_telefono'] ) ) {
		update_option( 'tema_viera_abogados_contacto_telefono', sanitize_text_field( $_POST['contacto_telefono'] ) );
	}
	if ( isset( $_POST['contacto_email'] ) ) {
		update_option( 'tema_viera_abogados_contacto_email', sanitize_email( $_POST['contacto_email'] ) );
	}

	// Procesar Equipo / Fundador
	if ( isset( $_POST['equipo_pre_titulo'] ) ) {
		update_option( 'tema_viera_abogados_equipo_pre', sanitize_text_field( $_POST['equipo_pre_titulo'] ) );
	}
	if ( isset( $_POST['equipo_titulo'] ) ) {
		update_option( 'tema_viera_abogados_equipo_titulo', sanitize_text_field( $_POST['equipo_titulo'] ) );
	}
	if ( isset( $_POST['equipo_enlace_txt'] ) ) {
		update_option( 'tema_viera_abogados_equipo_enlace_txt', sanitize_text_field( $_POST['equipo_enlace_txt'] ) );
	}
	if ( isset( $_POST['equipo_enlace_url'] ) ) {
		update_option( 'tema_viera_abogados_equipo_enlace_url', esc_url_raw( $_POST['equipo_enlace_url'] ) );
	}
	if ( isset( $_POST['fundador_post_id'] ) ) {
		update_option( 'tema_viera_abogados_fundador_post_id', intval( $_POST['fundador_post_id'] ) );
	}
	if ( isset( $_POST['equipo_seleccionados'] ) && is_array( $_POST['equipo_seleccionados'] ) ) {
		$seleccionados = array_map( 'intval', $_POST['equipo_seleccionados'] );
		$seleccionados = array_filter( $seleccionados, function( $id ) { return $id > 0; } );
		update_option( 'tema_viera_abogados_equipo_seleccionados', array_values( $seleccionados ) );
	} else {
		update_option( 'tema_viera_abogados_equipo_seleccionados', array() );
	}

	// Procesar KPIs
	if ( isset( $_POST['kpi_1_prefix'] ) ) {
		update_option( 'tema_viera_abogados_kpi_1_prefix', sanitize_text_field( $_POST['kpi_1_prefix'] ) );
	}
	if ( isset( $_POST['kpi_1_num'] ) ) {
		$kpi_1_num = preg_replace( '/[^0-9]/', '', $_POST['kpi_1_num'] );
		update_option( 'tema_viera_abogados_kpi_1_num', $kpi_1_num !== '' ? $kpi_1_num : '0' );
	}
	if ( isset( $_POST['kpi_1_suffix'] ) ) {
		update_option( 'tema_viera_abogados_kpi_1_suffix', sanitize_text_field( $_POST['kpi_1_suffix'] ) );
	}
	if ( isset( $_POST['kpi_1_label'] ) ) {
		update_option( 'tema_viera_abogados_kpi_1_label', sanitize_text_field( $_POST['kpi_1_label'] ) );
	}
	if ( isset( $_POST['kpi_2_prefix'] ) ) {
		update_option( 'tema_viera_abogados_kpi_2_prefix', sanitize_text_field( $_POST['kpi_2_prefix'] ) );
	}
	if ( isset( $_POST['kpi_2_num'] ) ) {
		$kpi_2_num = preg_replace( '/[^0-9]/', '', $_POST['kpi_2_num'] );
		update_option( 'tema_viera_abogados_kpi_2_num', $kpi_2_num !== '' ? $kpi_2_num : '0' );
	}
	if ( isset( $_POST['kpi_2_suffix'] ) ) {
		update_option( 'tema_viera_abogados_kpi_2_suffix', sanitize_text_field( $_POST['kpi_2_suffix'] ) );
	}
	if ( isset( $_POST['kpi_2_label'] ) ) {
		update_option( 'tema_viera_abogados_kpi_2_label', sanitize_text_field( $_POST['kpi_2_label'] ) );
	}
	if ( isset( $_POST['kpi_3_prefix'] ) ) {
		update_option( 'tema_viera_abogados_kpi_3_prefix', sanitize_text_field( $_POST['kpi_3_prefix'] ) );
	}
	if ( isset( $_POST['kpi_3_num'] ) ) {
		$kpi_3_num = preg_replace( '/[^0-9]/', '', $_POST['kpi_3_num'] );
		update_option( 'tema_viera_abogados_kpi_3_num', $kpi_3_num !== '' ? $kpi_3_num : '0' );
	}
	if ( isset( $_POST['kpi_3_suffix'] ) ) {
		update_option( 'tema_viera_abogados_kpi_3_suffix', sanitize_text_field( $_POST['kpi_3_suffix'] ) );
	}
	if ( isset( $_POST['kpi_3_label'] ) ) {
		update_option( 'tema_viera_abogados_kpi_3_label', sanitize_text_field( $_POST['kpi_3_label'] ) );
	}

	// Procesar Agenda / Cita
	if ( isset( $_POST['agenda_pre_titulo'] ) ) {
		update_option( 'tema_viera_abogados_agenda_pre', sanitize_text_field( $_POST['agenda_pre_titulo'] ) );
	}
	if ( isset( $_POST['agenda_titulo'] ) ) {
		update_option( 'tema_viera_abogados_agenda_titulo', sanitize_text_field( $_POST['agenda_titulo'] ) );
	}
	if ( isset( $_POST['agenda_desc'] ) ) {
		update_option( 'tema_viera_abogados_agenda_desc', wp_kses_post( $_POST['agenda_desc'] ) );
	}
	if ( isset( $_POST['agenda_btn_txt'] ) ) {
		update_option( 'tema_viera_abogados_agenda_btn_txt', sanitize_text_field( $_POST['agenda_btn_txt'] ) );
	}
	if ( isset( $_POST['agenda_btn_url'] ) ) {
		update_option( 'tema_viera_abogados_agenda_btn_url', esc_url_raw( $_POST['agenda_btn_url'] ) );
	}

	// Procesar Noticias
	if ( isset( $_POST['noticias_pre_titulo'] ) ) {
		update_option( 'tema_viera_abogados_noticias_pre', sanitize_text_field( $_POST['noticias_pre_titulo'] ) );
	}
	if ( isset( $_POST['noticias_titulo'] ) ) {
		update_option( 'tema_viera_abogados_noticias_titulo', sanitize_text_field( $_POST['noticias_titulo'] ) );
	}
	if ( isset( $_POST['noticias_btn'] ) ) {
		update_option( 'tema_viera_abogados_noticias_btn', sanitize_text_field( $_POST['noticias_btn'] ) );
	}

	// Procesar Redes Sociales
	if ( isset( $_POST['social_ig'] ) ) {
		update_option( 'tema_viera_abogados_social_ig', esc_url_raw( $_POST['social_ig'] ) );
	}
	if ( isset( $_POST['social_in'] ) ) {
		update_option( 'tema_viera_abogados_social_in', esc_url_raw( $_POST['social_in'] ) );
	}
}
