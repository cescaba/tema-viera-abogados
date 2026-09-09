<?php
/**
 * Template Name: Términos y Condiciones
 *
 * Página legal con encabezado, índice (TOC) fijo y contenido por secciones.
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pre       = tema_viera_t( tema_viera_get_terminos_option( 'pre' ) );
$titulo    = tema_viera_t( tema_viera_get_terminos_option( 'titulo' ) );
$fecha     = tema_viera_t( tema_viera_get_terminos_option( 'fecha' ) );
$toc       = tema_viera_t( tema_viera_get_terminos_option( 'toc' ) );
$intro     = tema_viera_t( tema_viera_get_terminos_option( 'intro' ) );
$secciones = tema_viera_get_terminos_option( 'secciones' );

if ( ! is_array( $secciones ) ) {
	$secciones = array();
}
?>

<section class="terminos-hero">
	<div class="container">
		<?php if ( $pre ) : ?>
			<span class="terminos-pre"><?php echo esc_html( $pre ); ?></span>
		<?php endif; ?>

		<?php if ( $titulo ) : ?>
			<h1 class="terminos-titulo"><?php echo esc_html( $titulo ); ?></h1>
		<?php endif; ?>

		<?php if ( $fecha ) : ?>
			<p class="terminos-fecha"><?php echo esc_html( $fecha ); ?></p>
		<?php endif; ?>
	</div>
</section>

<div class="container">
	<div class="terminos-layout">

		<aside class="terminos-toc">
			<?php if ( $toc ) : ?>
				<span class="terminos-toc-titulo"><?php echo esc_html( $toc ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $secciones ) ) : ?>
				<nav class="terminos-toc-nav">
					<?php foreach ( $secciones as $index => $seccion ) :
						$seccion_titulo = tema_viera_t( isset( $seccion['titulo'] ) ? $seccion['titulo'] : '' );
						if ( '' === trim( $seccion_titulo ) ) {
							continue;
						}
						$anchor = 'termino-' . ( $index + 1 );
					?>
						<a href="#<?php echo esc_attr( $anchor ); ?>" class="terminos-toc-link"><?php echo esc_html( $seccion_titulo ); ?></a>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>
		</aside>

		<article class="terminos-article">
			<?php if ( $intro ) : ?>
				<p class="terminos-intro"><?php echo wp_kses_post( $intro ); ?></p>
			<?php endif; ?>

			<?php foreach ( $secciones as $index => $seccion ) :
				$seccion_titulo   = tema_viera_t( isset( $seccion['titulo'] ) ? $seccion['titulo'] : '' );
				$seccion_contenido = isset( $seccion['contenido'] ) ? $seccion['contenido'] : '';
				if ( '' === trim( $seccion_titulo ) && '' === trim( wp_strip_all_tags( $seccion_contenido ) ) ) {
					continue;
				}
				$anchor = 'termino-' . ( $index + 1 );
			?>
				<section id="<?php echo esc_attr( $anchor ); ?>" class="terminos-block">
					<?php if ( '' !== trim( $seccion_titulo ) ) : ?>
						<h2 class="terminos-block-titulo"><?php echo esc_html( ( $index + 1 ) . '. ' . $seccion_titulo ); ?></h2>
					<?php endif; ?>

					<div class="terminos-block-contenido">
						<?php echo wp_kses_post( $seccion_contenido ); ?>
					</div>
				</section>
			<?php endforeach; ?>
		</article>

	</div>
</div>

<?php
get_footer();
