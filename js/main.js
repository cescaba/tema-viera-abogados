/**
 * Mi Tema Abogados - JavaScript Principal
 *
 * @package MiTemaAbogados
 * @since 1.0.0
 */

(function() {
	'use strict';

	/**
	 * Cuando el DOM está completamente cargado
	 */
	document.addEventListener('DOMContentLoaded', function() {
		initializeTheme();
	});

	/**
	 * Inicializar funcionalidades del tema
	 */
	function initializeTheme() {
		// Suavizar scroll a anclas
		setupSmoothScroll();

		// Funcionalidad del formulario de contacto
		setupContactForm();
	}

	/**
	 * Configurar scroll suave para enlaces de ancla
	 */
	function setupSmoothScroll() {
		var links = document.querySelectorAll('a[href^="#"]');
		links.forEach(function(link) {
			link.addEventListener('click', function(e) {
				var href = this.getAttribute('href');
				if (href === '#') return;

				var target = document.querySelector(href);
				if (target) {
					e.preventDefault();
					target.scrollIntoView({
						behavior: 'smooth',
						block: 'start'
					});
				}
			});
		});
	}

	/**
	 * Procesar el formulario de contacto
	 */
	function setupContactForm() {
		var form = document.getElementById('contact-form');
		if (!form) return;

		form.addEventListener('submit', function(e) {
			e.preventDefault();

			// Obtener datos del formulario
			var formData = new FormData(form);
			var data = {
				action: 'process_contact_form',
				nonce: temaVieraAbogados.nonce,
				name: formData.get('contact_name'),
				email: formData.get('contact_email_form'),
				phone: formData.get('contact_phone'),
				message: formData.get('contact_message'),
				contact_nonce: formData.get('contact_nonce')
			};

			// Enviar por AJAX (opcional)
			// Si no hay backend AJAX, el formulario se envía normalmente
			// Para una funcionalidad completa, agregar un endpoint AJAX en el backend

			console.log('Formulario de contacto:', data);
			// Aquí se podría hacer un fetch a admin-ajax.php si lo requiere
		});
	}

	/**
	 * Función auxiliar para hacer peticiones AJAX
	 */
	window.miTemaAjax = function(data, callback) {
		fetch(temaVieraAbogados.ajaxUrl, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			body: new URLSearchParams(data)
		})
			.then(response => response.json())
			.then(result => {
				if (callback && typeof callback === 'function') {
					callback(result);
				}
			})
			.catch(error => console.error('Error en AJAX:', error));
	};

})();
