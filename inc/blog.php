<?php
/**
 * Blog
 *
 * Categorías, helpers de renderizado y endpoints AJAX de la página de Blog.
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Categorías (clasificaciones) del blog, en orden de aparición.
 *
 * @return array Lista de array( 'slug' => string, 'name' => string ).
 */
function tema_viera_blog_categories() {
	$cats = array(
		'litigios-civiles'         => 'Litigios Civiles',
		'litigios-administrativos' => 'Litigios Administrativos',
		'litigios-penales'         => 'Litigios Penales',
		'litigios-laborales'       => 'Litigios Laborales',
		'reconocimientos'          => 'Reconocimientos',
	);

	$out = array();
	foreach ( $cats as $slug => $name ) {
		$out[] = array(
			'slug' => $slug,
			'name' => tema_viera_t( $name ),
		);
	}
	return $out;
}

/**
 * Filtros del blog: solo las categorías que tienen al menos una noticia publicada.
 *
 * @return array Lista de array( 'slug' => string, 'name' => string ).
 */
function tema_viera_blog_filtros() {
	$out = array();
	foreach ( tema_viera_blog_categories() as $cat ) {
		$term = get_term_by( 'slug', $cat['slug'], 'category' );
		if ( $term && ! is_wp_error( $term ) && (int) $term->count > 0 ) {
			$out[] = $cat;
		}
	}
	return $out;
}

/**
 * Registra las categorías del blog si no existen.
 */
function tema_viera_register_blog_categories() {
	foreach ( tema_viera_blog_categories() as $cat ) {
		if ( ! term_exists( $cat['slug'], 'category' ) ) {
			wp_insert_term( $cat['name'], 'category', array( 'slug' => $cat['slug'] ) );
		}
	}
}
add_action( 'after_setup_theme', 'tema_viera_register_blog_categories' );

/**
 * URL de la página de Blog en el idioma actual.
 *
 * @return string
 */
function tema_viera_blog_url() {
	$page = get_pages( array(
		'meta_key'   => '_wp_page_template',
		'meta_value' => 'page-blog.php',
		'number'     => 1,
	) );

	if ( ! empty( $page ) ) {
		$url = get_permalink( tema_viera_post_translated( $page[0]->ID ) );
		if ( $url ) {
			return $url;
		}
	}

	$page = get_page_by_path( 'blog' );
	if ( $page ) {
		$url = get_permalink( tema_viera_post_translated( $page->ID ) );
		if ( $url ) {
			return $url;
		}
	}

	return home_url( '/blog/' );
}

/**
 * Devuelve las entradas del blog (todas, ordenadas por fecha descendente).
 *
 * @param string $categoria Slug de categoría (opcional).
 * @return WP_Query
 */
function tema_viera_blog_query( $categoria = '' ) {
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( $categoria ) {
		$args['category_name'] = $categoria;
	}

	return new WP_Query( $args );
}

/**
 * Nombre de la categoría principal de una noticia.
 *
 * @param int $post_id ID del post.
 * @return string
 */
function tema_viera_blog_post_category( $post_id ) {
	$cats = get_the_category( $post_id );
	if ( ! empty( $cats ) ) {
		return strtoupper( tema_viera_t( $cats[0]->name ) );
	}
	return '';
}

/**
 * Fecha legible en español.
 *
 * @param int    $post_id ID del post.
 * @param string $tipo    'largo' (5 de septiembre, 2026) o 'corto' (2 sept 2026).
 * @return string
 */
