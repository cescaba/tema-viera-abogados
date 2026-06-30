<?php
/**
 * Plantilla: Front Page
 *
 * Página de inicio / Landing page con todas las secciones editables
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Obtener opciones de la landing
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

// Obtener URLs de imágenes
$hero_imagen_url       = $hero_imagen_id ? wp_get_attachment_url( $hero_imagen_id ) : '';
$sobre_imagen_url      = $sobre_imagen_id ? wp_get_attachment_url( $sobre_imagen_id ) : '';
?>

<!-- ========================================
	 SECCIÓN HERO
	 ======================================== -->
<section class="hero" <?php echo $hero_imagen_url ? 'style="background-image: url(\'' . esc_url( $hero_imagen_url ) . '\');"' : ''; ?>>
	<div class="hero-content">
		<?php if ( $hero_titulo ) : ?>
			<h1><?php echo esc_html( $hero_titulo ); ?></h1>
		<?php endif; ?>

		<?php if ( $hero_subtitulo ) : ?>
			<p class="subtitle"><?php echo wp_kses_post( $hero_subtitulo ); ?></p>
		<?php endif; ?>

		<?php if ( $hero_btn_texto && $hero_btn_url ) : ?>
			<a href="<?php echo esc_url( $hero_btn_url ); ?>" class="btn btn-primary">
				<?php echo esc_html( $hero_btn_texto ); ?>
			</a>
		<?php endif; ?>
	</div>
</section>

<!-- ========================================
	 SECCIÓN SOBRE NOSOTROS
	 ======================================== -->
<?php if ( $sobre_titulo || $sobre_contenido || $sobre_imagen_url ) : ?>
	<section id="sobre-nosotros">
		<div class="container">
			<div class="row-2">
				<div>
					<?php if ( $sobre_titulo ) : ?>
						<h2 class="section-title"><?php echo esc_html( $sobre_titulo ); ?></h2>
					<?php endif; ?>

					<?php if ( $sobre_contenido ) : ?>
						<div class="section-content">
							<?php echo wp_kses_post( $sobre_contenido ); ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $sobre_imagen_url ) : ?>
					<div>
						<img src="<?php echo esc_url( $sobre_imagen_url ); ?>" alt="<?php echo esc_attr( $sobre_titulo ); ?>" style="border-radius: 8px; width: 100%;" />
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- ========================================
	 SECCIÓN SERVICIOS
	 ======================================== -->
<?php if ( $servicios_titulo || ( ! empty( $servicios_items ) && is_array( $servicios_items ) ) ) : ?>
	<section id="servicios">
		<div class="container">
			<?php if ( $servicios_titulo ) : ?>
				<h2 class="section-title"><?php echo esc_html( $servicios_titulo ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $servicios_items ) && is_array( $servicios_items ) ) : ?>
				<div class="row-3">
					<?php foreach ( $servicios_items as $servicio ) : ?>
						<div class="service-card">
							<?php if ( ! empty( $servicio['icono'] ) ) : ?>
								<div class="service-icon">
									<?php echo esc_html( $servicio['icono'] ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $servicio['titulo'] ) ) : ?>
								<h3 class="service-title"><?php echo esc_html( $servicio['titulo'] ); ?></h3>
							<?php endif; ?>

							<?php if ( ! empty( $servicio['descripcion'] ) ) : ?>
								<p class="service-description"><?php echo wp_kses_post( $servicio['descripcion'] ); ?></p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>

<!-- ========================================
	 SECCIÓN ABOGADOS
	 ======================================== -->
<?php
$abogados_query = tema_viera_get_abogados();
if ( $abogados_query->have_posts() ) :
	?>
	<section id="abogados">
		<div class="container">
			<?php if ( $abogados_titulo ) : ?>
				<h2 class="section-title"><?php echo esc_html( $abogados_titulo ); ?></h2>
			<?php endif; ?>

			<?php if ( $abogados_subtitulo ) : ?>
				<p class="section-subtitle"><?php echo esc_html( $abogados_subtitulo ); ?></p>
			<?php endif; ?>

			<div class="row-3">
				<?php
				while ( $abogados_query->have_posts() ) :
					$abogados_query->the_post();
					get_template_part( 'template-parts/abogado-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php
endif;
?>

<!-- ========================================
	 SECCIÓN CONTACTO
	 ======================================== -->
<section id="contacto">
	<div class="container">
		<div class="row-2">
			<div>
				<?php if ( $contacto_titulo ) : ?>
					<h2 class="section-title"><?php echo esc_html( $contacto_titulo ); ?></h2>
				<?php endif; ?>

				<?php if ( $contacto_mensaje ) : ?>
					<div style="margin-bottom: var(--spacing-lg); line-height: 1.8;">
						<?php echo wp_kses_post( $contacto_mensaje ); ?>
					</div>
				<?php endif; ?>

				<div style="margin-bottom: var(--spacing-lg);">
					<?php if ( $contacto_direccion ) : ?>
						<p>
							<strong><?php esc_html_e( 'Dirección:', 'tema-viera-abogados' ); ?></strong><br>
							<?php echo esc_html( $contacto_direccion ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $contacto_telefono ) : ?>
						<p>
							<strong><?php esc_html_e( 'Teléfono:', 'tema-viera-abogados' ); ?></strong><br>
							<a href="<?php echo esc_attr( 'tel:' . $contacto_telefono ); ?>">
								<?php echo esc_html( $contacto_telefono ); ?>
							</a>
						</p>
					<?php endif; ?>

					<?php if ( $contacto_email ) : ?>
						<p>
							<strong><?php esc_html_e( 'Email:', 'tema-viera-abogados' ); ?></strong><br>
							<a href="<?php echo esc_attr( 'mailto:' . $contacto_email ); ?>">
								<?php echo esc_html( $contacto_email ); ?>
							</a>
						</p>
					<?php endif; ?>
				</div>
			</div>

			<div>
				<form method="post" id="contact-form" style="background: var(--color-light); padding: var(--spacing-xl); border-radius: var(--radius-lg);">
					<?php wp_nonce_field( 'contact_form_nonce', 'contact_nonce' ); ?>

					<div class="form-group">
						<label for="contact_name"><?php esc_html_e( 'Nombre', 'tema-viera-abogados' ); ?></label>
						<input type="text" id="contact_name" name="contact_name" required />
					</div>

					<div class="form-group">
						<label for="contact_email_form"><?php esc_html_e( 'Email', 'tema-viera-abogados' ); ?></label>
						<input type="email" id="contact_email_form" name="contact_email_form" required />
					</div>

					<div class="form-group">
						<label for="contact_phone"><?php esc_html_e( 'Teléfono', 'tema-viera-abogados' ); ?></label>
						<input type="tel" id="contact_phone" name="contact_phone" />
					</div>

					<div class="form-group">
						<label for="contact_message"><?php esc_html_e( 'Mensaje', 'tema-viera-abogados' ); ?></label>
						<textarea id="contact_message" name="contact_message" required></textarea>
					</div>

					<button type="submit" class="btn btn-primary">
						<?php esc_html_e( 'Enviar Mensaje', 'tema-viera-abogados' ); ?>
					</button>
				</form>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
