<?php
/**
 * Plantilla: Categoría Destacados
 *
 * Página de archivo para la categoría "Destacados"
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="container" style="padding-top: var(--spacing-2xl); padding-bottom: var(--spacing-2xl);">

	<header style="margin-bottom: var(--spacing-2xl);">
		<?php
		$destacados_term = get_term_by( 'slug', 'destacados', 'category' );
		?>
		<span style="display:block; font-size:10px; font-weight:bold; letter-spacing:3px; text-transform:uppercase; color:var(--color-primary); margin-bottom:10px;">
			<?php esc_html_e( 'MÁS SOBRE NOSOTROS', 'tema-viera-abogados' ); ?>
		</span>
		<h1 style="font-family:var(--font-main); font-size:32px; color:var(--color-primary); text-transform:uppercase; font-weight:300; margin:0;">
			<?php single_cat_title(); ?>
		</h1>
	</header>

	<?php
	if ( have_posts() ) :
		?>
		<div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap:30px;">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article style="background:var(--color-white); border:1px solid var(--color-border, #e0e0e0); border-radius:8px; overflow:hidden; transition: transform 0.3s ease, box-shadow 0.3s ease;">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" style="display:block;">
							<?php the_post_thumbnail( 'medium_large', array(
								'style' => 'width:100%; height:220px; object-fit:cover; display:block;',
								'class'  => 'noticia-thumb',
							) ); ?>
						</a>
					<?php endif; ?>

					<div style="padding: 24px;">
						<div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
							<?php
							$cats_list = get_the_category();
							if ( ! empty( $cats_list ) ) :
								?>
								<span style="font-size:10px; font-weight:bold; letter-spacing:2px; text-transform:uppercase; color:var(--color-primary);">
									<?php echo esc_html( $cats_list[0]->name ); ?>
								</span>
							<?php endif; ?>
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" style="font-size:12px; color:var(--color-text-light, #888);">
								<?php echo esc_html( get_the_date() ); ?>
							</time>
						</div>

						<h2 style="font-family:var(--font-main); font-size:18px; color:var(--color-primary); margin:0 0 12px 0; line-height:1.4;">
							<a href="<?php the_permalink(); ?>" style="text-decoration:none; color:inherit;">
								<?php the_title(); ?>
							</a>
						</h2>

						<p style="font-size:14px; color:var(--color-text-light, #666); line-height:1.6; margin-bottom:16px;">
							<?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?>
						</p>

						<a href="<?php the_permalink(); ?>" style="display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:var(--color-primary); text-decoration:none; border-bottom:1px solid var(--color-primary); padding-bottom:4px;">
							<?php esc_html_e( 'LEER MÁS', 'tema-viera-abogados' ); ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
								<path d="M5 10L8 7L5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</a>
					</div>
				</article>
				<?php
			endwhile;
			?>
		</div>

		<div style="margin-top: var(--spacing-2xl);">
			<?php
			the_posts_pagination( array(
				'mid_size'           => 2,
				'prev_text'          => esc_html__( '&laquo; Anterior', 'tema-viera-abogados' ),
				'next_text'          => esc_html__( 'Siguiente &raquo;', 'tema-viera-abogados' ),
				'screen_reader_text' => esc_html__( 'Navegación de noticias', 'tema-viera-abogados' ),
			) );
			?>
		</div>
		<?php
	else :
		?>
		<div style="text-align: center; padding: var(--spacing-3xl) 0;">
			<h2><?php esc_html_e( 'No hay noticias destacadas todavía', 'tema-viera-abogados' ); ?></h2>
			<p style="color: var(--color-text-light, #888); margin-top: var(--spacing-lg);">
				<?php esc_html_e( 'Vuelve pronto para ver las noticias y casos destacados.', 'tema-viera-abogados' ); ?>
			</p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-outline-dark" style="margin-top: var(--spacing-lg);">
				<?php esc_html_e( 'Volver al inicio', 'tema-viera-abogados' ); ?>
			</a>
		</div>
		<?php
	endif;
	?>
</div>

<?php
get_footer();
