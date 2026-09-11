<?php
/**
 * Plantilla: Single Post (Noticia)
 *
 * Página de detalle de cada noticia con encabezado, cuerpo editable,
 * autor opcional y artículos relacionados.
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		$post_id   = get_the_ID();
		$titulo    = tema_viera_post_titulo( $post_id );
		$descripcion = tema_viera_post_meta_t( $post_id, '_post_descripcion' );
		$autor     = tema_viera_post_autor( $post_id );
		$bloques   = tema_viera_post_bloques( $post_id );
		$relacionados = tema_viera_post_relacionados( $post_id );
		$cover_url = has_post_thumbnail() ? get_the_post_thumbnail_url( $post_id, 'full' ) : '';

		$cats     = get_the_category( $post_id );
		$cat_name = ! empty( $cats ) ? tema_viera_t( $cats[0]->name ) : '';
		$cat_slug = ! empty( $cats ) ? $cats[0]->slug : '';

		$share_url = get_permalink( $post_id );
		?>
		<article>

			<!-- Breadcrumb -->
			<div class="container">
				<nav class="sp-breadcrumb" aria-label="<?php esc_attr_e( 'Miga de pan', 'tema-viera-abogados' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Inicio', 'tema-viera-abogados' ); ?></a>
					<span class="sp-breadcrumb-sep">/</span>
					<a href="<?php echo esc_url( tema_viera_blog_url() ); ?>"><?php esc_html_e( 'Blog', 'tema-viera-abogados' ); ?></a>
					<?php if ( $cat_name ) : ?>
						<span class="sp-breadcrumb-sep">/</span>
						<a href="<?php echo esc_url( tema_viera_blog_url() . '?cat=' . $cat_slug ); ?>"><?php echo esc_html( $cat_name ); ?></a>
					<?php endif; ?>
				</nav>
			</div>

			<!-- Encabezado -->
			<header class="sp-header">
				<div class="container">
					<div class="sp-header-inner">
						<?php if ( $cat_name ) : ?>
							<span class="blog-badge"><?php echo esc_html( strtoupper( $cat_name ) ); ?></span>
						<?php endif; ?>

						<h1 class="sp-title"><?php echo esc_html( $titulo ); ?></h1>

						<?php if ( $descripcion ) : ?>
							<p class="sp-excerpt"><?php echo esc_html( $descripcion ); ?></p>
						<?php endif; ?>

						<div class="sp-meta">
							<?php if ( $autor && ! empty( $autor['img'] ) ) : ?>
								<img class="sp-author-avatar" src="<?php echo esc_url( $autor['img'] ); ?>" alt="<?php echo esc_attr( $autor['nombre'] ); ?>">
							<?php endif; ?>
							<div class="sp-meta-text">
								<?php if ( $autor ) : ?>
									<span class="sp-author-name"><?php echo esc_html( $autor['nombre'] ); ?></span>
								<?php endif; ?>
								<span class="sp-date"><?php echo esc_html( tema_viera_blog_fecha( $post_id ) . ' · ' . tema_viera_blog_lectura( $post_id ) ); ?></span>
							</div>
						</div>
					</div>
				</div>
			</header>

			<!-- Imagen de portada -->
			<?php if ( $cover_url ) : ?>
				<div class="container">
					<div class="sp-cover">
						<img src="<?php echo esc_url( $cover_url ); ?>" alt="<?php echo esc_attr( $titulo ); ?>">
					</div>
				</div>
			<?php endif; ?>

			<!-- Cuerpo -->
			<div class="container">
				<div class="sp-body">
					<?php foreach ( $bloques as $bloque ) :
						$subtitulo   = isset( $bloque['subtitulo'] ) ? trim( (string) $bloque['subtitulo'] ) : '';
						$descripcion = isset( $bloque['descripcion'] ) ? (string) $bloque['descripcion'] : '';
						$cita        = isset( $bloque['cita'] ) ? trim( (string) $bloque['cita'] ) : '';
						$cita_autor  = isset( $bloque['cita_autor'] ) ? absint( $bloque['cita_autor'] ) : 0;
						$lista       = isset( $bloque['lista'] ) ? trim( (string) $bloque['lista'] ) : '';
					?>
						<?php if ( $subtitulo ) : ?>
							<h2 class="sp-subtitle"><?php echo esc_html( tema_viera_t( $subtitulo ) ); ?></h2>
						<?php endif; ?>

						<?php if ( $descripcion ) : ?>
							<div class="sp-p"><?php echo wp_kses_post( wpautop( tema_viera_t( $descripcion ) ) ); ?></div>
						<?php endif; ?>

						<?php if ( $cita ) : ?>
							<blockquote class="sp-quote">
								<p><?php echo esc_html( tema_viera_t( $cita ) ); ?></p>
								<?php if ( $cita_autor ) : ?>
									<cite>
										<span class="sp-quote-name"><?php echo esc_html( tema_viera_abogado_titulo( $cita_autor ) ); ?></span>
										<?php $cargo = tema_viera_abogado_meta_t( $cita_autor, 'cargo' ); ?>
										<?php if ( $cargo ) : ?>
											<span class="sp-quote-cargo"><?php echo esc_html( $cargo ); ?></span>
										<?php endif; ?>
									</cite>
								<?php endif; ?>
							</blockquote>
						<?php endif; ?>

						<?php if ( $lista ) : ?>
							<?php
							$items = array_filter( array_map( 'trim', explode( "\n", $lista ) ) );
							?>
							<?php if ( ! empty( $items ) ) : ?>
								<ul class="sp-list">
									<?php foreach ( $items as $item ) : ?>
										<li><?php echo esc_html( tema_viera_t( $item ) ); ?></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Compartir -->
			<div class="container">
				<div class="sp-share">
					<span class="sp-share-label"><?php echo esc_html( tema_viera_t( 'COMPARTIR' ) ); ?></span>
					<a class="sp-share-btn" href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $share_url ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">in</a>
					<a class="sp-share-btn" href="<?php echo esc_url( 'https://twitter.com/intent/tweet?url=' . rawurlencode( $share_url ) . '&text=' . rawurlencode( $titulo ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="X">X</a>
					<a class="sp-share-btn" href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $share_url ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">f</a>
					<button type="button" class="sp-share-btn" data-copy="<?php echo esc_url( $share_url ); ?>" aria-label="<?php esc_attr_e( 'Copiar enlace', 'tema-viera-abogados' ); ?>">🔗</button>
				</div>
			</div>

			<!-- Bio del autor -->
			<?php if ( $autor ) : ?>
				<div class="container">
					<div class="sp-author-bio">
						<?php if ( ! empty( $autor['img'] ) ) : ?>
							<img class="sp-author-bio-img" src="<?php echo esc_url( $autor['img'] ); ?>" alt="<?php echo esc_attr( $autor['nombre'] ); ?>">
						<?php endif; ?>
						<div class="sp-author-bio-content">
							<span class="sp-author-bio-label"><?php esc_html_e( 'ESCRITO POR', 'tema-viera-abogados' ); ?></span>
							<h3 class="sp-author-bio-name"><?php echo esc_html( $autor['nombre'] ); ?><?php echo $autor['cargo'] ? ' — ' . esc_html( $autor['cargo'] ) : ''; ?></h3>
							<?php if ( $autor['bio'] ) : ?>
								<div class="sp-author-bio-text"><?php echo wp_kses_post( $autor['bio'] ); ?></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<!-- Artículos relacionados -->
			<?php if ( ! empty( $relacionados ) ) : ?>
				<?php
				$rel_ids = array_slice( array_map( 'absint', $relacionados ), 0, 3 );
				?>
				<div class="container">
					<h2 class="sp-related-title"><?php esc_html_e( 'Artículos relacionados', 'tema-viera-abogados' ); ?></h2>
					<div class="sp-related-grid">
						<?php foreach ( $rel_ids as $rid ) :
							$rp = get_post( $rid );
							if ( $rp ) {
								tema_viera_blog_render_related_card( $rp );
							}
						endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

		</article>

		<?php
	endwhile;
else :
	?>
	<div class="container" style="padding: var(--spacing-3xl) 0; text-align:center;">
		<h1><?php esc_html_e( 'Noticia no encontrada', 'tema-viera-abogados' ); ?></h1>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="display:inline-block; margin-top:var(--spacing-lg);">
			<?php esc_html_e( 'Volver al inicio', 'tema-viera-abogados' ); ?>
		</a>
	</div>
	<?php
endif;

get_footer();
