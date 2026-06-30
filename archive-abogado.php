<?php
/**
 * Plantilla: Archive Abogados
 *
 * Página de archivo/listado de todos los abogados
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
	<h1 style="margin-bottom: var(--spacing-xl);">
		<?php post_type_archive_title(); ?>
	</h1>

	<?php
	if ( have_posts() ) {
		?>
		<div class="row-3">
			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/abogado-card' );
			}
			?>
		</div>

		<?php
		the_posts_pagination( array(
			'mid_size' => 2,
			'prev_text' => esc_html__( '&laquo; Anterior', 'tema-viera-abogados' ),
			'next_text' => esc_html__( 'Siguiente &raquo;', 'tema-viera-abogados' ),
		) );
	} else {
		?>
		<p><?php esc_html_e( 'No hay abogados para mostrar.', 'tema-viera-abogados' ); ?></p>
		<?php
	}
	?>
</div>

<?php
get_footer();
