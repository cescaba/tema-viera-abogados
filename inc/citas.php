<?php
/**
 * Citas / Reservas
 *
 * CPT "cita" para guardar las reservas del calendario de la landing,
 * junto con los endpoints AJAX para consultar horarios y crear reservas.
 *
 * @package TemaVieraAbogados
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registrar el Custom Post Type "cita".
 */
function tema_viera_register_cpt_citas() {
	$labels = array(
		'name'               => esc_html_x( 'Citas', 'post type general name', 'tema-viera-abogados' ),
		'singular_name'      => esc_html_x( 'Cita', 'post type singular name', 'tema-viera-abogados' ),
		'menu_name'          => esc_html_x( 'Citas', 'admin menu', 'tema-viera-abogados' ),
		'name_admin_bar'     => esc_html_x( 'Cita', 'add new on admin bar', 'tema-viera-abogados' ),
		'add_new'            => esc_html__( 'Agregar Nueva', 'tema-viera-abogados' ),
		'add_new_item'       => esc_html__( 'Agregar Nueva Cita', 'tema-viera-abogados' ),
		'new_item'           => esc_html__( 'Nueva Cita', 'tema-viera-abogados' ),
		'edit_item'          => esc_html__( 'Editar Cita', 'tema-viera-abogados' ),
		'view_item'          => esc_html__( 'Ver Cita', 'tema-viera-abogados' ),
		'all_items'          => esc_html__( 'Todas las Citas', 'tema-viera-abogados' ),
		'search_items'       => esc_html__( 'Buscar Citas', 'tema-viera-abogados' ),
		'not_found'          => esc_html__( 'No se encontraron citas.', 'tema-viera-abogados' ),
		'not_found_in_trash' => esc_html__( 'No se encontraron citas en la papelera.', 'tema-viera-abogados' ),
	);

	$args = array(
		'labels'             => $labels,
		'description'        => esc_html__( 'Reservas del calendario de citas de la landing', 'tema-viera-abogados' ),
		'public'             => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'menu_icon'          => 'dashicons-calendar-alt',
		'supports'           => array( 'title' ),
		'show_in_rest'       => false,
		'exclude_from_search' => true,
		'publicly_queryable' => false,
	);

	register_post_type( 'cita', $args );
}
add_action( 'init', 'tema_viera_register_cpt_citas' );

/**
 * Columnas del listado de citas.
 */
function tema_viera_citas_columns( $columns ) {
	$nuevas = array(
		'cb'             => isset( $columns['cb'] ) ? $columns['cb'] : '',
		'title'          => esc_html__( 'Nombre', 'tema-viera-abogados' ),
		'cita_fecha'     => esc_html__( 'Fecha', 'tema-viera-abogados' ),
		'cita_hora'      => esc_html__( 'Hora', 'tema-viera-abogados' ),
		'cita_whatsapp'  => esc_html__( 'WhatsApp', 'tema-viera-abogados' ),
		'cita_servicio'  => esc_html__( 'Servicio', 'tema-viera-abogados' ),
		'date'           => esc_html__( 'Registrada', 'tema-viera-abogados' ),
	);
	return $nuevas;
}
add_filter( 'manage_cita_posts_columns', 'tema_viera_citas_columns' );

function tema_viera_citas_columns_content( $column, $post_id ) {
	switch ( $column ) {
		case 'cita_fecha':
			$fecha = get_post_meta( $post_id, '_cita_fecha', true );
			echo esc_html( $fecha ? mysql2date( 'd/m/Y', $fecha ) : '—' );
			break;
		case 'cita_hora':
			echo esc_html( get_post_meta( $post_id, '_cita_hora', true ) );
			break;
		case 'cita_whatsapp':
			echo esc_html( get_post_meta( $post_id, '_cita_whatsapp', true ) );
			break;
		case 'cita_servicio':
			echo esc_html( get_post_meta( $post_id, '_cita_servicio', true ) );
			break;
	}
}
add_action( 'manage_cita_posts_custom_column', 'tema_viera_citas_columns_content', 10, 2 );

/**
 * Meta box para editar los datos de la cita.
 */
