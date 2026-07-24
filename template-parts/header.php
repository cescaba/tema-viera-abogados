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

<header class="site-header">
  <div class="container">
    <div class="header-content">
      <div class="logo">
        <?php
        $logo_id = get_option( 'tema_viera_abogados_logo' );
        if ( $logo_id ) {
          echo '<a href="' . esc_url( home_url( '/' ) ) . '">';
          echo wp_get_attachment_image( $logo_id, 'full', false, array( 'alt' => get_bloginfo( 'name' ) ) );
          echo '</a>';
        } elseif ( has_custom_logo() ) {
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
      <div class="header-right">
        <nav class="site-nav" id="site-nav">
          <?php
          wp_nav_menu( array(
            'theme_location' => 'primary-menu',
            'fallback_cb'    => function() {
              echo '<ul>';
              echo '<li class="current-menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'INICIO', 'tema-viera-abogados' ) . '</a></li>';
              echo '<li><a href="#servicios">' . esc_html__( 'SERVICIOS', 'tema-viera-abogados' ) . '</a></li>';
              echo '<li><a href="#experiencia">' . esc_html__( 'EXPERIENCIA', 'tema-viera-abogados' ) . '</a></li>';
              echo '<li><a href="#equipo">' . esc_html__( 'EQUIPO', 'tema-viera-abogados' ) . '</a></li>';
              echo '</ul>';
            },
            'container'      => false,
          ) );
          ?>
        </nav>
        <div class="header-actions">
          <a href="#contacto" class="btn-outline desktop-only">CONVERSEMOS</a>
          
          <button class="btn-search" aria-label="Buscar">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 50 50" fill="none">
            <path d="M22.9167 39.5833C32.1214 39.5833 39.5834 32.1214 39.5834 22.9167C39.5834 13.7119 32.1214 6.24997 22.9167 6.24997C13.7119 6.24997 6.25 13.7119 6.25 22.9167C6.25 32.1214 13.7119 39.5833 22.9167 39.5833Z" stroke="white" stroke-width="4.16667" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M43.7503 43.75L34.792 34.7917" stroke="white" stroke-width="4.16667" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>

          <button class="menu-toggle" id="menu-toggle" aria-label="Abrir menú">
            <span></span>
            <span></span>
            <span></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</header>