<?php
/**
 * Plantilla: Index (Fallback)
 *
 * Template de fallback para cualquier página que no tenga un template específico
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="container" style="padding: var(--spacing-3xl) 0;">
	<?php
	if ( have_posts() ) {
		if ( is_search() ) {
			?>
			<h1><?php esc_html_e( 'Resultados de búsqueda para: ', 'tema-viera-abogados' ); echo esc_html( get_search_query() ); ?></h1>
			<?php
		} elseif ( is_category() ) {
			single_cat_title( '<h1>' );
			echo '</h1>';
		} elseif ( is_tag() ) {
			single_tag_title( '<h1>', '</h1>' );
		}
		?>

		<div style="margin-top: var(--spacing-2xl);">
			<?php
			while ( have_posts() ) {
				the_post();
				?>
				<article style="margin-bottom: var(--spacing-2xl); padding-bottom: var(--spacing-2xl); border-bottom: 1px solid var(--color-border);">
					<?php
					if ( has_post_thumbnail() ) {
						?>
						<div style="margin-bottom: var(--spacing-lg);">
							<?php the_post_thumbnail( 'medium', array( 'style' => 'max-width: 100%; border-radius: 8px;' ) ); ?>
						</div>
						<?php
					}
					?>

					<h2>
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
					</h2>

					<div style="color: var(--color-text-light); margin-bottom: var(--spacing-md);">
						<?php esc_html_e( 'Publicado en: ', 'tema-viera-abogados' ); ?>
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
							<?php echo esc_html( get_the_date() ); ?>
						</time>
					</div>

					<div>
						<?php the_excerpt(); ?>
					</div>

					<a href="<?php the_permalink(); ?>" class="btn btn-primary" style="margin-top: var(--spacing-lg);">
						<?php esc_html_e( 'Leer Más', 'tema-viera-abogados' ); ?>
					</a>
				</article>
				<?php
			}

			// Paginación
			the_posts_pagination( array(
				'mid_size'      => 2,
				'prev_text'     => esc_html__( '&laquo; Anterior', 'tema-viera-abogados' ),
				'next_text'     => esc_html__( 'Siguiente &raquo;', 'tema-viera-abogados' ),
				'screen_reader_text' => esc_html__( 'Navegación de posts', 'tema-viera-abogados' ),
			) );
		}
		?>
		</div>
		<?php
	} else {
		?>
		<div style="text-align: center; padding: var(--spacing-3xl) 0;">
			<h1><?php esc_html_e( 'No se encontró contenido', 'tema-viera-abogados' ); ?></h1>
			<p style="margin-top: var(--spacing-lg); color: var(--color-text-light);">
				<?php esc_html_e( 'Disculpa, no hay contenido para mostrar.', 'tema-viera-abogados' ); ?>
			</p>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary" style="margin-top: var(--spacing-lg);">
				<?php esc_html_e( 'Volver a Inicio', 'tema-viera-abogados' ); ?>
			</a>
		</div>
		<?php
	}
	?>
</div>

<?php
get_footer();