function tema_viera_citas_metabox() {
	add_meta_box(
		'tema_viera_citas_detalle',
		esc_html__( 'Detalles de la Cita', 'tema-viera-abogados' ),
		'tema_viera_citas_metabox_render',
		'cita',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'tema_viera_citas_metabox' );

function tema_viera_citas_metabox_render( $post ) {
	wp_nonce_field( 'tema_viera_citas_metabox', 'tema_viera_citas_metabox_nonce' );

	$campos = array(
		'whatsapp' => esc_html__( 'WhatsApp', 'tema-viera-abogados' ),
		'servicio' => esc_html__( 'Servicio', 'tema-viera-abogados' ),
		'fecha'    => esc_html__( 'Fecha (YYYY-MM-DD)', 'tema-viera-abogados' ),
		'hora'     => esc_html__( 'Hora (HH:MM)', 'tema-viera-abogados' ),
	);

	echo '<table class="form-table">';
	foreach ( $campos as $campo => $etiqueta ) {
		$valor = get_post_meta( $post->ID, '_cita_' . $campo, true );
		echo '<tr>';
		echo '<th><label for="_cita_' . esc_attr( $campo ) . '">' . esc_html( $etiqueta ) . '</label></th>';
		echo '<td><input type="text" class="regular-text" id="_cita_' . esc_attr( $campo ) . '" name="_cita_' . esc_attr( $campo ) . '" value="' . esc_attr( $valor ) . '" /></td>';
		echo '</tr>';
	}
	echo '</table>';
}

function tema_viera_citas_save_metabox( $post_id ) {
	if ( ! isset( $_POST['tema_viera_citas_metabox_nonce'] ) || ! wp_verify_nonce( $_POST['tema_viera_citas_metabox_nonce'], 'tema_viera_citas_metabox' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( array( 'whatsapp', 'servicio', 'fecha', 'hora' ) as $campo ) {
		if ( isset( $_POST[ '_cita_' . $campo ] ) ) {
			update_post_meta( $post_id, '_cita_' . $campo, sanitize_text_field( $_POST[ '_cita_' . $campo ] ) );
		}
	}
}
add_action( 'save_post_cita', 'tema_viera_citas_save_metabox' );

/**
 * Obtener los horarios disponibles configurados en el admin.
 *
 * @return array Lista de horarios en formato HH:MM ordenados.
 */
function tema_viera_get_horarios() {
	$opcion   = get_option( 'tema_viera_abogados_citas_horarios', "09:00\n10:30\n14:00\n16:30" );
	$horarios = array_filter( array_map( 'trim', explode( "\n", (string) $opcion ) ) );
	$horarios = array_map( 'sanitize_text_field', $horarios );
	$horarios = array_values( array_filter( $horarios ) );
	sort( $horarios );
	return $horarios;
}

/**
 * Obtener los horarios ya reservados para una fecha concreta.
 *
 * @param string $fecha Fecha en formato YYYY-MM-DD.
 * @return array Lista de horarios ocupados (HH:MM).
 */
function tema_viera_get_booked_slots( $fecha ) {
	$query = new WP_Query( array(
		'post_type'      => 'cita',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'meta_query'     => array(
			array(
				'key'   => '_cita_fecha',
				'value' => $fecha,
			),
		),
	) );

	$booked = array();
	foreach ( $query->posts as $id ) {
		$hora = get_post_meta( $id, '_cita_hora', true );
		if ( $hora ) {
			$booked[] = $hora;
		}
	}
	return $booked;
}

/**
 * Email de notificación del estudio.
 *
 * @return string
 */
function tema_viera_get_citas_email() {
	$email = get_option( 'tema_viera_abogados_citas_email', '' );
	if ( ! $email ) {
		$email = get_option( 'tema_viera_abogados_contacto_email', '' );
	}
	if ( ! $email ) {
		$email = get_option( 'admin_email' );
	}
	return $email;
}

/**
 * AJAX: devolver los horarios disponibles/ocupados para una fecha.
 */
function tema_viera_citas_slots_ajax() {
	check_ajax_referer( 'tema-viera-abogados-nonce', 'nonce' );

	$fecha = isset( $_POST['fecha'] ) ? sanitize_text_field( wp_unslash( $_POST['fecha'] ) ) : '';
	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $fecha ) ) {
		wp_send_json_error( array( 'mensaje' => esc_html__( 'Fecha inválida.', 'tema-viera-abogados' ) ) );
	}

	$horarios = tema_viera_get_horarios();
	$ocupados = tema_viera_get_booked_slots( $fecha );

	$slots = array();
	foreach ( $horarios as $hora ) {
		$slots[] = array(
			'hora'    => $hora,
			'ocupado' => in_array( $hora, $ocupados, true ),
		);
	}

	wp_send_json_success( array( 'slots' => $slots ) );
}
add_action( 'wp_ajax_tema_viera_citas_slots', 'tema_viera_citas_slots_ajax' );
add_action( 'wp_ajax_nopriv_tema_viera_citas_slots', 'tema_viera_citas_slots_ajax' );

/**
 * AJAX: crear la reserva.
 */
function tema_viera_citas_book_ajax() {
	check_ajax_referer( 'tema-viera-abogados-nonce', 'nonce' );

	$nombre   = isset( $_POST['nombre'] ) ? sanitize_text_field( wp_unslash( $_POST['nombre'] ) ) : '';
	$whatsapp = isset( $_POST['whatsapp'] ) ? sanitize_text_field( wp_unslash( $_POST['whatsapp'] ) ) : '';
	$servicio = isset( $_POST['servicio'] ) ? sanitize_text_field( wp_unslash( $_POST['servicio'] ) ) : '';
	$fecha    = isset( $_POST['fecha'] ) ? sanitize_text_field( wp_unslash( $_POST['fecha'] ) ) : '';
	$hora     = isset( $_POST['hora'] ) ? sanitize_text_field( wp_unslash( $_POST['hora'] ) ) : '';

	if ( ! $nombre || ! $fecha || ! $hora ) {
		wp_send_json_error( array( 'mensaje' => esc_html__( 'Completa los campos obligatorios.', 'tema-viera-abogados' ) ) );
	}

	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $fecha ) ) {
		wp_send_json_error( array( 'mensaje' => esc_html__( 'Fecha inválida.', 'tema-viera-abogados' ) ) );
	}

	$horarios = tema_viera_get_horarios();
	if ( ! in_array( $hora, $horarios, true ) ) {
		wp_send_json_error( array( 'mensaje' => esc_html__( 'Horario inválido.', 'tema-viera-abogados' ) ) );
	}

	// Bloquear fechas pasadas.
	if ( strtotime( $fecha . ' ' . $hora ) < current_time( 'timestamp' ) ) {
		wp_send_json_error( array( 'mensaje' => esc_html__( 'No puedes agendar una fecha pasada.', 'tema-viera-abogados' ) ) );
	}

	// Verificar que el horario no esté ya ocupado.
	if ( in_array( $hora, tema_viera_get_booked_slots( $fecha ), true ) ) {
		wp_send_json_error( array( 'mensaje' => esc_html__( 'Este horario ya no está disponible.', 'tema-viera-abogados' ) ) );
	}

	$post_id = wp_insert_post( array(
		'post_type'   => 'cita',
		'post_status' => 'publish',
		'post_title'  => $nombre,
	) );

	if ( is_wp_error( $post_id ) ) {
		wp_send_json_error( array( 'mensaje' => esc_html__( 'No se pudo guardar la cita.', 'tema-viera-abogados' ) ) );
	}

	update_post_meta( $post_id, '_cita_nombre', $nombre );
	update_post_meta( $post_id, '_cita_whatsapp', $whatsapp );
	update_post_meta( $post_id, '_cita_servicio', $servicio );
	update_post_meta( $post_id, '_cita_fecha', $fecha );
	update_post_meta( $post_id, '_cita_hora', $hora );

	// Notificar al estudio por email.
	tema_viera_citas_notify_email( $nombre, $whatsapp, $servicio, $fecha, $hora );

	$whatsapp_numero = preg_replace( '/[^0-9]/', '', (string) get_option( 'tema_viera_abogados_contacto_telefono', '' ) );

	wp_send_json_success( array(
		'mensaje'          => esc_html__( 'Tu cita fue agendada correctamente.', 'tema-viera-abogados' ),
		'whatsapp_numero'  => $whatsapp_numero,
	) );
}
add_action( 'wp_ajax_tema_viera_citas_book', 'tema_viera_citas_book_ajax' );
add_action( 'wp_ajax_nopriv_tema_viera_citas_book', 'tema_viera_citas_book_ajax' );

/**
 * Enviar email de notificación al estudio.
 */
function tema_viera_citas_notify_email( $nombre, $whatsapp, $servicio, $fecha, $hora ) {
	$to      = tema_viera_get_citas_email();
	$subject = sprintf( 'Nueva cita agendada: %s — %s', $fecha, $hora );
	$body    = sprintf(
		"Se agendó una nueva cita:\n\nNombre: %s\nWhatsApp: %s\nServicio: %s\nFecha: %s\nHora: %s",
		$nombre,
		$whatsapp ? $whatsapp : '—',
		$servicio ? $servicio : '—',
		mysql2date( 'd/m/Y', $fecha ),
		$hora
	);

	wp_mail( $to, $subject, $body );
}
