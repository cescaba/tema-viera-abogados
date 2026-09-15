/**
 * Bloque Gutenberg: Cita con autor (viera/cita-abogado).
 *
 * @package TemaVieraAbogados
 */
(function (wp) {
	'use strict';

	var registerBlockType = wp.blocks.registerBlockType;
	var el = wp.element.createElement;
	var TextareaControl = wp.components.TextareaControl;
	var SelectControl = wp.components.SelectControl;
	var withSelect = wp.data.withSelect;
	var __ = wp.i18n.__;

	function CitaEdit(props) {
		var attributes = props.attributes;
		var setAttributes = props.setAttributes;
		var abogados = props.abogados || [];

		var options = [{ value: 0, label: __('— Sin autor —', 'tema-viera-abogados') }];
		abogados.forEach(function (ab) {
			var label = (ab.title && ab.title.rendered) ? ab.title.rendered : String(ab.id);
			options.push({ value: ab.id, label: label });
		});

		return el('div', { className: 'wp-block-viera-cita-abogado' },
			el(TextareaControl, {
				label: __('Cita', 'tema-viera-abogados'),
				value: attributes.cita,
				onChange: function (v) { setAttributes({ cita: v }); }
			}),
			el(SelectControl, {
				label: __('Autor (abogado)', 'tema-viera-abogados'),
				value: attributes.autorId,
				options: options,
				onChange: function (v) { setAttributes({ autorId: Number(v) }); }
			}),
			el('blockquote', { className: 'wp-block-viera-cita-abogado__preview' },
				el('p', null, attributes.cita || __('Escribe tu cita aquí…', 'tema-viera-abogados')),
				attributes.autorId ? el('cite', null, '— ' + __('Abogado', 'tema-viera-abogados') + ' #' + attributes.autorId) : null
			)
		);
	}

	var CitaEditWithData = withSelect(function (select) {
		return {
			abogados: select('core').getEntityRecords('postType', 'abogado', {
				per_page: -1,
				orderby: 'menu_order',
				order: 'asc'
			})
		};
	})(CitaEdit);

	registerBlockType('viera/cita-abogado', {
		title: __('Cita con autor', 'tema-viera-abogados'),
		description: __('Cita destacada con autor (abogado) seleccionable.', 'tema-viera-abogados'),
		icon: 'format-quote',
		category: 'text',
		attributes: {
			cita: { type: 'string' },
			autorId: { type: 'number', default: 0 }
		},
		edit: CitaEditWithData,
		save: function () { return null; }
	});
})(window.wp);
