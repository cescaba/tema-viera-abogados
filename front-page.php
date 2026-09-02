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
$hero_titulo           = tema_viera_t( get_option( 'tema_viera_abogados_hero_titulo', 'SOMOS EXPERTOS EN LITIGIOS COMPLEJOS' ) );
$hero_subtitulo        = tema_viera_t( get_option( 'tema_viera_abogados_hero_subtitulo', 'Resolvemos lo que otros no pueden.' ) );
$hero_imagen_id        = get_option( 'tema_viera_abogados_hero_imagen', '' );

$hero_btn1_texto       = tema_viera_t( get_option( 'tema_viera_abogados_hero_btn1_texto', 'NUESTROS SERVICIOS' ) );
$hero_btn2_texto       = tema_viera_t( get_option( 'tema_viera_abogados_hero_btn2_texto', 'AGENDA UNA CITA' ) );

$hero_imagen_url       = $hero_imagen_id ? wp_get_attachment_url( $hero_imagen_id ) : '';

$awards_logos_ids      = get_option( 'tema_viera_abogados_awards_logos', array() );

$sobre_titulo          = tema_viera_t( get_option( 'tema_viera_abogados_sobre_titulo', '' ) );
$sobre_contenido       = tema_viera_t( get_option( 'tema_viera_abogados_sobre_contenido', '' ) );
$sobre_imagen_id       = get_option( 'tema_viera_abogados_sobre_imagen', '' );
$sobre_imagen_url      = $sobre_imagen_id ? wp_get_attachment_url( $sobre_imagen_id ) : '';

$servicios_titulo      = tema_viera_t( get_option( 'tema_viera_abogados_servicios_titulo', '' ) );
$servicios_items       = get_option( 'tema_viera_abogados_servicios_items', array() );

$abogados_titulo       = tema_viera_t( get_option( 'tema_viera_abogados_abogados_titulo', '' ) );
$abogados_subtitulo    = tema_viera_t( get_option( 'tema_viera_abogados_abogados_subtitulo', '' ) );

$contacto_titulo       = tema_viera_t( get_option( 'tema_viera_abogados_contacto_titulo', '' ) );
$contacto_mensaje      = tema_viera_t( get_option( 'tema_viera_abogados_contacto_mensaje', '' ) );
$contacto_direccion    = tema_viera_t( get_option( 'tema_viera_abogados_contacto_direccion', '' ) );
$contacto_telefono     = get_option( 'tema_viera_abogados_contacto_telefono', '' );
$contacto_email        = get_option( 'tema_viera_abogados_contacto_email', '' );
?>
<section class="hero-viera" <?php echo $hero_imagen_url ? 'style="background-image: url(\'' . esc_url( $hero_imagen_url ) . '\');"' : ''; ?>>
  
  <div class="container hero-container">
    <div class="hero-content-box reveal">
      
      <?php if ( ! empty( $hero_titulo ) ) : ?>
        <h1 class="hero-title"><?php echo esc_html( $hero_titulo ); ?></h1>
      <?php endif; ?>

      <?php if ( ! empty( $hero_subtitulo ) ) : ?>
        <div class="hero-subtitle-wrapper">
          <hr class="hero-divider">
          <p class="hero-subtitle"><?php echo wp_kses_post( $hero_subtitulo ); ?></p>
        </div>
      <?php endif; ?>

      <div class="hero-buttons">
        <?php if ( ! empty( $hero_btn1_texto ) ) : ?>
          <a href="#servicios" class="btn-hero btn-solid-white">
            <span><?php echo esc_html( $hero_btn1_texto ); ?></span>
            <svg class="btn-arrow-desktop" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 13 13" fill="none">
              <path d="M4.875 9.75L8.125 6.5L4.875 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        <?php endif; ?>

        <?php if ( ! empty( $hero_btn2_texto ) ) : ?>
          <a href="#contacto" class="btn-hero btn-outline-white">
            <span><?php echo esc_html( $hero_btn2_texto ); ?></span>
            <svg class="btn-arrow-desktop" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 13 13" fill="none">
              <path d="M4.875 9.75L8.125 6.5L4.875 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        <?php endif; ?>
      </div>

    </div>
  </div>

  <?php if ( ! empty( $awards_logos_ids ) && is_array( $awards_logos_ids ) ) : ?>
    <!-- Barra inferior dentro del hero en Desktop -->
    <div class="awards-desktop-bar">
      <div class="awards-desktop-inner">
        <div class="awards-desktop-header">
          <span class="awards-bar-pretitle"><?php echo esc_html( tema_viera_t( 'RECONOCIMIENTOS' ) ); ?></span>
          <strong class="awards-bar-title"><?php echo esc_html( tema_viera_t( 'INTERNACIONALES:' ) ); ?></strong>
        </div>
        
        <div class="awards-desktop-logos">
          <?php foreach ( $awards_logos_ids as $logo_id ) : 
              $logo_url = wp_get_attachment_url( $logo_id );
              if ( $logo_url ) :
          ?>
            <div class="award-desktop-item">
              <img src="<?php echo esc_url( $logo_url ); ?>" alt="Reconocimiento Internacional">
            </div>
          <?php 
              endif;
          endforeach; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