function tema_viera_blog_fecha( $post_id, $tipo = 'largo' ) {
	$meses_largo = array( 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre' );
	$meses_corto = array( 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sept', 'oct', 'nov', 'dic' );

	$ts = get_post_time( 'U', true, $post_id );
	$d  = (int) gmdate( 'j', $ts );
	$m  = (int) gmdate( 'n', $ts ) - 1;
	$y  = (int) gmdate( 'Y', $ts );

	if ( 'corto' === $tipo ) {
		return $d . ' ' . $meses_corto[ $m ] . ' ' . $y;
	}
	return $d . ' de ' . $meses_largo[ $m ] . ', ' . $y;
}

/**
 * Tiempo estimado de lectura.
 *
 * @param int $post_id ID del post.
 * @return string
 */
function tema_viera_blog_lectura( $post_id ) {
	$contenido = get_post_field( 'post_content', $post_id );
	$palabras  = str_word_count( wp_strip_all_tags( (string) $contenido ) );
	$minutos   = max( 1, (int) ceil( $palabras / 200 ) );
	return $minutos . ' ' . tema_viera_t( 'min de lectura' );
}

/**
 * Extracto traducido para tarjetas.
 *
 * @param int $post_id ID del post.
 * @param int $palabras Número de palabras.
 * @return string
 */
function tema_viera_blog_excerpt( $post_id, $palabras = 20 ) {
	return wp_trim_words( wp_strip_all_tags( tema_viera_post_contenido_t( $post_id ) ), $palabras, '…' );
}

/**
 * Imprime la noticia principal (más reciente).
 *
 * @param WP_Post $post Post.
 */
function tema_viera_blog_render_featured( $post ) {
	$id       = (int) $post->ID;
	$enlace   = get_permalink( $id );
	$img_url  = get_the_post_thumbnail_url( $id, 'large' );
	$titulo   = tema_viera_post_titulo( $id );
	$categoria = tema_viera_blog_post_category( $id );
	$extracto = tema_viera_blog_excerpt( $id, 30 );
	?>
	<article class="blog-featured">
		<a class="blog-featured-media" href="<?php echo esc_url( $enlace ); ?>" aria-label="<?php echo esc_attr( $titulo ); ?>">
			<?php if ( $img_url ) : ?>
				<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $titulo ); ?>">
			<?php endif; ?>
		</a>
		<div class="blog-featured-body">
			<?php if ( $categoria ) : ?>
				<span class="blog-badge"><?php echo esc_html( $categoria ); ?></span>
			<?php endif; ?>
			<h2 class="blog-featured-title">
				<a href="<?php echo esc_url( $enlace ); ?>"><?php echo esc_html( $titulo ); ?></a>
			</h2>
			<p class="blog-featured-excerpt"><?php echo esc_html( $extracto ); ?></p>
			<div class="blog-meta">
				<span><?php echo esc_html( tema_viera_blog_fecha( $id ) ); ?></span>
				<span class="blog-meta-sep">·</span>
				<span><?php echo esc_html( tema_viera_blog_lectura( $id ) ); ?></span>
			</div>
			<a class="blog-featured-link" href="<?php echo esc_url( $enlace ); ?>">
				<?php echo esc_html( tema_viera_t( 'Leer artículo completo' ) ); ?>
				<svg xmlns="http://www.w3.org/2000/svg" width="14" height="8" viewBox="0 0 14 8" fill="none" aria-hidden="true"><path d="M13.7437 4.59388L10.6436 7.69406C10.4727 7.86493 10.2488 7.95035 10.0248 7.95035C9.80088 7.95035 9.57696 7.86493 9.40609 7.69406C9.0644 7.35234 9.0644 6.79833 9.40609 6.45662L11.0126 4.85017H0.875C0.391754 4.85017 0 4.45842 0 3.97517C0 3.49193 0.391754 3.10017 0.875 3.10017H11.0126L9.40609 1.49373C9.0644 1.15201 9.0644 0.598001 9.40609 0.256286C9.74783 -0.0854287 10.3018 -0.0854287 10.6436 0.256286L13.7437 3.35647C14.0854 3.69815 14.0854 4.25219 13.7437 4.59388Z" fill="currentColor"/></svg>
			</a>
		</div>
	</article>
	<?php
}

/**
 * Imprime una tarjeta de noticia del grid.
 *
 * @param WP_Post $post Post.
 */
function tema_viera_blog_render_card( $post ) {
	$id        = (int) $post->ID;
	$enlace    = get_permalink( $id );
	$img_url   = get_the_post_thumbnail_url( $id, 'medium_large' );
	$titulo    = tema_viera_post_titulo( $id );
	$categoria = tema_viera_blog_post_category( $id );
	$extracto  = tema_viera_blog_excerpt( $id, 18 );
	?>
	<article class="blog-card">
		<a class="blog-card-media" href="<?php echo esc_url( $enlace ); ?>" aria-label="<?php echo esc_attr( $titulo ); ?>">
			<?php if ( $img_url ) : ?>
				<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $titulo ); ?>">
			<?php endif; ?>
		</a>
		<div class="blog-card-body">
			<?php if ( $categoria ) : ?>
				<span class="blog-badge"><?php echo esc_html( $categoria ); ?></span>
			<?php endif; ?>
			<h3 class="blog-card-title">
				<a href="<?php echo esc_url( $enlace ); ?>"><?php echo esc_html( $titulo ); ?></a>
			</h3>
			<p class="blog-card-excerpt"><?php echo esc_html( $extracto ); ?></p>
			<time class="blog-card-date" datetime="<?php echo esc_attr( get_the_date( 'c', $id ) ); ?>"><?php echo esc_html( tema_viera_blog_fecha( $id, 'corto' ) ); ?></time>
		</div>
	</article>
	<?php
}

