<?php
/**
 * Plantilla: Front Page
 *
 * Página de inicio / Landing page con todas las secciones editables
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
$hero_overline         = get_option( 'tema_viera_abogados_hero_overline', 'ESTUDIO JURÍDICO · LIMA, PERÚ' );
$hero_titulo           = get_option( 'tema_viera_abogados_hero_titulo', 'SOMOS EXPERTOS EN LITIGIOS COMPLEJOS' );
$hero_subtitulo        = get_option( 'tema_viera_abogados_hero_subtitulo', 'Resolvemos lo que otros no pueden.' );
$hero_imagen_id        = get_option( 'tema_viera_abogados_hero_imagen', '' );

$hero_btn1_texto       = get_option( 'tema_viera_abogados_hero_btn1_texto', 'NUESTROS SERVICIOS' );
$hero_btn2_texto       = get_option( 'tema_viera_abogados_hero_btn2_texto', 'AGENDA UNA CITA' );

$hero_imagen_url       = $hero_imagen_id ? wp_get_attachment_url( $hero_imagen_id ) : '';

$awards_logos_ids      = get_option( 'tema_viera_abogados_awards_logos', array() );

$sobre_titulo          = get_option( 'tema_viera_abogados_sobre_titulo', '' );
$sobre_contenido       = get_option( 'tema_viera_abogados_sobre_contenido', '' );
$sobre_imagen_id       = get_option( 'tema_viera_abogados_sobre_imagen', '' );
$sobre_imagen_url      = $sobre_imagen_id ? wp_get_attachment_url( $sobre_imagen_id ) : '';

$servicios_titulo      = get_option( 'tema_viera_abogados_servicios_titulo', '' );
$servicios_items       = get_option( 'tema_viera_abogados_servicios_items', array() );

$abogados_titulo       = get_option( 'tema_viera_abogados_abogados_titulo', '' );
$abogados_subtitulo    = get_option( 'tema_viera_abogados_abogados_subtitulo', '' );

$contacto_titulo       = get_option( 'tema_viera_abogados_contacto_titulo', '' );
$contacto_mensaje      = get_option( 'tema_viera_abogados_contacto_mensaje', '' );
$contacto_direccion    = get_option( 'tema_viera_abogados_contacto_direccion', '' );
$contacto_telefono     = get_option( 'tema_viera_abogados_contacto_telefono', '' );
$contacto_email        = get_option( 'tema_viera_abogados_contacto_email', '' );
?>

<section class="hero-viera" <?php echo $hero_imagen_url ? 'style="background: linear-gradient(90deg, rgba(7, 17, 44, 0.89) 31.45%, rgba(7, 17, 44, 0) 55.01%), url(\'' . esc_url( $hero_imagen_url ) . '\'); background-size: cover; background-position: center; background-repeat: no-repeat;"' : 'style="background: linear-gradient(90deg, rgba(7, 17, 44, 0.89) 31.45%, rgba(7, 17, 44, 0) 55.01%);"'; ?>>
  
  <div class="hero-overlay"></div>

  <div class="container hero-container">
    <div class="hero-content-box">
      
      <?php if ( $hero_overline ) : ?>
        <span class="hero-overline"><?php echo esc_html( $hero_overline ); ?></span>
      <?php endif; ?>

      <?php if ( $hero_titulo ) : ?>
        <h1 class="hero-title"><?php echo esc_html( $hero_titulo ); ?></h1>
      <?php endif; ?>

      <?php if ( $hero_subtitulo ) : ?>
        <div class="hero-subtitle-wrapper">
          <hr class="hero-divider">
          <p class="hero-subtitle"><?php echo wp_kses_post( $hero_subtitulo ); ?></p>
        </div>
      <?php endif; ?>

      <div class="hero-buttons">
        <?php if ( $hero_btn1_texto ) : ?>
          <a href="#servicios" class="btn-solid-white">
            <?php echo esc_html( $hero_btn1_texto ); ?> 
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none" style="flex-shrink: 0;">
            <path d="M4.875 9.75L8.125 6.5L4.875 3.25" stroke="currentColor" stroke-width="1.08333" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        <?php endif; ?>

        <?php if ( $hero_btn2_texto ) : ?>
          <a href="#contacto" class="btn-outline-white">
            <?php echo esc_html( $hero_btn2_texto ); ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none" style="flex-shrink: 0;">
            <path d="M4.875 9.75L8.125 6.5L4.875 3.25" stroke="currentColor" stroke-width="1.08333" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        <?php endif; ?>
      </div>

    </div>
  </div>

</section>

<?php if ( ! empty( $awards_logos_ids ) && is_array( $awards_logos_ids ) ) : ?>
<section class="awards-section">
  <div class="awards-banner">
    <div class="awards-header">
      <span class="awards-pretitle">RECONOCIMIENTOS</span>
      <h3 class="awards-title">INTERNACIONALES</h3>
    </div>
    
    <div class="awards-slider-wrapper">
      <div class="awards-track" id="awards-track">
        <?php foreach ( $awards_logos_ids as $logo_id ) : 
            $logo_url = wp_get_attachment_url( $logo_id );
            if ( $logo_url ) :
        ?>
            <div class="award-item">
              <img src="<?php echo esc_url( $logo_url ); ?>" alt="Reconocimiento Internacional">
            </div>
        <?php 
            endif;
        endforeach; ?>
      </div>
    </div>

    <button class="awards-next-btn" id="awards-next-btn" aria-label="Siguientes reconocimientos">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </button>
  </div>
</section>
<?php endif; ?>

<?php
$texto_animado_1 = get_option( 'tema_viera_abogados_texto_animado_1', 'RESOLVEMOS LO QUE' );
$texto_animado_2 = get_option( 'tema_viera_abogados_texto_animado_2', 'OTROS NO PUEDEN' );
?>

<!-- ========================================
   SECCIÓN SERVICIOS
   ======================================== -->
<?php if ( $servicios_titulo || ( ! empty( $servicios_items ) && is_array( $servicios_items ) ) ) : ?>
  <section id="servicios" class="section-servicios">
    <div class="container">
      <?php if ( $servicios_titulo ) : ?>
        <h2 class="section-title-left"><?php echo esc_html( $servicios_titulo ); ?></h2>
      <?php endif; ?>

      <?php if ( ! empty( $servicios_items ) && is_array( $servicios_items ) ) : ?>
        <div class="servicios-container" id="servicios-container">
          
          <div class="servicios-grid" id="servicios-grid">
            <?php foreach ( $servicios_items as $index => $servicio ) : 
              $detalles = isset($servicio['detalles']) ? (is_array($servicio['detalles']) ? $servicio['detalles'] : explode("\n", $servicio['detalles'])) : array();
            ?>
              <div class="service-card-viera" 
                   data-index="<?php echo esc_attr( $index ); ?>"
                   data-titulo="<?php echo esc_attr( $servicio['titulo'] ?? '' ); ?>"
                   data-descripcion="<?php echo esc_attr( $servicio['descripcion'] ?? '' ); ?>"
                   data-detalles='<?php echo esc_attr( json_encode( $detalles ) ); ?>'>
                <div class="service-content">
                  <?php if ( ! empty( $servicio['titulo'] ) ) : ?>
                    <h3 class="service-title"><?php echo esc_html( $servicio['titulo'] ); ?></h3>
                  <?php endif; ?>

                  <?php if ( ! empty( $servicio['descripcion'] ) ) : ?>
                    <p class="service-description"><?php echo wp_kses_post( $servicio['descripcion'] ); ?></p>
                  <?php endif; ?>
                </div>
                <button class="btn-ver-mas" data-action="expand">VER MÁS <svg xmlns="http://www.w3.org/2000/svg" width="6" height="10" viewBox="0 0 6 10" fill="none"><path d="M1 9L5 5L1 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="servicios-expanded-view" id="servicios-expanded-view" style="display: none;">
            
            <div class="expanded-main-panel">
              <div class="expanded-text-side">
                <h3 class="expanded-title" id="expanded-title"></h3>
                <p class="expanded-description" id="expanded-description"></p>
                <button class="btn-ocultar" id="btn-ocultar">OCULTAR <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M10 4L6 8L10 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
              </div>
              <div class="expanded-list-side" id="expanded-list-side">
              </div>
            </div>

            <div class="next-preview-wrapper">
              <div class="expanded-next-preview" id="expanded-next-preview" data-next-index="">
                <div class="preview-content">
                  <h4 class="preview-title" id="preview-title"></h4>
                  <p class="preview-description" id="preview-description-text"></p>
                  <span class="preview-link">VER MÁS ∨</span>
                </div>
              </div>
              <button class="btn-next-arrow" id="btn-next-arrow" aria-label="Siguiente servicio">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
              </button>
            </div>

          </div>

        </div>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>

<section class="animated-text-section">
    <h2 class="animated-heading">
      <span class="slide-element slide-left"><?php echo esc_html( $texto_animado_1 ); ?></span>
      <span class="slide-element slide-right"><?php echo esc_html( $texto_animado_2 ); ?></span>
    </h2>
</section>

<?php
$exp_pre_titulo = get_option( 'tema_viera_abogados_exp_pre_titulo', 'SECTORES' );
$exp_titulo     = get_option( 'tema_viera_abogados_exp_titulo', 'NUESTRA EXPERIENCIA' );
$exp_subtitulo  = get_option( 'tema_viera_abogados_exp_subtitulo', '15 años destacando por nuestras estrategias innovadoras y eficientes' );

$sectores = get_option( 'tema_viera_abogados_sectores_items', array() ); 
?>

<!-- ========================================
   SECCIÓN EXPERIENCIA
   ======================================== -->
<section id="experiencia" class="section-experiencia">
  <div class="container">
    <div class="experiencia-grid">
      
      <div class="experiencia-imagen-col">
        <div class="experiencia-logo-mark">
          <svg viewBox="0 0 293 701" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M227.042 0L98.5026 285.06L58.8365 196.312H0L97.7959 415.468L286.055 0H227.042Z" fill="var(--color-primary)"/>
            <path d="M65.4624 700.791L193.913 415.731L233.668 504.478H292.504L194.708 285.323L6.36084 700.791H65.4624Z" fill="var(--color-primary)"/>
          </svg>
        </div>

        <?php
        $default_img = '';
        if ( ! empty( $sectores ) && ! empty( $sectores[0]['imagen'] ) ) {
            $default_img = wp_get_attachment_url( $sectores[0]['imagen'] );
        }
        ?>
        <img src="<?php echo esc_url( $default_img ); ?>" alt="Nuestra Experiencia" class="experiencia-img-main" id="experiencia-img-main">
        <div class="experiencia-img-overlay"></div>
      </div>

      <div class="experiencia-content-col">
        <?php if ( $exp_pre_titulo ) : ?>
          <span class="exp-pre-titulo"><?php echo esc_html( $exp_pre_titulo ); ?></span>
        <?php endif; ?>
        
        <?php if ( $exp_titulo ) : ?>
          <h2 class="exp-titulo"><?php echo esc_html( $exp_titulo ); ?></h2>
        <?php endif; ?>

        <?php if ( $exp_subtitulo ) : ?>
          <p class="exp-subtitulo"><?php echo esc_html( $exp_subtitulo ); ?></p>
        <?php endif; ?>

        <div class="sectores-wrapper">
          <ul class="sectores-list" id="sectores-list">
            <?php if ( ! empty( $sectores ) ) : ?>
              <?php foreach ( $sectores as $index => $sector ) : 
                $open_class = ( $index === 0 ) ? 'is-open' : '';
                $imagen_url = !empty($sector['imagen']) ? wp_get_attachment_url( $sector['imagen'] ) : '';
              ?>
                <li class="sector-item <?php echo $open_class; ?>" data-image="<?php echo esc_url( $imagen_url ); ?>">
                  
                  <div class="sector-header">
                    <span class="sector-nombre"><?php echo esc_html( $sector['titulo'] ); ?></span>
                    <span class="sector-icon"></span>
                  </div>

                  <div class="sector-body">
                    <div class="sector-body-content">
                      <?php echo wp_kses_post( $sector['descripcion'] ?? '' ); ?>
                    </div>
                  </div>

                </li>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul>

          <div class="sectores-fade-overlay">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
              <path d="M13.3133 29.4142C14.0944 30.1953 15.3607 30.1953 16.1418 29.4142L28.8697 16.6863C29.6507 15.9052 29.6507 14.6389 28.8697 13.8579C28.0886 13.0768 26.8223 13.0768 26.0412 13.8579L14.7275 25.1716L3.41383 13.8579C2.63278 13.0768 1.36645 13.0768 0.585403 13.8579C-0.195646 14.6389 -0.195646 15.9052 0.585403 16.6863L13.3133 29.4142ZM14.7275 0L12.7275 -8.74228e-08L12.7275 28L14.7275 28L16.7275 28L16.7275 8.74228e-08L14.7275 0Z" fill="#222F50"/>
            </svg>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<?php
$clientes_titulo = get_option( 'tema_viera_abogados_clientes_titulo', 'ELLOS CONFÍAN EN NOSOTROS' );
$clientes_logos  = get_option( 'tema_viera_abogados_clientes_logos', array() );
?>

<!-- ========================================
   SECCIÓN CLIENTES 
   ======================================== -->
<section id="clientes" class="section-clientes is-collapsed">
  <div class="container">
    <h2 class="clientes-titulo"><?php echo esc_html( $clientes_titulo ); ?></h2>
    
    <div class="clientes-grid">
      <?php if ( ! empty( $clientes_logos ) && is_array( $clientes_logos ) ) : ?>
        <?php foreach ( $clientes_logos as $index => $logo_id ) : 
          $logo_url = wp_get_attachment_url( $logo_id );
          if ( $logo_url ) :
        ?>
          <div class="cliente-logo-wrapper">
            <div class="cliente-logo-box">
              <img src="<?php echo esc_url( $logo_url ); ?>" alt="Cliente">
            </div>
          </div>
        <?php 
          endif;
        endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>


<?php
$equipo_pre_titulo = get_option( 'tema_viera_abogados_equipo_pre', 'SECTORES' );
$equipo_titulo     = get_option( 'tema_viera_abogados_equipo_titulo', 'NUESTRO EQUIPO' );
$equipo_enlace_txt = get_option( 'tema_viera_abogados_equipo_enlace_txt', 'CONOCE A TODO EL EQUIPO →' );
$equipo_enlace_url = get_option( 'tema_viera_abogados_equipo_enlace_url', home_url( '/equipo/' ) );

$fundador_post_id     = get_option( 'tema_viera_abogados_fundador_post_id', '' );
$equipo_seleccionados = get_option( 'tema_viera_abogados_equipo_seleccionados', array() );

// Obtener datos del fundador desde el CPT o fallback a opciones legacy
if ( $fundador_post_id && get_post( $fundador_post_id ) ) {
	$fundador_img_url  = get_the_post_thumbnail_url( $fundador_post_id, 'medium_large' );
	$fundador_tag      = tema_viera_get_abogado_meta( $fundador_post_id, 'tag' );
	$fundador_tag      = $fundador_tag ?: 'FUNDADOR';
	$fundador_nombre   = get_the_title( $fundador_post_id );
	$fundador_cargo    = tema_viera_get_abogado_meta( $fundador_post_id, 'cargo' );
	$fundador_bio      = tema_viera_get_abogado_meta( $fundador_post_id, 'biografia' );
	$fundador_linkedin = tema_viera_get_abogado_meta( $fundador_post_id, 'linkedin' );
} else {
	// Fallback legacy
	$fundador_img_id   = get_option( 'tema_viera_abogados_fundador_img', '' );
	$fundador_img_url  = $fundador_img_id ? wp_get_attachment_url( $fundador_img_id ) : '';
	$fundador_tag      = get_option( 'tema_viera_abogados_fundador_tag', 'FUNDADOR' );
	$fundador_nombre   = get_option( 'tema_viera_abogados_fundador_nombre', '' );
	$fundador_cargo    = get_option( 'tema_viera_abogados_fundador_cargo', '' );
	$fundador_bio      = get_option( 'tema_viera_abogados_fundador_bio', '' );
	$fundador_linkedin = get_option( 'tema_viera_abogados_fundador_linkedin', '#' );
}

// Construir array de miembros del equipo desde CPT o fallback legacy
$equipo_items = array();
if ( ! empty( $equipo_seleccionados ) && is_array( $equipo_seleccionados ) ) {
	foreach ( $equipo_seleccionados as $post_id ) {
		if ( $post_id == $fundador_post_id || ! get_post( $post_id ) ) {
			continue;
		}
		$img_id = get_post_thumbnail_id( $post_id );
		$equipo_items[] = array(
			'imagen'      => $img_id ? $img_id : 0,
			'nombre'      => get_the_title( $post_id ),
			'cargo'       => tema_viera_get_abogado_meta( $post_id, 'cargo' ),
			'descripcion' => tema_viera_get_abogado_meta( $post_id, 'biografia' ),
			'email'       => tema_viera_get_abogado_meta( $post_id, 'email' ),
			'linkedin'    => tema_viera_get_abogado_meta( $post_id, 'linkedin' ),
		);
	}
} else {
	// Fallback legacy
	$equipo_items = get_option( 'tema_viera_abogados_equipo_items', array() );
}
?>

<!-- ========================================
   SECCIÓN NUESTRO EQUIPO
   ======================================== -->
<section id="equipo" class="section-equipo">
  <div class="container">
    
    <div class="equipo-header">
      <div class="equipo-titles">
        <?php if ( $equipo_pre_titulo ) : ?>
          <span class="equipo-pre-title"><?php echo esc_html( $equipo_pre_titulo ); ?></span>
        <?php endif; ?>
        <?php if ( $equipo_titulo ) : ?>
          <h2 class="equipo-main-title"><?php echo esc_html( $equipo_titulo ); ?></h2>
        <?php endif; ?>
      </div>
      
      <?php if ( $equipo_enlace_txt ) : ?>
        <a href="<?php echo esc_url( $equipo_enlace_url ?: '#' ); ?>" class="equipo-enlace">
          <?php echo esc_html( $equipo_enlace_txt ); ?>
        </a>
      <?php endif; ?>
    </div>

    <div class="equipo-layout">
      
      <div class="fundador-card">
        <div class="fundador-img-box">
          <img src="<?php echo esc_url( $fundador_img_url ); ?>" alt="<?php echo esc_attr( $fundador_nombre ); ?>">
        </div>
        <div class="fundador-info-box">
          <span class="fundador-tag"><?php echo esc_html( $fundador_tag ); ?></span>
          <h3 class="fundador-nombre"><?php echo esc_html( $fundador_nombre ); ?></h3>
          <span class="fundador-cargo"><?php echo esc_html( $fundador_cargo ); ?></span>
          <div class="fundador-bio">
            <?php echo wp_kses_post( $fundador_bio ); ?>
          </div>
          <a href="<?php echo esc_url( $fundador_linkedin ?: '#' ); ?>" target="_blank" class="linkedin-btn dark" aria-label="LinkedIn">
            in
          </a>
        </div>
      </div>

      <div class="equipo-slider-container">
        <?php if ( ! empty( $equipo_items ) ) : ?>
          <div class="equipo-slider-overflow" id="equipo-slider-viewport">
            <div class="equipo-track" id="equipo-track">
              
              <?php foreach ( $equipo_items as $miembro ) : 
                $img_url = !empty($miembro['imagen']) ? wp_get_attachment_url( $miembro['imagen'] ) : '';
              ?>
                <div class="miembro-card">
                  <div class="miembro-img-wrap">
                    <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $miembro['nombre'] ); ?>">
                    <div class="miembro-nombre-overlay">
                      <h4><?php echo esc_html( $miembro['nombre'] ); ?></h4>
                    </div>
                  </div>
                  
                  <div class="miembro-info-wrap">
                    <span class="miembro-cargo"><?php echo esc_html( $miembro['cargo'] ); ?></span>
                    <p class="miembro-bio"><?php echo wp_kses_post( $miembro['descripcion'] ); ?></p>
                    
                    <?php if ( !empty($miembro['email']) ) : ?>
                      <a href="mailto:<?php echo esc_attr( $miembro['email'] ); ?>" class="miembro-email">
                        <?php echo esc_html( $miembro['email'] ); ?>
                      </a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url( !empty($miembro['linkedin']) ? $miembro['linkedin'] : '#' ); ?>" target="_blank" class="linkedin-btn light" aria-label="LinkedIn">
                      in
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>

            </div>
          </div>

          <div class="equipo-dots" id="equipo-dots"></div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<?php
$kpi_1_prefix = get_option( 'tema_viera_abogados_kpi_1_prefix', '+' );
$kpi_1_num    = get_option( 'tema_viera_abogados_kpi_1_num', '50' );
$kpi_1_suffix = get_option( 'tema_viera_abogados_kpi_1_suffix', '' );
$kpi_1_label  = get_option( 'tema_viera_abogados_kpi_1_label', 'Empresas asesoradas' );

$kpi_2_prefix = get_option( 'tema_viera_abogados_kpi_2_prefix', '+' );
$kpi_2_num    = get_option( 'tema_viera_abogados_kpi_2_num', '35' );
$kpi_2_suffix = get_option( 'tema_viera_abogados_kpi_2_suffix', '' );
$kpi_2_label  = get_option( 'tema_viera_abogados_kpi_2_label', 'Años de experiencia' );

$kpi_3_prefix = get_option( 'tema_viera_abogados_kpi_3_prefix', '' );
$kpi_3_num    = get_option( 'tema_viera_abogados_kpi_3_num', '100' );
$kpi_3_suffix = get_option( 'tema_viera_abogados_kpi_3_suffix', '%' );
$kpi_3_label  = get_option( 'tema_viera_abogados_kpi_3_label', 'Clientes satisfechos' );
?>

<!-- ========================================
   SECCIÓN KPIs
   ======================================== -->
<section class="section-kpis" id="kpis">
  <div class="container">
    <div class="kpis-grid">
      
      <div class="kpi-item">
        <div class="kpi-number-wrap">
          <span class="kpi-symbol"><?php echo esc_html( $kpi_1_prefix ); ?></span>
          <span class="kpi-counter" data-target="<?php echo esc_attr( $kpi_1_num ); ?>">0</span>
          <span class="kpi-symbol"><?php echo esc_html( $kpi_1_suffix ); ?></span>
        </div>
        <p class="kpi-label"><?php echo esc_html( $kpi_1_label ); ?></p>
      </div>

      <div class="kpi-item">
        <div class="kpi-number-wrap">
          <span class="kpi-symbol"><?php echo esc_html( $kpi_2_prefix ); ?></span>
          <span class="kpi-counter" data-target="<?php echo esc_attr( $kpi_2_num ); ?>">0</span>
          <span class="kpi-symbol"><?php echo esc_html( $kpi_2_suffix ); ?></span>
        </div>
        <p class="kpi-label"><?php echo esc_html( $kpi_2_label ); ?></p>
      </div>

      <div class="kpi-item">
        <div class="kpi-number-wrap">
          <span class="kpi-symbol"><?php echo esc_html( $kpi_3_prefix ); ?></span>
          <span class="kpi-counter" data-target="<?php echo esc_attr( $kpi_3_num ); ?>">0</span>
          <span class="kpi-symbol"><?php echo esc_html( $kpi_3_suffix ); ?></span>
        </div>
        <p class="kpi-label"><?php echo esc_html( $kpi_3_label ); ?></p>
      </div>

    </div>
  </div>
</section>

<?php
$agenda_pre_titulo = get_option( 'tema_viera_abogados_agenda_pre', 'AGENDA UNA REUNIÓN' );
$agenda_titulo     = get_option( 'tema_viera_abogados_agenda_titulo', 'HABLEMOS DE TU CASO' );
$agenda_desc       = get_option( 'tema_viera_abogados_agenda_desc', 'Agenda una reunión con nuestro equipo legal de forma rápida y sencilla. Estamos listos para escucharte y ayudarte.' );
$agenda_btn_txt    = get_option( 'tema_viera_abogados_agenda_btn_txt', 'AGENDA UNA CITA >' );
$agenda_btn_url    = get_option( 'tema_viera_abogados_agenda_btn_url', '#plugin-reserva' );
?>

<!-- ========================================
   SECCIÓN AGENDAR CITA
   ======================================== -->
<section id="agendar-cita" class="section-agenda">
  <div class="container">
    <div class="agenda-grid">
      
      <div class="agenda-content-col">
        <?php if ( $agenda_pre_titulo ) : ?>
          <span class="agenda-pre-titulo"><?php echo esc_html( $agenda_pre_titulo ); ?></span>
        <?php endif; ?>
        
        <?php if ( $agenda_titulo ) : ?>
          <h2 class="agenda-titulo"><?php echo esc_html( $agenda_titulo ); ?></h2>
        <?php endif; ?>

        <?php if ( $agenda_desc ) : ?>
          <p class="agenda-desc"><?php echo esc_html( $agenda_desc ); ?></p>
        <?php endif; ?>

        <?php if ( $agenda_btn_txt && $agenda_btn_url ) : ?>
          <a href="<?php echo esc_url( $agenda_btn_url ); ?>" class="btn-outline-dark">
            <?php echo esc_html( $agenda_btn_txt ); ?>
          </a>
        <?php endif; ?>
      </div>

      <!-- Contenedor del Plugin -->
      <div class="agenda-plugin-col" id="plugin-reserva">
        
        <div class="plugin-placeholder"></div>
      </div>

    </div>
  </div>
</section>


<?php
$noticias_pre_titulo = get_option( 'tema_viera_abogados_noticias_pre', 'MÁS SOBRE NOSOTROS' );
$noticias_titulo     = get_option( 'tema_viera_abogados_noticias_titulo', 'CASOS, NOTICIAS Y MÁS' );
$btn_cargar_mas      = get_option( 'tema_viera_abogados_noticias_btn', 'CARGAR MÁS ∨' );

$noticias_query = new WP_Query( array(
	'category_name'  => 'destacados',
	'posts_per_page' => 6,
) );

$bloques_noticias = array_chunk( $noticias_query->posts, 5 );
?>

<!-- ========================================
   SECCIÓN NOTICIAS Y CASOS
   ======================================== -->
<section id="noticias" class="section-noticias">
  <div class="container">
    
    <div class="noticias-header">
      <?php if ( $noticias_pre_titulo ) : ?>
        <span class="noticias-pre-titulo"><?php echo esc_html( $noticias_pre_titulo ); ?></span>
      <?php endif; ?>
      <?php if ( $noticias_titulo ) : ?>
        <h2 class="noticias-titulo"><?php echo esc_html( $noticias_titulo ); ?></h2>
      <?php endif; ?>
    </div>

    <div class="noticias-container" id="noticias-container">
      <?php if ( $noticias_query->have_posts() ) : ?>
        
        <?php foreach ( $bloques_noticias as $index => $bloque ) : 
          $inverted_class = ( $index % 2 !== 0 ) ? 'is-inverted' : '';
          $hidden_class   = ( $index !== 0 ) ? 'd-none' : '';
        ?>
          <div class="noticias-block <?php echo $inverted_class . ' ' . $hidden_class; ?>">
            
            <?php foreach ( $bloque as $post_item ) : 
              $img_url   = get_the_post_thumbnail_url( $post_item->ID, 'medium_large' );
              $enlace    = get_permalink( $post_item->ID );
              $subtitulo = get_post_meta( $post_item->ID, '_post_subtitulo', true );
            ?>
              <a href="<?php echo esc_url( $enlace ); ?>" class="noticia-card">
                
                <div class="noticia-img-wrap">
                  <?php if ( $img_url ) : ?>
                    <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title( $post_item->ID ) ); ?>">
                  <?php endif; ?>
                  <div class="noticia-overlay-color"></div>
                  <div class="noticia-overlay-gradient"></div>
                </div>

                <div class="noticia-content">
                  <span class="noticia-categoria"><?php echo esc_html( $subtitulo ?: get_the_title( $post_item->ID ) ); ?></span>
                  <h3 class="noticia-title"><?php echo esc_html( get_the_title( $post_item->ID ) ); ?></h3>
                </div>

              </a>
            <?php endforeach; ?>

          </div>
        <?php endforeach;
        wp_reset_postdata();
        ?>

      <?php endif; ?>
    </div>

    <?php if ( count($bloques_noticias) > 1 ) : ?>
      <div class="noticias-action">
        <a href="<?php echo esc_url( get_category_link( get_cat_ID( 'Destacados' ) ) ); ?>" class="btn-outline-dark-square">
          <?php echo esc_html( $btn_cargar_mas ); ?>
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>


<?php
get_footer();