</section>

<?php if ( ! empty( $awards_logos_ids ) && is_array( $awards_logos_ids ) ) : ?>
  <!-- Sección de premios para Mobile (debajo del hero) -->
  <section class="awards-mobile-section">
    <div class="container">
      <h3 class="awards-mobile-title"><?php echo esc_html( tema_viera_t( 'RECONOCIMIENTOS INTERNACIONALES' ) ); ?></h3>
      
      <div class="awards-mobile-grid">
        <?php foreach ( $awards_logos_ids as $logo_id ) : 
            $logo_url = wp_get_attachment_url( $logo_id );
            if ( $logo_url ) :
        ?>
          <div class="award-mobile-card">
            <img src="<?php echo esc_url( $logo_url ); ?>" alt="Reconocimiento Internacional">
          </div>
        <?php 
            endif;
        endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php
$texto_animado_1 = tema_viera_t( get_option( 'tema_viera_abogados_texto_animado_1', 'RESOLVEMOS LO QUE' ) );
$texto_animado_2 = tema_viera_t( get_option( 'tema_viera_abogados_texto_animado_2', 'OTROS NO PUEDEN' ) );
?>

<!-- ========================================
   SECCIÓN SERVICIOS
   ======================================== -->
<?php if ( $servicios_titulo || ( ! empty( $servicios_items ) && is_array( $servicios_items ) ) ) : ?>
  <section id="servicios" class="section-servicios">
    <div class="container">
      <?php if ( $servicios_titulo ) : ?>
        <h2 class="section-title-left reveal"><?php echo esc_html( $servicios_titulo ); ?></h2>
      <?php endif; ?>

      <?php if ( ! empty( $servicios_items ) && is_array( $servicios_items ) ) : ?>
        <div class="servicios-container reveal" id="servicios-container">
          
          <div class="servicios-grid" id="servicios-grid">
            <?php foreach ( $servicios_items as $index => $servicio ) : 
              $serv_titulo = tema_viera_t( $servicio['titulo'] ?? '' );
              $serv_desc   = tema_viera_t( $servicio['descripcion'] ?? '' );
            ?>
              <div class="service-card-viera">
                <div class="service-content">
                  <?php if ( ! empty( $serv_titulo ) ) : ?>
                    <h3 class="service-title"><?php echo esc_html( $serv_titulo ); ?></h3>
                  <?php endif; ?>

                  <?php if ( ! empty( $serv_desc ) ) : ?>
                    <p class="service-description"><?php echo wp_kses_post( $serv_desc ); ?></p>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
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
$exp_pre_titulo = tema_viera_t( get_option( 'tema_viera_abogados_exp_pre_titulo', 'SECTORES' ) );
$exp_titulo     = tema_viera_t( get_option( 'tema_viera_abogados_exp_titulo', 'NUESTRA EXPERIENCIA' ) );
$exp_subtitulo  = tema_viera_t( get_option( 'tema_viera_abogados_exp_subtitulo', '15 años destacando por nuestras estrategias innovadoras y eficientes' ) );

