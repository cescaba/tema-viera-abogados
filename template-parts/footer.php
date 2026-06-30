<?php
/**
 * Componente: Footer
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contacto_titulo   = get_option( 'tema_viera_abogados_contacto_titulo', esc_html__( 'Contacto', 'tema-viera-abogados' ) );
$contacto_telefono = get_option( 'tema_viera_abogados_contacto_telefono', '' );
$contacto_email    = get_option( 'tema_viera_abogados_contacto_email', '' );
$contacto_direccion = get_option( 'tema_viera_abogados_contacto_direccion', '' );
?>

<footer>
	<div class="container">
		<div class="footer-content">
			<!-- Sección Sobre Nosotros en Footer -->
			<div class="footer-section">
				<h3><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h3>
				<p><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
			</div>

			<!-- Sección Enlaces -->
			<div class="footer-section">
				<h3><?php esc_html_e( 'Enlaces', 'tema-viera-abogados' ); ?></h3>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer-menu',
					'fallback_cb'    => function() {
						echo '<ul>';
						echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Inicio', 'tema-viera-abogados' ) . '</a></li>';
						echo '<li><a href="#sobre-nosotros">' . esc_html__( 'Sobre Nosotros', 'tema-viera-abogados' ) . '</a></li>';
						echo '<li><a href="#servicios">' . esc_html__( 'Servicios', 'tema-viera-abogados' ) . '</a></li>';
						echo '<li><a href="#abogados">' . esc_html__( 'Nuestro Equipo', 'tema-viera-abogados' ) . '</a></li>';
						echo '</ul>';
					},
					'container'      => false,
				) );
				?>
			</div>

			<!-- Sección Contacto -->
			<div class="footer-section">
				<h3><?php esc_html_e( 'Contacto', 'tema-viera-abogados' ); ?></h3>
				<ul>
					<?php if ( $contacto_direccion ) : ?>
						<li><?php echo esc_html( $contacto_direccion ); ?></li>
					<?php endif; ?>
					<?php if ( $contacto_telefono ) : ?>
						<li>
							<a href="<?php echo esc_attr( 'tel:' . $contacto_telefono ); ?>">
								<?php echo esc_html( $contacto_telefono ); ?>
							</a>
						</li>
					<?php endif; ?>
					<?php if ( $contacto_email ) : ?>
						<li>
							<a href="<?php echo esc_attr( 'mailto:' . $contacto_email ); ?>">
								<?php echo esc_html( $contacto_email ); ?>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<div class="footer-bottom">
			<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'Todos los derechos reservados.', 'tema-viera-abogados' ); ?></p>
		</div>
	</div>
</footer>
