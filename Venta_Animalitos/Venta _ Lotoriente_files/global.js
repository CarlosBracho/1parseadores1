$(document).ready( function() {

	var GLOBAL_ICONO_CARGANDO = 'fa fa-circle-o-notch fa-spin';
	var GLOBAL_AJAX_ERROR_INESPERADO = 'Ha ocurrido un error inesperado. Por favor, ';
		GLOBAL_AJAX_ERROR_INESPERADO += 'intente de nuevo o cumuníquese con el administrador.';

	function isEmpty($field) {
		if ($field.val() == null || $($field).val().length == 0 || /^\s+$/.test($($field).val()))
			return true;
		return false;
	}

	function isZero($input) {
		if ($input.val() == '0')
			return true;
		return false;
	}

	// Cuenta el numero de filas seleccionadas de una tabla.
	function countTableSelection() {
		return $('tr[data-select].success').length;
	}

	function globalBootstrapAlert($type, $message) {
		var $alert = '<div class="alert alert-'+$type+' alert-dismissible fade in" role="alert">'+
			'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
				'<span aria-hidden="true">&times;</span>'+
			'</button>'+
			'<span class="fa fa-'+$type+'"></span> ' + $message + '</div>'
		return $alert;
	}

	function globalAddBootstrapAlert($modal, $type, $message) {
		$modal.find('.modal-body').prepend(globalBootstrapAlert($type, $message));
	}

	function globalRemoveBootstrapAlert() {
		$('.modal').find('.modal-body .alert').remove();
	}

	function globalDisabledAndAddIconLoading($button) {
		$button.attr('disabled', 'disabled');
		$button.children('span').attr('class', GLOBAL_ICONO_CARGANDO);
	}

	function globalEnabledAndRemoveIconLoading($button, icon_name) {
		$button.attr('disabled', false);
		$button.children('span').attr('class', 'fa fa-'+icon_name);
	}

	// Bootstrap modals.
	$(function() {
		var $modal = $('.modal');

		$modal.modal({
			show: false,
			backdrop: 'static'
		});

		$modal.on('hidden.bs.modal', function(event) {
			$(this).find('input').val('');
			$(this).find('.modal-body .alert').remove();
			$('body').attr('style', 'padding-right: 0 !important');
		});
	});

	$(function() {
		$('form[name=search-form]').on('submit', function(event) {
			var $slug = $(this).find('input[name=q]');
			if (isEmpty($slug) == false)
				$(this).submit();
			event.preventDefault();
		});
	});

	// Mostrar campo de búsqueda en modo responsive.
	$(function() {
		$('.btn-group[data-action=search]').on('click', function(event) {
			event.preventDefault();
			$(this).hide();
			$('.navbar-form[role=search]').attr('active', 'true');
			$('form[name=search-form] input[name=q]').focus();
		});
	});

	$(function() {
		$('form[name=search-form] input[name=q]').focusout(function() {
			if (isEmpty($(this)) == true) {
				$('.navbar-form[role=search]').attr('active', 'false');
				$('.btn-group[data-action=search]').show()
			}
		});
	});

	// Seleccinar todos los check en una tabla.
	$(function() {
		$(document).on('change', 'table input[data-toggle="select-all"]', function() {
			if ($(this).prop('checked') == true) {
				$(this).parent().parent().parent().parent().find('input[type="checkbox"]:enabled').parent().parent('tr[data-select]').attr('class', 'success');
				$(this).parent().parent().parent().parent().find('input[type="checkbox"]:enabled').prop('checked', true);
				$('.btn-group[data-hidden]').attr('data-hidden', '');
			}
			else {
				$(this).parent().parent().parent().parent().find('tr[data-select]').removeAttr('class');
				$(this).parent().parent().parent().parent().find('input[type="checkbox"]').prop('checked', false);
				$('.btn-group[data-hidden]').attr('data-hidden', 'hidden');
			}
		});
	});

	// Seleccinar todos los check agrupados en una tabla.
	$(function() {
		$('tr.select-by-group input[type="checkbox"]').change(function() {
			if ($(this).prop('checked') == true) {
				$('tr[data-select='+$(this).parent().parent().data('group')+']').find(
					'input[type="checkbox"]').prop('checked', true);
				$('tr[data-select='+$(this).parent().parent().data('group')+']').attr('class', 'success');
				$('.btn-group[data-hidden]').attr('data-hidden', '');
			}
			else {
				$('tr[data-select='+$(this).parent().parent().data('group')+']').find(
					'input[type="checkbox"]').prop('checked', false);
				$('tr[data-select='+$(this).parent().parent().data('group')+']').removeAttr('class');
				if (countTableSelection() == 0)
					$('.btn-group[data-hidden]').attr('data-hidden', 'hidden');
			}
		});
	});

	// Seleccionar todos los check agrupados por una fila level0.
	$('tr.select-by-group.level0 input[type="checkbox"]').change(function() {
		if ($(this).prop('checked') == true) {
			$('tr[data-select-group-group='+$(this).parent().parent().data('group')+']').find(
				'input[type="checkbox"]').prop('checked', true);
			$('tr[data-select-group-group='+$(this).parent().parent().data('group')+'][data-select]').attr('class', 'success');
		}
		else {
			$('tr[data-select-group-group='+$(this).parent().parent().data('group')+']').find(
				'input[type="checkbox"]').prop('checked', false);
			$('tr[data-select-group-group='+$(this).parent().parent().data('group')+'][data-select]').removeAttr('class');
		}
	});

	// Seleccionar todos los check agrupados por una fila level1.
	$('tr.select-by-group.level1 input[type="checkbox"]').change(function() {
		if ($(this).prop('checked') == true) {
			$('tr[data-select-group='+$(this).parent().parent().data('group')+']').find(
				'input[type="checkbox"]').prop('checked', true);
			$('tr[data-select-group='+$(this).parent().parent().data('group')+'][data-select]').attr('class', 'success');
		}
		else {
			$('tr[data-select-group='+$(this).parent().parent().data('group')+']').find(
				'input[type="checkbox"]').prop('checked', false);
			$('tr[data-select-group='+$(this).parent().parent().data('group')+'][data-select]').removeAttr('class');
		}
	});

	$(function() {
		$(document).on('change', 'tr[data-select] input[type="checkbox"]', function() {
			if ($(this).prop('checked') == true) {
				$(this).parent().parent().attr('class', 'success');
				$('.btn-group[data-hidden]').attr('data-hidden', '');
			}
			else {
				$(this).parent().parent().removeAttr('class');
				if (countTableSelection() == 0)
					$('.btn-group[data-hidden]').attr('data-hidden', 'hidden');
			}
		});
	});

	// Consulta los detalles de un ticket.
	$(function() {
		$(document).on('click', '[data-target="#modal_ticket_detalles"]', function(event) {
			event.preventDefault();
			$('#modal_ticket_detalles #hidden_url').val($(this).data('url'));
			$('#modal_ticket_detalles #hidden_ticket_id').val($(this).data('ticket-id'));
			$('#modal_ticket_detalles #hidden_ticket_fecha').val($(this).data('ticket-fecha'));
		});
		$('#modal_ticket_detalles').on('shown.bs.modal', function(event) {
			var url = $('#modal_ticket_detalles #hidden_url').val();
			var ticket_id = $('#modal_ticket_detalles #hidden_ticket_id').val();
			var ticket_fecha = $('#modal_ticket_detalles #hidden_ticket_fecha').val();
			$.post(url, { 'ticket_id': ticket_id, 'ticket_fecha': ticket_fecha }, function(data) {
				$('#modal_ticket_detalles').find('.modal-body').html('').append(data);
			}, 'json');
		});
		$('#modal_ticket_detalles').on('hidden.bs.modal', function(event) {
			$('#modal_ticket_detalles').find('.modal-body').html('').append(
				'<div class="cargando"><span class="fa fa-circle-o-notch fa-spin fa-fw"></span></div>');
		});
	});

	// Muestra el total por columnas en las tablas.
	$(function() {
        var totals = [];

        $('table.sum-table th').each(function(i) {
        	totals[i] = 0;
        });
        
        $('table.sum-table tbody tr').each(function() {
        	$(this).find('td').each(function(i) {
        		if ($(this).attr('class') == 'sum')
        			totals[i] += parseFloat($(this).text().replace(/\.|,00/g, '').replace(/,/, '.'));
        	});
        });

        $('table.sum-table tfoot tr').each(function() {
        	var number_format = new Intl.NumberFormat('es-ES');
        	$(this).find('td').each(function(i) {
	        	if ($(this).attr('class') == 'sum')
	        		$(this).find('.total').text(number_format.format(totals[i]));
        	})
        });
	});

	// Consulta las notificaciones.
	$(function() {
		$('button.notification').on('click', function() {
			if ($(this).attr('aria-expanded') == 'false') {
				$.get('/notificaciones/pendientes')
					.done(function(data) {
						$('.dropdown-menu[role="notification"] .cargando').remove();
						$('.dropdown-menu[role="notification"] li:not(.dropdown-header)').remove();
						$('.dropdown-menu[role="notification"] .dropdown-header').after(data);
						$('button.notification').find('label').remove();
					})
					.fail(function() {
						console.log('Error cargando notificaciones.')
					});
			}
		});
	});

	// Buscador global de tickets.
	$(function() {
		$('#modal_busqueda_global_ticket').on('show.bs.modal', function(event) {
			$(this).find('.modal-body input[type=text]').val('');
			$(this).find('.modal-body section.ticket_data').html('');
			$(this).find('button[data-action=anular], button[data-action=pagar], ' +
				'button[data-action=detalles]').attr('disabled', true);
		});
		$('#modal_busqueda_global_ticket form[name=form_busqueda_global_ticket]').on('submit', function(event) {
			event.preventDefault();
			if (isEmpty($('form[name=form_busqueda_global_ticket]').find('#buscar_ticket_id_ticket')) == false &&
				isZero($('form[name=form_busqueda_global_ticket]').find('#buscar_ticket_id_ticket')) == false)
			{
				globalPostAjaxBuscarTicket($('form[name=form_busqueda_global_ticket]'));
			}
		});
		$('#modal_busqueda_global_ticket #buscar_ticket_id_ticket').on('keyup', function(event) {
			event.preventDefault();
			if (isEmpty($('form[name=form_busqueda_global_ticket]').find('#buscar_ticket_id_ticket')) == false &&
				isZero($('form[name=form_busqueda_global_ticket]').find('#buscar_ticket_id_ticket')) == false)
			{
				globalPostAjaxBuscarTicket($('form[name=form_busqueda_global_ticket]'));
			}
		});
	});

	function globalPostAjaxBuscarTicket($form) {
		var $modal = $('#modal_busqueda_global_ticket');
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			beforeSend: function() {
				globalRemoveBootstrapAlert();
				globalDisabledAndAddIconLoading($form.find('button[type=submit]'));
				$modal.find('.ticket_data').addClass('cargando-full-screen');
				$modal.find('button').not('.close').attr('disabled', true);
			},
			success: function(response) {
				if (response.type == 'success') {
					$('#modal_ticket_detalles_new_format').find('section.ticket_area').html(response.data);
					$modal.find('section.ticket_data').html(response.ticket_and_vendedor);

					if (response.ticket_id != null) {
						$modal.find('button[data-action=pagar]').data('id', response.ticket_id);
						$modal.find('button[data-action=anular]').data('id', response.ticket_id);
						$modal.find('button[data-action=detalles]').data('id', response.ticket_id);
						$modal.find('button[data-action=detalles]').removeAttr('disabled');						

						if (response.ticket_estatus == 'no premiado')
							$modal.find('button[data-action=anular]').removeAttr('disabled');
						else if (response.ticket_estatus == 'premiado')
							$modal.find('button[data-action=pagar]').removeAttr('disabled');
					}
				}

				$modal.find('.ticket_data').removeClass('cargando-full-screen');
				globalEnabledAndRemoveIconLoading($form.find('button[type=submit]'), 'search');
			},
			error: function() {
				$modal.find('.ticket_data').removeClass('cargando-full-screen');
				globalAddBootstrapAlert($modal, 'danger', GLOBAL_AJAX_ERROR_INESPERADO);
				globalEnabledAndRemoveIconLoading($form.find('button[type=submit]'), 'search');
			}
		});
	}

	function globalPostAjax($form, $modal, action_name) {
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			beforeSend: function() {
				globalDisabledAndAddIconLoading($form.find('button'));
				$modal.find('.alert').remove();
			},
			success: function(response) {
				$('#modal_confirmar_global').modal('hide');
				globalEnabledAndRemoveIconLoading($form.find('button'));				
				if (action_name == 'anular') {
					if (response.type == 'success')
						globalPostAjaxBuscarTicket($('form[name=form_busqueda_global_ticket]'));
					$modal.find('.modal-body').prepend(globalBootstrapAlert(response.type, response.message));
				}
				else if (action_name == 'pagar') {
					if (response.type == 'success') {
						globalPostAjaxBuscarTicket($('form[name=form_busqueda_global_ticket]'));
						$('#modal_busqueda_global_ticket').find('.modal-body').prepend(
							globalBootstrapAlert(response.type, response.message));
						$modal.modal('hide');
					}
					else
						$modal.find('.modal-body').prepend(globalBootstrapAlert(response.type, response.message));
				}
			},
			error: function() {
				$modal.find('.modal-body').prepend(globalBootstrapAlert('danger', GLOBAL_AJAX_ERROR_INESPERADO));
				globalEnabledAndRemoveIconLoading($form.find('button'));
			}
		});
	}

	$(function() {
		$(document).on('click', '[data-target="#modal_confirmar_global"]', function(event) {
			event.preventDefault();
			$('#modal_confirmar_global #hidden_id').val($(this).data('id'));
			$('#modal_confirmar_global #hidden_action').val($(this).data('action'));
			$('#modal_confirmar_global #hidden_confirmar_url').val($(this).data('url'));
			$('#modal_confirmar_global .modal-title').html($(this).data('title'));
		});
		$('#modal_confirmar_global').on('shown.bs.modal', function(event) {
			var url = $('#modal_confirmar_global #hidden_confirmar_url').val();
			var action_name = $('#modal_confirmar_global #hidden_action').val();
			$('#modal_busqueda_global_ticket .alert').remove();
			$(this).find('.modal-body').load(url, function() {
				$('#modal_confirmar_global form[name=confirmar]').attr('action', url);
				if ($('[data-target="#modal_confirmar_global"]').data('ajax') == true) {
					$('form[name=confirmar] #confirmar_confirmar_hidden').val($('#modal_confirmar_global #hidden_id').val());
					$('form[name=confirmar]').on('submit', function(event) {
						event.preventDefault();
						globalPostAjax($('form[name=confirmar]'), $('#modal_busqueda_global_ticket'), action_name);
					});
				}
			});
		});
	});

	$(function() {
		$('#modal_pagar_ticket_global form[name=form_pagar_ticket_global]').on('submit', function(event) {
			event.preventDefault();
			var action_name = 'pagar';
			var $pagar_button = $('[data-target="#modal_pagar_ticket_global"]');
			$(this).attr('action', $pagar_button.data('url'));
			$(this).find('#pagar_ticket_id_ticket').val($pagar_button.data('id'));
			if (isEmpty($(this).find('#pagar_ticket_serial')) == false &&
				isZero($(this).find('#pagar_ticket_serial')) == false)
			{
				globalPostAjax($(this), $('#modal_pagar_ticket_global'), action_name);
			}
		});
	});

})