$sectores = get_option( 'tema_viera_abogados_sectores_items', array() ); 
?>

<!-- ========================================
   SECCIÓN EXPERIENCIA
   ======================================== -->
<section id="experiencia" class="section-experiencia">
  <div class="container">
    <div class="experiencia-grid">
      
      <div class="experiencia-imagen-col reveal">
        <?php
        $default_img = '';
        if ( ! empty( $sectores ) && ! empty( $sectores[0]['imagen'] ) ) {
            $default_img = wp_get_attachment_url( $sectores[0]['imagen'] );
        }
        ?>
        <img src="<?php echo esc_url( $default_img ); ?>" alt="Nuestra Experiencia" class="experiencia-img-main" id="experiencia-img-main">
        <div class="experiencia-img-overlay"></div>
      </div>

      <div class="experiencia-content-col reveal" data-delay="120">
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
                $sector_titulo = tema_viera_t( $sector['titulo'] ?? '' );
                $sector_desc   = tema_viera_t( $sector['descripcion'] ?? '' );
              ?>
                <li class="sector-item <?php echo $open_class; ?>" data-image="<?php echo esc_url( $imagen_url ); ?>">
                  
                  <div class="sector-header">
                    <span class="sector-nombre"><?php echo esc_html( $sector_titulo ); ?></span>
                    <span class="sector-icon"></span>
                  </div>

                  <div class="sector-body">
                    <div class="sector-body-content">
                      <?php echo wp_kses_post( $sector_desc ); ?>
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
$clientes_titulo = tema_viera_t( get_option( 'tema_viera_abogados_clientes_titulo', 'ELLOS CONFÍAN EN NOSOTROS' ) );
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
$equipo_pre_titulo = tema_viera_t( get_option( 'tema_viera_abogados_equipo_pre', 'SECTORES' ) );
$equipo_titulo     = tema_viera_t( get_option( 'tema_viera_abogados_equipo_titulo', 'NUESTRO EQUIPO' ) );
$equipo_enlace_txt = tema_viera_t( get_option( 'tema_viera_abogados_equipo_enlace_txt', 'CONOCE A TODO EL EQUIPO →' ) );
$equipo_enlace_url = get_option( 'tema_viera_abogados_equipo_enlace_url', '' );

$fundador_post_id     = get_option( 'tema_viera_abogados_fundador_post_id', '' );
$equipo_seleccionados = get_option( 'tema_viera_abogados_equipo_seleccionados', array() );

