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
        <?php
        $lang_actual = function_exists( 'tema_viera_current_lang' )
          ? tema_viera_current_lang()
          : ( function_exists( 'pll_current_language' ) ? pll_current_language() : 'es' );
        if ( ! $lang_actual ) {
          $lang_actual = 'es';
        }
        // URLs que permanecen en el mismo contenido (noticia, blog con ?cat=,
        // archivo de categoría). Si hay traducción real de Polylang se usa;
        // si no, se reconstruye la misma ruta con el prefijo del idioma.
        if ( function_exists( 'tema_viera_switch_url' ) ) {
          $lang_es_url = tema_viera_switch_url( 'es' );
          $lang_en_url = tema_viera_switch_url( 'en' );
        } else {
          $langs = array();
          if ( function_exists( 'pll_the_languages' ) ) {
            $langs = pll_the_languages( array( 'raw' => 1 ) );
          }
          $lang_map = array();
          if ( is_array( $langs ) ) {
            foreach ( $langs as $l ) {
              if ( ! empty( $l['slug'] ) ) {
                $lang_map[ $l['slug'] ] = $l;
              }
            }
          }
          $lang_es_url = isset( $lang_map['es'] ) ? $lang_map['es']['url'] : home_url( '/' );
          $lang_en_url = isset( $lang_map['en'] ) ? $lang_map['en']['url'] : home_url( '/' );
        }
        $lang_target      = ( $lang_actual === 'en' ) ? 'es' : 'en';
        $lang_target_url  = ( $lang_actual === 'en' ) ? $lang_es_url : $lang_en_url;
        ?>
        <nav class="site-nav" id="site-nav">
          <?php
          wp_nav_menu( array(
            'theme_location' => 'primary-menu',
            'fallback_cb'    => function() {
              $is_equipo = is_page('equipo');
              echo '<ul>';
              echo '<li' . ( is_front_page() ? ' class="current-menu-item"' : '' ) . '><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( tema_viera_t( 'INICIO' ) ) . '</a></li>';
              echo '<li><a href="' . esc_url( tema_viera_anchor_url( 'servicios' ) ) . '">' . esc_html( tema_viera_t( 'SERVICIOS' ) ) . '</a></li>';
              echo '<li><a href="' . esc_url( tema_viera_anchor_url( 'experiencia' ) ) . '">' . esc_html( tema_viera_t( 'EXPERIENCIA' ) ) . '</a></li>';
              echo '<li' . ( $is_equipo ? ' class="current-menu-item"' : '' ) . '><a href="' . esc_url( tema_viera_equipo_url() ) . '">' . esc_html( tema_viera_t( 'EQUIPO' ) ) . '</a></li>';
              echo '</ul>';
            },
            'container'      => false,
          ) );
          ?>
          <div class="mobile-lang-switch" aria-label="<?php esc_attr_e( 'Cambiar idioma', 'tema-viera-abogados' ); ?>">
            <a href="<?php echo esc_url( $lang_es_url ); ?>" class="mobile-lang-opt<?php echo ( $lang_actual === 'es' ) ? ' is-current' : ''; ?>"<?php echo ( $lang_actual === 'es' ) ? ' aria-current="true"' : ''; ?>>ES</a>
            <span class="mobile-lang-sep" aria-hidden="true">|</span>
            <a href="<?php echo esc_url( $lang_en_url ); ?>" class="mobile-lang-opt<?php echo ( $lang_actual === 'en' ) ? ' is-current' : ''; ?>"<?php echo ( $lang_actual === 'en' ) ? ' aria-current="true"' : ''; ?>>EN</a>
          </div>
        </nav>
        
        <div class="header-actions">
          <a href="<?php echo esc_url( tema_viera_anchor_url( 'agendar-cita' ) ); ?>" class="btn-outline desktop-only"><?php echo esc_html( tema_viera_t( 'CONVERSEMOS' ) ); ?></a>
          
          <button class="btn-search" id="search-toggle" aria-label="<?php echo esc_attr( tema_viera_t( 'Buscar' ) ); ?>" aria-expanded="false" aria-controls="search-panel">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 50 50" fill="none">
            <path d="M22.9167 39.5833C32.1214 39.5833 39.5834 32.1214 39.5834 22.9167C39.5834 13.7119 32.1214 6.24997 22.9167 6.24997C13.7119 6.24997 6.25 13.7119 6.25 22.9167C6.25 32.1214 13.7119 39.5833 22.9167 39.5833Z" stroke="white" stroke-width="4.16667" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M43.7503 43.75L34.792 34.7917" stroke="white" stroke-width="4.16667" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>

          <!-- Switch de Idiomas -->
          <a href="<?php echo esc_url( $lang_target_url ); ?>" class="lang-switch desktop-only <?php echo ( $lang_actual === 'es' ) ? 'is-es' : 'is-en'; ?>" role="switch" aria-checked="<?php echo ( $lang_actual === 'en' ) ? 'true' : 'false'; ?>" aria-label="Cambiar idioma a <?php echo esc_attr( strtoupper( $lang_target ) ); ?>">
            <span class="lang-opt">ES</span>
            <span class="lang-opt">EN</span>
          </a>

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

