<?php
/**
 * Componente: Card de Abogado
 *
 * Muestra un card individual de un abogado con su foto, nombre y especialidad
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id      = get_the_ID();
$especialidad = tema_viera_get_abogado_meta( $post_id, 'especialidad' );
?>

<article class="card">
	<?php
	if ( has_post_thumbnail() ) {
		?>
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'abogado-card', array( 'class' => 'card-image' ) ); ?>
		</a>
		<?php
	}
	?>

	<div class="card-content">
		<h3 class="card-title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h3>

		<?php if ( $especialidad ) : ?>
			<p class="card-meta"><?php echo esc_html( $especialidad ); ?></p>
		<?php endif; ?>

		<div style="margin-top: var(--spacing-md);">
			<a href="<?php the_permalink(); ?>" class="btn btn-primary">
				<?php esc_html_e( 'Ver Perfil', 'tema-viera-abogados' ); ?>
			</a>
		</div>
	</div>
</article>
