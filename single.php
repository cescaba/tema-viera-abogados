<?php
/**
 * Plantilla: Single Post (Noticia)
 *
 * Página de detalle de cada noticia/caso destacado
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		$post_id        = get_the_ID();
		$subtitulo      = tema_viera_post_meta_t( $post_id, '_post_subtitulo' );
		$area_practica  = tema_viera_post_meta_t( $post_id, '_post_area_practica' );
		$bg_img_url     = has_post_thumbnail() ? get_the_post_thumbnail_url( $post_id, 'full' ) : '';
		?>

		<article class="single-noticia">

			<section class="hero-viera single-noticia-hero" <?php echo $bg_img_url ? 'style="background: linear-gradient(90deg, rgba(7, 17, 44, 0.89) 31.45%, rgba(7, 17, 44, 0) 55.01%), url(\'' . esc_url( $bg_img_url ) . '\'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 420px;"' : 'style="background: linear-gradient(90deg, rgba(7, 17, 44, 0.89) 31.45%, rgba(7, 17, 44, 0) 55.01%); min-height: 420px;"'; ?>>
				
				<div class="hero-overlay"></div>

				<div class="container hero-container" style="display:flex; align-items:flex-end; min-height:420px;">
					<div class="hero-content-box reveal" style="padding-bottom:60px;">
						
						<nav style="margin-bottom:24px;">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:rgba(255,255,255,0.6); text-decoration:none; font-size:14px;">
								<?php esc_html_e( 'Inicio', 'tema-viera-abogados' ); ?>
							</a>
							<span style="color:rgba(255,255,255,0.6); margin:0 8px;">/</span>
							<a href="<?php echo esc_url( get_category_link( get_cat_ID( 'Destacados' ) ) ); ?>" style="color:rgba(255,255,255,0.6); text-decoration:none; font-size:14px;">
								<?php esc_html_e( 'Destacados', 'tema-viera-abogados' ); ?>
							</a>
						</nav>

						<?php if ( $subtitulo ) : ?>
							<span class="hero-overline"><?php echo esc_html( $subtitulo ); ?></span>
						<?php endif; ?>

						<h1 class="hero-title"><?php echo esc_html( tema_viera_post_titulo( $post_id ) ); ?></h1>

						<div class="hero-subtitle-wrapper">
							<hr class="hero-divider">
							<div style="display:flex; gap:20px; flex-wrap:wrap;">
								<?php if ( $area_practica ) : ?>
									<p class="hero-subtitle" style="display:flex; align-items:center; gap:6px;">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
											<path d="M8 14.5C8 14.5 13 10.5 13 6.5C13 3.73858 10.7614 1.5 8 1.5C5.23858 1.5 3 3.73858 3 6.5C3 10.5 8 14.5 8 14.5Z" stroke="currentColor" stroke-width="1.5"/>
											<circle cx="8" cy="6.5" r="1.5" stroke="currentColor" stroke-width="1.5"/>
										</svg>
										<?php echo esc_html( $area_practica ); ?>
									</p>
								<?php endif; ?>
								<p class="hero-subtitle" style="display:flex; align-items:center; gap:6px;">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
										<rect x="2" y="3" width="12" height="11" rx="1.5" stroke="currentColor" stroke-width="1.5"/>
										<path d="M2 6.5H14" stroke="currentColor" stroke-width="1.5"/>
										<path d="M5.5 1.5V4.5M10.5 1.5V4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
									</svg>
									<?php echo esc_html( get_the_date() ); ?>
								</p>
							</div>
						</div>

					</div>
				</div>
			</section>

			<section style="padding:80px 0; background:var(--color-white);">
				<div class="container" style="max-width:800px; margin:0 auto;">
					<div class="section-content reveal" style="font-size:16px; line-height:1.8; color:var(--color-text, #333);">
						<?php echo apply_filters( 'the_content', tema_viera_post_contenido_t( $post_id ) ); ?>
					</div>

					<div style="margin-top:60px; padding-top:30px; border-top:1px solid var(--color-border, #e0e0e0); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px;">
						<a href="<?php echo esc_url( get_category_link( get_cat_ID( 'Destacados' ) ) ); ?>" style="display:inline-flex; align-items:center; gap:8px; color:var(--color-primary); text-decoration:none; font-size:14px; font-weight:600;">
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
								<path d="M15 10H5M5 10L10 15M5 10L10 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<?php esc_html_e( 'Volver a Destacados', 'tema-viera-abogados' ); ?>
						</a>
					</div>
				</div>
			</section>

		</article>

		<?php
	endwhile;
else :
	?>
	<div class="container" style="padding: var(--spacing-3xl) 0; text-align:center;">
		<h1><?php esc_html_e( 'Noticia no encontrada', 'tema-viera-abogados' ); ?></h1>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="display:inline-block; margin-top:var(--spacing-lg);">
			<?php esc_html_e( 'Volver al inicio', 'tema-viera-abogados' ); ?>
		</a>
	</div>
	<?php
endif;

get_footer();
