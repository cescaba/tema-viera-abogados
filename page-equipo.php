<?php
/**
 * Template Name: Equipo
 *
 * Página de perfil del equipo con hero personalizable desde admin.
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$perfil_pre_titulo   = get_option( 'tema_viera_abogados_perfil_pre', 'NUESTRO EQUIPO · VIERA ABOGADOS' );
$perfil_nombre       = get_option( 'tema_viera_abogados_perfil_nombre', 'RAFAEL<br>VIERA' );
$perfil_cargo        = get_option( 'tema_viera_abogados_perfil_cargo', 'Socio fundador' );
$perfil_cita         = get_option( 'tema_viera_abogados_perfil_cita', '“Rafael Viera is able to untangle complex cases with great wit, creativity and legal acumen.”' );
$perfil_cita_autor   = get_option( 'tema_viera_abogados_perfil_cita_autor', 'Chambers Latin America' );
$perfil_pre_logos    = get_option( 'tema_viera_abogados_perfil_pre_logos', 'Reconocimientos internacionales' );

$perfil_img_id       = get_option( 'tema_viera_abogados_perfil_img', '' );
$perfil_img_url      = $perfil_img_id ? wp_get_attachment_url( $perfil_img_id ) : '';

$perfil_logos_ids    = get_option( 'tema_viera_abogados_perfil_logos', array() );
?>

<section class="section-perfil-hero">
	<div class="perfil-hero-layout">

		<div class="perfil-content-col">
			<div class="perfil-content-inner reveal">

				<?php if ( $perfil_pre_titulo ) : ?>
					<span class="perfil-pre-titulo"><?php echo esc_html( $perfil_pre_titulo ); ?></span>
				<?php endif; ?>

				<?php if ( $perfil_nombre ) : ?>
					<h1 class="perfil-nombre"><?php echo wp_kses_post( $perfil_nombre ); ?></h1>
				<?php endif; ?>

				<?php if ( $perfil_cargo ) : ?>
					<div class="perfil-cargo-wrap">
						<hr class="perfil-linea">
						<span class="perfil-cargo"><?php echo esc_html( $perfil_cargo ); ?></span>
					</div>
				<?php endif; ?>

				<?php if ( $perfil_cita ) : ?>
					<blockquote class="perfil-cita-block">
						<p class="perfil-cita-texto"><?php echo esc_html( $perfil_cita ); ?></p>
						<?php if ( $perfil_cita_autor ) : ?>
							<cite class="perfil-cita-autor">| <?php echo esc_html( $perfil_cita_autor ); ?></cite>
						<?php endif; ?>
					</blockquote>
				<?php endif; ?>

				<?php if ( ! empty( $perfil_logos_ids ) && is_array( $perfil_logos_ids ) ) : ?>
					<div class="perfil-reconocimientos">
						<?php if ( $perfil_pre_logos ) : ?>
							<span class="perfil-pre-logos"><?php echo esc_html( $perfil_pre_logos ); ?></span>
						<?php endif; ?>

						<div class="perfil-logos-grid">
							<?php foreach ( $perfil_logos_ids as $logo_id ) :
								$logo_url = wp_get_attachment_url( $logo_id );
								if ( $logo_url ) :
							?>
								<div class="perfil-logo-item">
									<img src="<?php echo esc_url( $logo_url ); ?>" alt="Reconocimiento">
								</div>
							<?php
								endif;
							endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>

		<div class="perfil-image-col reveal" data-delay="120">
			<?php if ( $perfil_img_url ) : ?>
				<img src="<?php echo esc_url( $perfil_img_url ); ?>" alt="<?php echo esc_attr( strip_tags( $perfil_nombre ) ); ?>">
			<?php endif; ?>
		</div>

	</div>
</section>

<?php
$detalle_pre_titulo    = get_option( 'tema_viera_abogados_detalle_pre', 'EXPERIENCIA' );
$detalle_titulo        = get_option( 'tema_viera_abogados_detalle_titulo', 'PERFIL DEL FUNDADOR' );
$detalle_contenido     = get_option( 'tema_viera_abogados_detalle_contenido', '<p>Rafael es socio fundador de Viera Abogados y...</p>' );
$detalle_rec_titulo    = get_option( 'tema_viera_abogados_detalle_rec_titulo', 'RECONOCIMIENTOS' );

$sidebar_esp_titulo    = get_option( 'tema_viera_abogados_sidebar_esp_titulo', 'ESPECIALIDADES' );
$sidebar_esp_items     = get_option( 'tema_viera_abogados_sidebar_esp_items', array( 'Arbitraje', 'Litigios Civiles', 'Litigios Comerciales', 'Procesos Constitucionales', 'Resolución de Controversias' ) );

$sidebar_mem_titulo    = get_option( 'tema_viera_abogados_sidebar_mem_titulo', 'MEMBRESÍAS' );
$sidebar_mem_items     = get_option( 'tema_viera_abogados_sidebar_mem_items', array( 'Colegio de Abogados de Lima', 'Centro de Arbitraje - Cámara de Comercio de Lima' ) );

$sidebar_correo_tit    = get_option( 'tema_viera_abogados_sidebar_correo_tit', 'CORREO' );
$sidebar_correo        = get_option( 'tema_viera_abogados_sidebar_correo', 'rafael.viera@viera.com.pe' );

$sidebar_linkedin      = get_option( 'tema_viera_abogados_sidebar_linkedin', '#' );
?>

<section class="section-perfil-detalle">
	<div class="container">
		<div class="perfil-detalle-grid">

			<div class="perfil-main-col reveal">

				<?php if ( $detalle_pre_titulo ) : ?>
					<span class="detalle-pre-titulo"><?php echo esc_html( $detalle_pre_titulo ); ?></span>
				<?php endif; ?>

				<?php if ( $detalle_titulo ) : ?>
					<h2 class="detalle-titulo"><?php echo esc_html( $detalle_titulo ); ?></h2>
				<?php endif; ?>

				<div class="detalle-contenido-texto">
					<?php echo wp_kses_post( $detalle_contenido ); ?>
				</div>

				<?php if ( $detalle_rec_titulo ) : ?>
					<h3 class="detalle-subtitulo-secundario"><?php echo esc_html( $detalle_rec_titulo ); ?></h3>
				<?php endif; ?>

			</div>

			<div class="perfil-sidebar-col reveal" data-delay="120">

				<?php if ( $sidebar_esp_titulo && ! empty( $sidebar_esp_items ) ) : ?>
					<div class="sidebar-block">
						<h4 class="sidebar-titulo"><?php echo esc_html( $sidebar_esp_titulo ); ?></h4>
						<ul class="sidebar-lista-lineas">
							<?php foreach ( $sidebar_esp_items as $item ) : ?>
								<li><?php echo esc_html( $item ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php if ( $sidebar_mem_titulo && ! empty( $sidebar_mem_items ) ) : ?>
					<div class="sidebar-block">
						<h4 class="sidebar-titulo"><?php echo esc_html( $sidebar_mem_titulo ); ?></h4>
						<ul class="sidebar-lista-simple">
							<?php foreach ( $sidebar_mem_items as $item ) : ?>
								<li><?php echo esc_html( $item ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php if ( $sidebar_correo_tit && $sidebar_correo ) : ?>
					<div class="sidebar-block">
						<h4 class="sidebar-titulo"><?php echo esc_html( $sidebar_correo_tit ); ?></h4>
						<a href="mailto:<?php echo esc_attr( $sidebar_correo ); ?>" class="sidebar-enlace-correo">
							<?php echo esc_html( $sidebar_correo ); ?>
						</a>
					</div>
				<?php endif; ?>

				<div class="sidebar-block mt-4">
					<a href="<?php echo esc_url( $sidebar_linkedin ?: '#' ); ?>" target="_blank" rel="noopener noreferrer" class="linkedin-btn dark-square" aria-label="LinkedIn">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 28" fill="none">
							<path d="M6.29464 27.2463H0.464503V9.05534H6.29464V27.2463ZM3.37643 6.57392C1.51214 6.57392 0 5.07778 0 3.27145C1.33438e-08 2.40381 0.35573 1.5717 0.988934 0.958186C1.62214 0.34467 2.48095 0 3.37643 0C4.27192 0 5.13073 0.34467 5.76393 0.958186C6.39713 1.5717 6.75286 2.40381 6.75286 3.27145C6.75286 5.07778 5.24009 6.57392 3.37643 6.57392ZM28.115 27.2463H22.2974V18.391C22.2974 16.2806 22.2534 13.5742 19.2662 13.5742C16.235 13.5742 15.7705 15.8671 15.7705 18.239V27.2463H9.94664V9.05534H15.5382V11.5367H15.6198C16.3982 10.1075 18.2995 8.59919 21.1361 8.59919C27.0366 8.59919 28.1212 12.3639 28.1212 17.2537V27.2463H28.115Z" fill="white"/>
						</svg>
					</a>
				</div>

			</div>

		</div>
	</div>
</section>

<?php
$equipo_grid_titulo = get_option( 'tema_viera_abogados_equipo_grid_tit', 'NUESTROS EQUIPO' );
$equipo_grid_desc   = get_option( 'tema_viera_abogados_equipo_grid_desc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ac turpis erat. Mauris gravida ac risus condimentum efficitur. Fusce posuere, nulla vitae dignissim matti.' );
$equipo_grid_ids    = get_option( 'tema_viera_abogados_equipo_grid_ids', array() );

if ( ! empty( $equipo_grid_ids ) && is_array( $equipo_grid_ids ) ) {
	$equipo_grid_query = new WP_Query( array(
		'post_type'      => 'abogado',
		'post__in'       => $equipo_grid_ids,
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	) );
} else {
	$equipo_grid_query = false;
}
?>

<section class="section-equipo-grid">
	<div class="container">

		<div class="equipo-grid-header reveal">
			<?php if ( $equipo_grid_titulo ) : ?>
				<h2 class="equipo-grid-titulo"><?php echo esc_html( $equipo_grid_titulo ); ?></h2>
			<?php endif; ?>

			<?php if ( $equipo_grid_desc ) : ?>
				<p class="equipo-grid-desc"><?php echo wp_kses_post( $equipo_grid_desc ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( $equipo_grid_query && $equipo_grid_query->have_posts() ) : ?>
			<div class="equipo-grid-container">

				<?php while ( $equipo_grid_query->have_posts() ) :
					$equipo_grid_query->the_post();
					$post_id        = get_the_ID();
					$nombre         = get_the_title();
					$cargo          = tema_viera_get_abogado_meta( $post_id, 'cargo' );
					$biografia      = tema_viera_get_abogado_meta( $post_id, 'biografia' );
					$email          = tema_viera_get_abogado_meta( $post_id, 'email' );
					$linkedin       = tema_viera_get_abogado_meta( $post_id, 'linkedin' );
					$img_url        = get_the_post_thumbnail_url( $post_id, 'abogado-card' );
				?>
					<div class="equipo-grid-card" data-animate>
						<div class="equipo-grid-img">
							<?php if ( $img_url ) : ?>
								<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $nombre ); ?>">
							<?php endif; ?>
						</div>

						<div class="equipo-grid-content">
							<h3 class="equipo-card-nombre"><?php echo esc_html( $nombre ); ?></h3>
							<span class="equipo-card-cargo"><?php echo esc_html( $cargo ); ?></span>

							<p class="equipo-card-bio"><?php echo wp_kses_post( $biografia ); ?></p>

							<div class="equipo-card-footer">
								<?php if ( $email ) : ?>
									<a href="mailto:<?php echo esc_attr( $email ); ?>" class="equipo-card-email">
										<?php echo esc_html( $email ); ?>
									</a>
								<?php endif; ?>

								<a href="<?php echo esc_url( $linkedin ?: '#' ); ?>" target="_blank" rel="noopener noreferrer" class="linkedin-btn dark-square-small" aria-label="LinkedIn">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 28" fill="none">
										<path d="M6.29464 27.2463H0.464503V9.05534H6.29464V27.2463ZM3.37643 6.57392C1.51214 6.57392 0 5.07778 0 3.27145C1.33438e-08 2.40381 0.35573 1.5717 0.988934 0.958186C1.62214 0.34467 2.48095 0 3.37643 0C4.27192 0 5.13073 0.34467 5.76393 0.958186C6.39713 1.5717 6.75286 2.40381 6.75286 3.27145C6.75286 5.07778 5.24009 6.57392 3.37643 6.57392ZM28.115 27.2463H22.2974V18.391C22.2974 16.2806 22.2534 13.5742 19.2662 13.5742C16.235 13.5742 15.7705 15.8671 15.7705 18.239V27.2463H9.94664V9.05534H15.5382V11.5367H15.6198C16.3982 10.1075 18.2995 8.59919 21.1361 8.59919C27.0366 8.59919 28.1212 12.3639 28.1212 17.2537V27.2463H28.115Z" fill="white"/>
									</svg>
								</a>
							</div>
						</div>

					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>

			</div>
		<?php endif; ?>

	</div>
</section>

<?php
get_footer();
