<?php
/**
 * Componente: Header
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<header>
	<div class="container">
		<div class="header-content">
			<div class="logo">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php bloginfo( 'name' ); ?>
					</a>
					<?php
				}
				?>
			</div>

			<nav>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary-menu',
					'fallback_cb'    => function() {
						echo '<ul>';
						echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Inicio', 'tema-viera-abogados' ) . '</a></li>';
						echo '<li><a href="#sobre-nosotros">' . esc_html__( 'Sobre Nosotros', 'tema-viera-abogados' ) . '</a></li>';
						echo '<li><a href="#servicios">' . esc_html__( 'Servicios', 'tema-viera-abogados' ) . '</a></li>';
						echo '<li><a href="#abogados">' . esc_html__( 'Nuestro Equipo', 'tema-viera-abogados' ) . '</a></li>';
						echo '<li><a href="#contacto">' . esc_html__( 'Contacto', 'tema-viera-abogados' ) . '</a></li>';
						echo '</ul>';
					},
					'container'      => false,
				) );
				?>
			</nav>
		</div>
	</div>
</header>