// Obtener datos del fundador desde el CPT o fallback a opciones legacy
if ( $fundador_post_id && get_post( $fundador_post_id ) ) {
	$fundador_img_url  = get_the_post_thumbnail_url( $fundador_post_id, 'medium_large' );
	$fundador_tag      = tema_viera_abogado_meta_t( $fundador_post_id, 'tag' );
	$fundador_tag      = $fundador_tag ?: tema_viera_t( 'FUNDADOR' );
	$fundador_nombre   = tema_viera_abogado_titulo( $fundador_post_id );
	$fundador_cargo    = tema_viera_abogado_meta_t( $fundador_post_id, 'cargo' );
	$fundador_bio      = tema_viera_abogado_meta_t( $fundador_post_id, 'biografia' );
	$fundador_linkedin = tema_viera_get_abogado_meta( $fundador_post_id, 'linkedin' );
} else {
	// Fallback legacy
	$fundador_img_id   = get_option( 'tema_viera_abogados_fundador_img', '' );
	$fundador_img_url  = $fundador_img_id ? wp_get_attachment_url( $fundador_img_id ) : '';
	$fundador_tag      = tema_viera_t( get_option( 'tema_viera_abogados_fundador_tag', 'FUNDADOR' ) );
	$fundador_nombre   = tema_viera_t( get_option( 'tema_viera_abogados_fundador_nombre', '' ) );
	$fundador_cargo    = tema_viera_t( get_option( 'tema_viera_abogados_fundador_cargo', '' ) );
	$fundador_bio      = tema_viera_t( get_option( 'tema_viera_abogados_fundador_bio', '' ) );
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
			'nombre'      => tema_viera_abogado_titulo( $post_id ),
			'cargo'       => tema_viera_abogado_meta_t( $post_id, 'cargo' ),
			'descripcion' => tema_viera_abogado_meta_t( $post_id, 'biografia' ),
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
    
    <div class="equipo-header reveal">
      <div class="equipo-titles">
        <?php if ( $equipo_pre_titulo ) : ?>
          <span class="equipo-pre-title"><?php echo esc_html( $equipo_pre_titulo ); ?></span>
        <?php endif; ?>
        <?php if ( $equipo_titulo ) : ?>
          <h2 class="equipo-main-title"><?php echo esc_html( $equipo_titulo ); ?></h2>
        <?php endif; ?>
      </div>
      
      <?php if ( $equipo_enlace_txt ) : ?>
        <a href="<?php echo esc_url( $equipo_enlace_url ?: tema_viera_equipo_url() ); ?>" class="equipo-enlace">
          <?php echo esc_html( $equipo_enlace_txt ); ?>
        </a>
      <?php endif; ?>
    </div>

    <div class="equipo-layout reveal" data-delay="120">
      
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
$kpis = array(
  array(
    'prefix' => get_option( 'tema_viera_abogados_kpi_1_prefix', '+' ),
    'num'    => get_option( 'tema_viera_abogados_kpi_1_num', '40' ),
    'suffix' => get_option( 'tema_viera_abogados_kpi_1_suffix', '' ),
    'label'  => tema_viera_t( get_option( 'tema_viera_abogados_kpi_1_label', 'Aberturas de locales ante clausuras arbitrarias' ) ),
  ),
  array(
    'prefix' => get_option( 'tema_viera_abogados_kpi_2_prefix', '+' ),
    'num'    => get_option( 'tema_viera_abogados_kpi_2_num', '1500' ),
    'suffix' => get_option( 'tema_viera_abogados_kpi_2_suffix', '' ),
    'label'  => tema_viera_t( get_option( 'tema_viera_abogados_kpi_2_label', 'Procesos judiciales y arbitrales atendidos' ) ),
  ),
  array(
    'prefix' => get_option( 'tema_viera_abogados_kpi_3_prefix', '+' ),
    'num'    => get_option( 'tema_viera_abogados_kpi_3_num', '1000' ),
    'suffix' => get_option( 'tema_viera_abogados_kpi_3_suffix', '' ),
    'label'  => tema_viera_t( get_option( 'tema_viera_abogados_kpi_3_label', 'Millones de soles de patrimonio protegido' ) ),
  ),
);

$kpi_4_num = get_option( 'tema_viera_abogados_kpi_4_num', '' );
if ( ! empty( $kpi_4_num ) ) {
  $kpis[] = array(
    'prefix' => get_option( 'tema_viera_abogados_kpi_4_prefix', '+' ),
    'num'    => $kpi_4_num,
    'suffix' => get_option( 'tema_viera_abogados_kpi_4_suffix', '' ),
    'label'  => tema_viera_t( get_option( 'tema_viera_abogados_kpi_4_label', 'Profesionales' ) ),
  );
}
?>

<!-- ========================================
   SECCIÓN KPIs
   ======================================== -->
<section class="section-kpis" id="kpis">
  <div class="container">
    <div class="kpis-grid reveal">
      <?php foreach ( $kpis as $kpi ) : ?>
        <div class="kpi-item">
          <div class="kpi-number-wrap">
            <?php if ( ! empty( $kpi['prefix'] ) ) : ?>
              <span class="kpi-symbol kpi-prefix"><?php echo esc_html( $kpi['prefix'] ); ?></span>
            <?php endif; ?>

            <span class="kpi-counter" data-target="<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $kpi['num'] ) ); ?>">
              <?php echo esc_html( number_format( (int) $kpi['num'] ) ); ?>
            </span>

            <?php if ( ! empty( $kpi['suffix'] ) ) : ?>
              <span class="kpi-symbol kpi-suffix"><?php echo esc_html( $kpi['suffix'] ); ?></span>
            <?php endif; ?>
          </div>
          <p class="kpi-label"><?php echo esc_html( $kpi['label'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
$agenda_pre_titulo = tema_viera_t( get_option( 'tema_viera_abogados_agenda_pre', 'AGENDA UNA REUNIÓN' ) );
$agenda_titulo     = tema_viera_t( get_option( 'tema_viera_abogados_agenda_titulo', 'HABLEMOS DE TU CASO' ) );
$agenda_desc       = tema_viera_t( get_option( 'tema_viera_abogados_agenda_desc', 'Agenda una reunión con nuestro equipo legal de forma rápida y sencilla. Estamos listos para escucharte y ayudarte.' ) );
$agenda_btn_txt    = tema_viera_t( get_option( 'tema_viera_abogados_agenda_btn_txt', 'AGENDA UNA CITA >' ) );
$agenda_btn_url    = get_option( 'tema_viera_abogados_agenda_btn_url', '#plugin-reserva' );
?>

<!-- ========================================
   SECCIÓN AGENDAR CITA
   ======================================== -->
<section id="agendar-cita" class="section-agenda">
  <div class="container">
    <div class="agenda-grid">
      
      <div class="agenda-content-col reveal">
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
      <div class="agenda-plugin-col reveal" id="plugin-reserva" data-delay="120">
        
        <div class="plugin-placeholder"></div>
      </div>

    </div>
  </div>
</section>


<?php
$noticias_pre_titulo = tema_viera_t( get_option( 'tema_viera_abogados_noticias_pre', 'MÁS SOBRE NOSOTROS' ) );
$noticias_titulo     = tema_viera_t( get_option( 'tema_viera_abogados_noticias_titulo', 'CASOS, NOTICIAS Y MÁS' ) );
$btn_cargar_mas      = tema_viera_t( get_option( 'tema_viera_abogados_noticias_btn', 'CARGAR MÁS ∨' ) );

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
    
    <div class="noticias-header reveal">
      <?php if ( $noticias_pre_titulo ) : ?>
        <span class="noticias-pre-titulo"><?php echo esc_html( $noticias_pre_titulo ); ?></span>
      <?php endif; ?>
      <?php if ( $noticias_titulo ) : ?>
        <h2 class="noticias-titulo"><?php echo esc_html( $noticias_titulo ); ?></h2>
      <?php endif; ?>
    </div>

    <div class="noticias-container reveal" id="noticias-container" data-delay="120">
      <?php if ( $noticias_query->have_posts() ) : ?>
        
        <?php foreach ( $bloques_noticias as $index => $bloque ) : 
          $inverted_class = ( $index % 2 !== 0 ) ? 'is-inverted' : '';
          $hidden_class   = ( $index !== 0 ) ? 'd-none' : '';
        ?>
          <div class="noticias-block <?php echo $inverted_class . ' ' . $hidden_class; ?>">
            
            <?php foreach ( $bloque as $post_item ) : 
              $img_url   = get_the_post_thumbnail_url( $post_item->ID, 'medium_large' );
              $enlace    = get_permalink( $post_item->ID );
              $subtitulo = tema_viera_post_meta_t( $post_item->ID, '_post_subtitulo' );
            ?>
              <a href="<?php echo esc_url( $enlace ); ?>" class="noticia-card">
                
                <div class="noticia-img-wrap">
                  <?php if ( $img_url ) : ?>
                    <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( tema_viera_post_titulo( $post_item->ID ) ); ?>">
                  <?php endif; ?>
                  <div class="noticia-overlay-color"></div>
                  <div class="noticia-overlay-gradient"></div>
                </div>

                <div class="noticia-content">
                  <span class="noticia-categoria"><?php echo esc_html( $subtitulo ?: tema_viera_post_titulo( $post_item->ID ) ); ?></span>
                  <h3 class="noticia-title"><?php echo esc_html( tema_viera_post_titulo( $post_item->ID ) ); ?></h3>
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
