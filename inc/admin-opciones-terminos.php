<?php
/**
 * Panel de Opciones — Página Términos y Condiciones
 *
 * Crea un menú independiente en el admin para editar el contenido
 * de la página "Términos y Condiciones" (template).
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Valores por defecto de la página de términos.
 *
 * @return array
 */
function tema_viera_terminos_defaults() {
	return array(
		'pre'    => 'LEGAL',
		'titulo' => 'Términos y Condiciones',
		'fecha'  => 'Última actualización: 1 de setiembre de 2026',
		'toc'    => 'EN ESTA PÁGINA',
		'intro'  => 'Por favor, lea atentamente los siguientes Términos y Condiciones antes de utilizar el sitio web de Viera Abogados. El uso del Sitio implica la aceptación plena de las condiciones aquí descritas.',
		'secciones' => array(
			array(
				'titulo'    => 'Aceptación de los Términos',
				'contenido' => 'Al acceder y utilizar el sitio web de Viera Abogados (en adelante, "el Sitio"), usted acepta quedar vinculado por los presentes Términos y Condiciones, así como por nuestra Política de Privacidad. Si no está de acuerdo con alguno de estos términos, le solicitamos no continuar utilizando el Sitio.',
			),
			array(
				'titulo'    => 'Descripción del Servicio',
				'contenido' => 'El Sitio tiene como finalidad brindar información general sobre los servicios legales que presta Viera Abogados, así como facilitar el contacto con nuestro equipo. La información publicada en el Sitio tiene carácter informativo y no constituye asesoría legal, ni genera una relación abogado-cliente entre el usuario y el estudio.',
			),
			array(
				'titulo'    => 'Uso del Sitio Web',
				'contenido' => 'El usuario se compromete a utilizar el Sitio de conformidad con la ley, la moral, el orden público y los presentes Términos y Condiciones. Queda prohibido el uso del Sitio con fines fraudulentos, ilícitos o que puedan dañar, inutilizar o sobrecargar los sistemas de Viera Abogados o de terceros.',
			),
			array(
				'titulo'    => 'Propiedad Intelectual',
				'contenido' => 'Todos los contenidos del Sitio, incluyendo textos, marcas, logotipos, imágenes y diseño, son propiedad de Viera Abogados o de terceros que han autorizado su uso, y se encuentran protegidos por la legislación peruana e internacional sobre propiedad intelectual. Queda prohibida su reproducción total o parcial sin autorización previa y por escrito.',
			),
			array(
				'titulo'    => 'Protección de Datos Personales',
				'contenido' => 'Los datos personales proporcionados a través de los formularios del Sitio serán tratados conforme a la Ley N° 29733, Ley de Protección de Datos Personales, y su reglamento. Dichos datos serán utilizados exclusivamente para atender consultas, agendar reuniones y brindar información sobre nuestros servicios, salvo que el usuario otorgue su consentimiento para una finalidad adicional.',
			),
			array(
				'titulo'    => 'Enlaces a Sitios de Terceros',
				'contenido' => 'El Sitio puede contener enlaces a páginas web de terceros. Viera Abogados no controla ni se responsabiliza por el contenido, las políticas de privacidad o las prácticas de dichos sitios, por lo que se recomienda al usuario revisar los términos correspondientes antes de utilizarlos.',
			),
			array(
				'titulo'    => 'Limitación de Responsabilidad',
				'contenido' => 'Viera Abogados no garantiza la disponibilidad continua o libre de errores del Sitio, y no será responsable por daños o perjuicios derivados del acceso o la imposibilidad de acceso al mismo. La información contenida en el Sitio puede ser modificada sin previo aviso.',
			),
			array(
				'titulo'    => 'Modificaciones a los Términos',
				'contenido' => 'Viera Abogados se reserva el derecho de modificar los presentes Términos y Condiciones en cualquier momento. Las modificaciones entrarán en vigencia desde su publicación en el Sitio, por lo que recomendamos revisar esta sección periódicamente.',
			),
			array(
				'titulo'    => 'Ley Aplicable y Jurisdicción',
				'contenido' => 'Los presentes Términos y Condiciones se rigen por las leyes de la República del Perú. Cualquier controversia derivada de su interpretación o aplicación será sometida a los jueces y tribunales de la ciudad de Lima, con renuncia expresa a cualquier otro fuero que pudiera corresponder.',
			),
			array(
				'titulo'    => 'Contacto',
				'contenido' => 'Para consultas relacionadas con estos Términos y Condiciones, puede escribirnos a contacto@viera.pe o comunicarse con nuestras oficinas ubicadas en Francisco del Castillo 236, Miraflores, Lima.',
			),
		),
	);
}