<?php
// Panel de búsqueda: gradient + overlay. Recientes en localStorage (por idioma),
// populares fijas y resultados vivos vía AJAX (inc/search.php).
$search_popular = function_exists( 'tema_viera_search_popular' ) ? tema_viera_search_popular() : array();
?>
<div class="search-backdrop" id="search-backdrop"></div>
<section class="search-panel" id="search-panel" role="dialog" aria-modal="true" aria-label="<?php echo esc_attr( tema_viera_t( 'Buscar' ) ); ?>">
  <div class="container">
    <div class="search-panel-top">
      <button type="button" class="search-close" id="search-close" aria-label="<?php echo esc_attr( tema_viera_t( 'Cerrar' ) ); ?>">
        <span aria-hidden="true">✕</span> <?php echo esc_html( tema_viera_t( 'Cerrar' ) ); ?>
      </button>
    </div>
    <form role="search" method="get" class="search-panel-form" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
      <input type="search" class="search-panel-input" id="search-input" name="s"
        value="<?php echo esc_attr( get_search_query() ); ?>"
        placeholder="<?php echo esc_attr( tema_viera_t( 'Buscar por palabras clave' ) ); ?>"
        autocomplete="off" aria-label="<?php echo esc_attr( tema_viera_t( 'Buscar' ) ); ?>">
      <button type="submit" class="search-panel-submit" aria-label="<?php echo esc_attr( tema_viera_t( 'Buscar' ) ); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 50 50" fill="none" aria-hidden="true">
          <path d="M22.9167 39.5833C32.1214 39.5833 39.5834 32.1214 39.5834 22.9167C39.5834 13.7119 32.1214 6.24997 22.9167 6.24997C13.7119 6.24997 6.25 13.7119 6.25 22.9167C6.25 32.1214 13.7119 39.5833 22.9167 39.5833Z" stroke="white" stroke-width="3.33333" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M43.7503 43.75L34.792 34.7917" stroke="white" stroke-width="3.33333" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
    </form>
    <div class="search-panel-body">
      <div class="search-initial" id="search-initial">
        <div class="search-recent" id="search-recent" hidden>
          <div class="search-label-row">
            <span class="search-label"><?php echo esc_html( tema_viera_t( 'BÚSQUEDAS RECIENTES' ) ); ?></span>
            <button type="button" class="search-clear-all" id="search-clear"><?php echo esc_html( tema_viera_t( 'Borrar todo' ) ); ?></button>
          </div>
          <div class="search-recent-list" id="search-recent-list"></div>
        </div>
        <?php if ( ! empty( $search_popular ) ) : ?>
        <div class="search-popular">
          <span class="search-label"><?php echo esc_html( tema_viera_t( 'BÚSQUEDAS POPULARES' ) ); ?></span>
          <div class="search-popular-pills" id="search-popular">
            <?php foreach ( $search_popular as $term ) : ?>
              <button type="button" class="search-pill" data-term="<?php echo esc_attr( $term ); ?>"><?php echo esc_html( tema_viera_t( $term ) ); ?></button>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <div class="search-results" id="search-results" hidden>
        <p class="search-results-count" id="search-count" aria-live="polite"></p>
        <div class="search-results-groups" id="search-groups"></div>
        <p class="search-results-empty" id="search-empty" hidden><?php echo esc_html( tema_viera_t( 'Sin resultados. Prueba con otra palabra clave.' ) ); ?></p>
      </div>
    </div>
  </div>
</section>