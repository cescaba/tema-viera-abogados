<?php
/**
 * Plantilla: Single Abogado
 *
 * Página individual de cada abogado con su información completa
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		$post_id      = get_the_ID();
		$especialidad = tema_viera_get_abogado_meta( $post_id, 'especialidad' );
		$email        = tema_viera_get_abogado_meta( $post_id, 'email' );
		$telefono     = tema_viera_get_abogado_meta( $post_id, 'telefono' );
		$linkedin     = tema_viera_get_abogado_meta( $post_id, 'linkedin' );
		$biografia    = tema_viera_get_abogado_meta( $post_id, 'biografia' );
		?>

		<article class="single-abogado">
			<div class="container">
				<!-- Breadcrumbs -->
				<nav style="margin-bottom: var(--spacing-lg); color: var(--color-text-light);">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Inicio', 'tema-viera-abogados' ); ?></a>
					<span> / </span>
					<span><?php the_title(); ?></span>
				</nav>

				<div class="row-2">
					<!-- Imagen y Información de Contacto -->
					<div>
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'abogado-single', array(
								'class' => 'card-image',
								'style' => 'border-radius: 8px; margin-bottom: var(--spacing-lg);',
							) );
						}
						?>

						<div style="background: var(--color-light); padding: var(--spacing-lg); border-radius: 8px;">
							<?php if ( $especialidad ) : ?>
								<div style="margin-bottom: var(--spacing-md);">
									<h3 style="color: var(--color-primary); margin-bottom: 5px;">
										<?php esc_html_e( 'Especialidad', 'tema-viera-abogados' ); ?>
									</h3>
									<p><?php echo esc_html( $especialidad ); ?></p>
								</div>
							<?php endif; ?>

							<?php if ( $email ) : ?>
								<div style="margin-bottom: var(--spacing-md);">
									<h3 style="color: var(--color-primary); margin-bottom: 5px;">
										<?php esc_html_e( 'Email', 'tema-viera-abogados' ); ?>
									</h3>
									<p>
										<a href="<?php echo esc_attr( 'mailto:' . $email ); ?>">
											<?php echo esc_html( $email ); ?>
										</a>
									</p>
								</div>
							<?php endif; ?>

							<?php if ( $telefono ) : ?>
								<div style="margin-bottom: var(--spacing-md);">
									<h3 style="color: var(--color-primary); margin-bottom: 5px;">
										<?php esc_html_e( 'Teléfono', 'tema-viera-abogados' ); ?>
									</h3>
									<p>
										<a href="<?php echo esc_attr( 'tel:' . $telefono ); ?>">
											<?php echo esc_html( $telefono ); ?>
										</a>
									</p>
								</div>
							<?php endif; ?>

							<?php if ( $linkedin ) : ?>
								<div>
									<h3 style="color: var(--color-primary); margin-bottom: 5px;">
										<?php esc_html_e( 'LinkedIn', 'tema-viera-abogados' ); ?>
									</h3>
									<p>
										<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer">
											<?php esc_html_e( 'Ver Perfil', 'tema-viera-abogados' ); ?>
										</a>
									</p>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<!-- Contenido Principal -->
					<div>
						<h1><?php the_title(); ?></h1>

						<?php if ( $especialidad ) : ?>
							<p style="color: var(--color-secondary); font-weight: 600; font-size: var(--font-size-lg); margin-bottom: var(--spacing-lg);">
								<?php echo esc_html( $especialidad ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $biografia ) : ?>
							<div class="section-content" style="line-height: 1.8;">
								<?php echo wp_kses_post( $biografia ); ?>
							</div>
						<?php endif; ?>

						<div style="margin-top: var(--spacing-2xl);">
							<a href="<?php echo esc_url( home_url( '/#abogados' ) ); ?>" class="btn btn-secondary">
								<?php esc_html_e( 'Volver al Equipo', 'tema-viera-abogados' ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</article>

		<?php
	}
}

get_footer();