/**
 * Obtener una opción de términos con su valor por defecto.
 *
 * @param string $key Clave dentro de los defaults.
 * @return mixed
 */
function tema_viera_get_terminos_option( $key ) {
	$defaults = tema_viera_terminos_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';

	if ( 'secciones' === $key ) {
		$value = get_option( 'tema_viera_abogados_terminos_secciones', array() );
		return ( is_array( $value ) && ! empty( $value ) ) ? $value : $default;
	}

	$map = array(
		'pre'    => 'tema_viera_abogados_terminos_pre',
		'titulo' => 'tema_viera_abogados_terminos_titulo',
		'fecha'  => 'tema_viera_abogados_terminos_fecha',
		'toc'    => 'tema_viera_abogados_terminos_toc',
		'intro'  => 'tema_viera_abogados_terminos_intro',
	);

	if ( ! isset( $map[ $key ] ) ) {
		return $default;
	}

	return get_option( $map[ $key ], $default );
}

/**
 * Registrar menú de opciones.
 */
function tema_viera_add_admin_menu_terminos() {
	add_menu_page(
		esc_html__( 'Términos y Condiciones', 'tema-viera-abogados' ),
		esc_html__( 'Términos', 'tema-viera-abogados' ),
		'manage_options',
		'mi-tema-opciones-terminos',
		'tema_viera_opciones_terminos_page',
		'dashicons-media-document',
		27
	);
}
add_action( 'admin_menu', 'tema_viera_add_admin_menu_terminos' );

/**
 * Registrar settings.
 */
function tema_viera_register_terminos_settings() {
	register_setting( 'tema_viera_opciones_terminos', 'tema_viera_abogados_terminos_pre' );
	register_setting( 'tema_viera_opciones_terminos', 'tema_viera_abogados_terminos_titulo' );
	register_setting( 'tema_viera_opciones_terminos', 'tema_viera_abogados_terminos_fecha' );
	register_setting( 'tema_viera_opciones_terminos', 'tema_viera_abogados_terminos_toc' );
	register_setting( 'tema_viera_opciones_terminos', 'tema_viera_abogados_terminos_intro' );
	register_setting( 'tema_viera_opciones_terminos', 'tema_viera_abogados_terminos_secciones' );
}
add_action( 'admin_init', 'tema_viera_register_terminos_settings' );

/**
 * Renderizar un item de sección de términos.
 *
 * @param int   $index   Índice.
 * @param array $seccion Datos.
 */
function tema_viera_render_termino_item( $index, $seccion ) {
	$titulo    = isset( $seccion['titulo'] ) ? $seccion['titulo'] : '';
	$contenido = isset( $seccion['contenido'] ) ? $seccion['contenido'] : '';
	?>
	<div class="mi-tema-termino-item" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="btn-remove-termino" onclick="removeTermino(<?php echo esc_attr( $index ); ?>)">
			<?php esc_html_e( 'Eliminar', 'tema-viera-abogados' ); ?>
		</button>
		<div style="margin-bottom: 10px;">
			<label><?php esc_html_e( 'Título de la sección', 'tema-viera-abogados' ); ?></label>
			<input type="text" name="terminos[<?php echo esc_attr( $index ); ?>][titulo]" value="<?php echo esc_attr( $titulo ); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
		</div>
		<div style="margin-bottom: 10px;">
			<label><?php esc_html_e( 'Contenido', 'tema-viera-abogados' ); ?></label>
			<textarea name="terminos[<?php echo esc_attr( $index ); ?>][contenido]" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-height: 90px;"><?php echo esc_textarea( $contenido ); ?></textarea>
		</div>
	</div>
	<?php
}

