<?php
/**
 * Header del Tema
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="preloader" class="preloader">
		<div class="preloader-bg"></div>
		<div class="preloader-logo">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 293 701" fill="none">
				<defs>
					<linearGradient id="fill-gradient" x1="0" y1="1" x2="0" y2="0">
						<stop offset="0%" stop-color="white" stop-opacity="0.4"/>
						<stop offset="60%" stop-color="white" stop-opacity="0.9"/>
						<stop offset="85%" stop-color="white" stop-opacity="1"/>
						<stop offset="100%" stop-color="white" stop-opacity="0.7"/>
					</linearGradient>
					<clipPath id="logo-clip">
						<path d="M227.042 0L98.5026 285.06L58.8365 196.312H0L97.7959 415.468L286.055 0H227.042Z"/>
						<path d="M65.4624 700.791L193.913 415.731L233.668 504.478H292.504L194.708 285.323L6.36084 700.791H65.4624Z"/>
					</clipPath>
				</defs>
				<path class="preloader-logo-outline" d="M227.042 0L98.5026 285.06L58.8365 196.312H0L97.7959 415.468L286.055 0H227.042Z M65.4624 700.791L193.913 415.731L233.668 504.478H292.504L194.708 285.323L6.36084 700.791H65.4624Z" stroke="white" stroke-width="2" fill="none"/>
				<g clip-path="url(#logo-clip)">
					<rect class="preloader-fill" x="0" y="701" width="293" height="701" fill="url(#fill-gradient)">
						<animate attributeName="y" from="701" to="0" dur="2.2s" fill="freeze" calcMode="spline" keySplines="0.25 0.1 0.25 1" keyTimes="0;1"/>
					</rect>
				</g>
			</svg>
		</div>
	</div>

	<?php get_template_part( 'template-parts/header' ); ?>

	<main id="main-content" role="main">
