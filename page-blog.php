<?php
/**
 * Template Name: Blog
 *
 * Página de blog con encabezado, filtros por categoría, noticia principal,
 * grilla de artículos y botón "cargar más".
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$categoria_actual = isset( $_GET['cat'] ) ? sanitize_title( wp_unslash( $_GET['cat'] ) ) : '';
$categorias       = tema_viera_blog_filtros();

$query    = tema_viera_blog_query( $categoria_actual );
$posts    = $query->posts;
$featured = ! empty( $posts ) ? array_shift( $posts ) : null;
$grid     = array_slice( $posts, 0, 6 );
$tiene_mas = count( $posts ) > 6;
$total_restantes = count( $posts );
?>

<section class="blog-hero">
	<div class="container">
		<div class="blog-hero-frame">
			<span class="blog-hero-eyebrow"><?php echo esc_html( tema_viera_t( 'BLOG' ) ); ?></span>
			<h1 class="blog-hero-title"><?php echo esc_html( tema_viera_t( 'Casos, noticias y actualidad legal' ) ); ?></h1>
			<p class="blog-hero-desc"><?php echo esc_html( tema_viera_t( 'Análisis, novedades regulatorias y actualizaciones de nuestro equipo sobre los temas legales más relevantes para tu empresa.' ) ); ?></p>
		</div>
	</div>
</section>

<section class="blog-filters">
	<div class="container">
		<div class="blog-filters-row" id="blog-filters">
			<button type="button" class="blog-filter<?php echo '' === $categoria_actual ? ' is-active' : ''; ?>" data-cat="">
				<?php echo esc_html( tema_viera_t( 'Todos' ) ); ?>
			</button>
			<?php foreach ( $categorias as $cat ) : ?>
				<button type="button" class="blog-filter<?php echo $categoria_actual === $cat['slug'] ? ' is-active' : ''; ?>" data-cat="<?php echo esc_attr( $cat['slug'] ); ?>">
					<?php echo esc_html( $cat['name'] ); ?>
				</button>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="blog-content">
	<div class="container">

		<div class="blog-featured-wrap" id="blog-featured">
			<?php if ( $featured ) : ?>
				<?php tema_viera_blog_render_featured( $featured ); ?>
			<?php endif; ?>
		</div>

		<div class="blog-grid" id="blog-grid">
			<?php foreach ( $grid as $p ) : ?>
				<?php tema_viera_blog_render_card( $p ); ?>
			<?php endforeach; ?>
		</div>

		<?php if ( ! $featured && empty( $grid ) ) : ?>
			<div class="blog-empty">
				<p><?php esc_html_e( 'No hay noticias publicadas todavía.', 'tema-viera-abogados' ); ?></p>
			</div>
		<?php endif; ?>

		<div class="blog-action" id="blog-action" <?php echo $tiene_mas ? '' : 'hidden'; ?>>
			<button type="button" class="blog-btn-cargar" id="blog-btn-cargar"
				data-cat="<?php echo esc_attr( $categoria_actual ); ?>"
				data-offset="6"
				data-total="<?php echo esc_attr( $total_restantes ); ?>">
				<?php echo esc_html( tema_viera_t( 'CARGAR MÁS ARTÍCULOS' ) ); ?>
			</button>
		</div>

	</div>
</section>

<?php
get_footer();