/**
 * Renderizar la página de opciones.
 */
function tema_viera_opciones_terminos_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'No tienes permiso para acceder a esta página.', 'tema-viera-abogados' ) );
	}

	if ( isset( $_POST['submit'] ) && isset( $_POST['tema_viera_opciones_terminos_nonce'] ) ) {
		if ( wp_verify_nonce( $_POST['tema_viera_opciones_terminos_nonce'], 'tema_viera_opciones_terminos_action' ) ) {
			tema_viera_procesar_opciones_terminos();
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Opciones guardadas correctamente.', 'tema-viera-abogados' ) . '</p></div>';
		}
	}

	$pre       = tema_viera_get_terminos_option( 'pre' );
	$titulo    = tema_viera_get_terminos_option( 'titulo' );
	$fecha     = tema_viera_get_terminos_option( 'fecha' );
	$toc       = tema_viera_get_terminos_option( 'toc' );
	$intro     = tema_viera_get_terminos_option( 'intro' );
	$secciones = tema_viera_get_terminos_option( 'secciones' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Términos y Condiciones', 'tema-viera-abogados' ); ?></h1>

		<form method="post">
			<?php wp_nonce_field( 'tema_viera_opciones_terminos_action', 'tema_viera_opciones_terminos_nonce' ); ?>

			<style>
				.mi-tema-form-section { background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #e0e0e0; border-radius: 4px; }
				.mi-tema-form-section h2 { margin-top: 0; color: #1a3a52; border-bottom: 2px solid #d4af37; padding-bottom: 10px; }
				.mi-tema-form-group { margin-bottom: 20px; }
				.mi-tema-form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #333; }
				.mi-tema-form-group input[type="text"], .mi-tema-form-group textarea { width: 100%; max-width: 700px; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
				.mi-tema-form-group textarea { min-height: 100px; resize: vertical; }
				.mi-tema-termino-item { background: #f7f9fc; border: 1px solid #e2e6ed; border-radius: 4px; padding: 15px; margin-bottom: 15px; position: relative; }
				.btn-remove-termino { position: absolute; top: 10px; right: 10px; background: #dc3545; color: #fff; border: none; border-radius: 4px; padding: 4px 10px; cursor: pointer; font-size: 12px; }
				.btn-remove-termino:hover { background: #c82333; }
				.submit { margin-top: 30px; }
				.submit button { background: #1a3a52; color: white; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: 600; }
				.submit button:hover { background: #0f1419; }
			</style>

			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Encabezado', 'tema-viera-abogados' ); ?></h2>
				<div class="mi-tema-form-group">
					<label for="terminos_pre"><?php esc_html_e( 'Pre-título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="terminos_pre" name="terminos_pre" value="<?php echo esc_attr( $pre ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="terminos_titulo"><?php esc_html_e( 'Título', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="terminos_titulo" name="terminos_titulo" value="<?php echo esc_attr( $titulo ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="terminos_fecha"><?php esc_html_e( 'Fecha de última actualización', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="terminos_fecha" name="terminos_fecha" value="<?php echo esc_attr( $fecha ); ?>" />
				</div>
			</div>

			<div class="mi-tema-form-section">
				<h2><?php esc_html_e( 'Índice y contenido', 'tema-viera-abogados' ); ?></h2>
				<div class="mi-tema-form-group">
					<label for="terminos_toc"><?php esc_html_e( 'Título del índice (TOC)', 'tema-viera-abogados' ); ?></label>
					<input type="text" id="terminos_toc" name="terminos_toc" value="<?php echo esc_attr( $toc ); ?>" />
				</div>
				<div class="mi-tema-form-group">
					<label for="terminos_intro"><?php esc_html_e( 'Párrafo introductorio', 'tema-viera-abogados' ); ?></label>
					<textarea id="terminos_intro" name="terminos_intro"><?php echo esc_textarea( $intro ); ?></textarea>
				</div>

				<p><strong><?php esc_html_e( 'Secciones (el índice se genera automáticamente a partir de los títulos)', 'tema-viera-abogados' ); ?></strong></p>
				<div id="terminos-list">
					<?php
					if ( ! empty( $secciones ) && is_array( $secciones ) ) {
						foreach ( $secciones as $index => $seccion ) {
							tema_viera_render_termino_item( $index, $seccion );
						}
					}
					?>
				</div>
				<button type="button" id="btn-add-termino" class="button button-primary">
					<?php esc_html_e( '+ Agregar Sección', 'tema-viera-abogados' ); ?>
				</button>
			</div>

			<div class="submit">
				<button type="submit" name="submit" class="button button-primary button-large">
					<?php esc_html_e( 'Guardar Cambios', 'tema-viera-abogados' ); ?>
				</button>
			</div>
		</form>
	</div>

	<script>
		var terminoIndex = <?php echo ! empty( $secciones ) ? count( (array) $secciones ) : 0; ?>;

		document.getElementById('btn-add-termino').addEventListener('click', function( e ) {
			e.preventDefault();
			var container = document.getElementById('terminos-list');
			var html = '<div class="mi-tema-termino-item" data-index="' + terminoIndex + '">' +
				'<button type="button" class="btn-remove-termino" onclick="removeTermino(' + terminoIndex + ')">Eliminar</button>' +
				'<div style="margin-bottom: 10px;">' +
					'<label>Título de la sección</label>' +
					'<input type="text" name="terminos[' + terminoIndex + '][titulo]" value="" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />' +
				'</div>' +
				'<div style="margin-bottom: 10px;">' +
					'<label>Contenido</label>' +
					'<textarea name="terminos[' + terminoIndex + '][contenido]" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-height: 90px;"></textarea>' +
				'</div>' +
			'</div>';
			container.insertAdjacentHTML('beforeend', html);
			terminoIndex++;
		});

		function removeTermino( index ) {
			var item = document.querySelector('.mi-tema-termino-item[data-index="' + index + '"]');
			if ( item ) {
				item.remove();
			}
		}
	</script>
	<?php
}

/**
 * Procesar y guardar las opciones.
 */
function tema_viera_procesar_opciones_terminos() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['terminos_pre'] ) ) {
		update_option( 'tema_viera_abogados_terminos_pre', sanitize_text_field( $_POST['terminos_pre'] ) );
	}
	if ( isset( $_POST['terminos_titulo'] ) ) {
		update_option( 'tema_viera_abogados_terminos_titulo', sanitize_text_field( $_POST['terminos_titulo'] ) );
	}
	if ( isset( $_POST['terminos_fecha'] ) ) {
		update_option( 'tema_viera_abogados_terminos_fecha', sanitize_text_field( $_POST['terminos_fecha'] ) );
	}
	if ( isset( $_POST['terminos_toc'] ) ) {
		update_option( 'tema_viera_abogados_terminos_toc', sanitize_text_field( $_POST['terminos_toc'] ) );
	}
	if ( isset( $_POST['terminos_intro'] ) ) {
		update_option( 'tema_viera_abogados_terminos_intro', wp_kses_post( $_POST['terminos_intro'] ) );
	}

	if ( isset( $_POST['terminos'] ) && is_array( $_POST['terminos'] ) ) {
		$secciones = array();
		foreach ( $_POST['terminos'] as $seccion ) {
			$titulo = isset( $seccion['titulo'] ) ? sanitize_text_field( $seccion['titulo'] ) : '';
			$contenido = isset( $seccion['contenido'] ) ? wp_kses_post( $seccion['contenido'] ) : '';
			if ( '' === trim( $titulo ) && '' === trim( wp_strip_all_tags( $contenido ) ) ) {
				continue;
			}
			$secciones[] = array(
				'titulo'    => $titulo,
				'contenido' => $contenido,
			);
		}
		update_option( 'tema_viera_abogados_terminos_secciones', $secciones );
	}
}