/**
 * Autor (abogado) de una noticia, o null si no tiene.
 *
 * @param int $post_id ID del post.
 * @return array|null
 */
function tema_viera_post_autor( $post_id ) {
	$autor_id = (int) get_post_meta( $post_id, '_post_autor_id', true );
	if ( ! $autor_id || 'abogado' !== get_post_type( $autor_id ) ) {
		return null;
	}

	return array(
		'id'     => $autor_id,
		'nombre' => tema_viera_abogado_titulo( $autor_id ),
		'cargo'  => tema_viera_abogado_meta_t( $autor_id, 'cargo' ),
		'bio'    => tema_viera_abogado_meta_t( $autor_id, 'biografia' ),
		'img'    => get_the_post_thumbnail_url( $autor_id, 'medium_large' ),
	);
}

/**
 * Bloques de contenido del cuerpo del artículo.
 *
 * @param int $post_id ID del post.
 * @return array
 */
function tema_viera_post_bloques( $post_id ) {
	$bloques = get_post_meta( $post_id, '_post_bloques', true );
	return is_array( $bloques ) ? $bloques : array();
}

/**
 * IDs de los artículos relacionados seleccionados.
 *
 * @param int $post_id ID del post.
 * @return array
 */
function tema_viera_post_relacionados( $post_id ) {
	$rel = get_post_meta( $post_id, '_post_relacionados', true );
	return is_array( $rel ) ? $rel : array();
}

/**
 * Imprime una tarjeta de artículo relacionado.
 *
 * @param WP_Post $post Post.
 */
function tema_viera_blog_render_related_card( $post ) {
	$id        = (int) $post->ID;
	$enlace    = get_permalink( $id );
	$img_url   = get_the_post_thumbnail_url( $id, 'medium_large' );
	$titulo    = tema_viera_post_titulo( $id );
	$categoria = tema_viera_blog_post_category( $id );
	?>
	<article class="sp-related-card">
		<a class="sp-related-media" href="<?php echo esc_url( $enlace ); ?>" aria-label="<?php echo esc_attr( $titulo ); ?>">
			<?php if ( $img_url ) : ?>
				<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $titulo ); ?>">
			<?php endif; ?>
		</a>
		<div class="sp-related-body">
			<?php if ( $categoria ) : ?>
				<span class="blog-badge"><?php echo esc_html( $categoria ); ?></span>
			<?php endif; ?>
			<h3 class="sp-related-card-title"><a href="<?php echo esc_url( $enlace ); ?>"><?php echo esc_html( $titulo ); ?></a></h3>
			<time class="sp-related-date" datetime="<?php echo esc_attr( get_the_date( 'c', $id ) ); ?>"><?php echo esc_html( tema_viera_blog_fecha( $id, 'corto' ) ); ?></time>
		</div>
	</article>
	<?php
}

/**
 * Endpoint AJAX: filtra y carga más artículos del blog.
 */
function tema_viera_blog_ajax() {
	check_ajax_referer( 'tema-viera-abogados-nonce', 'nonce' );

	$categoria = isset( $_POST['categoria'] ) ? sanitize_title( wp_unslash( $_POST['categoria'] ) ) : '';
	$offset    = isset( $_POST['offset'] ) ? absint( $_POST['offset'] ) : 0;
	$mode      = isset( $_POST['mode'] ) ? sanitize_key( wp_unslash( $_POST['mode'] ) ) : 'load';

	$query = tema_viera_blog_query( $categoria );
	$posts = $query->posts;

	$featured = null;
	$grid     = array();
	$has_more = false;

	if ( 'filter' === $mode ) {
		$featured = ! empty( $posts ) ? array_shift( $posts ) : null;
		$grid     = array_slice( $posts, 0, 6 );
		$has_more = count( $posts ) > 6;
	} else {
		if ( ! empty( $posts ) ) {
			array_shift( $posts ); // Quitar la noticia principal.
		}
		$grid     = array_slice( $posts, $offset, 6 );
		$has_more = ( $offset + 6 ) < count( $posts );
	}

	ob_start();
	if ( $featured ) {
		tema_viera_blog_render_featured( $featured );
	}
	$featured_html = ob_get_clean();

	ob_start();
	foreach ( $grid as $p ) {
		tema_viera_blog_render_card( $p );
	}
	$grid_html = ob_get_clean();

	wp_send_json_success( array(
		'featured' => $featured_html,
		'grid'     => $grid_html,
		'has_more' => $has_more,
		'count'    => count( $grid ),
	) );
}
add_action( 'wp_ajax_tema_viera_blog_load', 'tema_viera_blog_ajax' );
add_action( 'wp_ajax_nopriv_tema_viera_blog_load', 'tema_viera_blog_ajax' );
