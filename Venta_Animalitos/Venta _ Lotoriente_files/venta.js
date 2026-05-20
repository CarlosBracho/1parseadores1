$(document).ready( function() {

	var AJAX_ERROR_INESPERADO = 'Ha ocurrido un error inesperado. Por favor, ';
		AJAX_ERROR_INESPERADO += 'intente de nuevo o cumuníquese con el administrador.';
	var ICONO_CARGANDO = 'fa fa-circle-o-notch fa-spin';
	var server_date_time =  new Date($('#server_date').html() + ' ' + $('#reloj').html());

	$('input#monto')
        .focus(function() { $(this).select() })
        .mouseup(function(e) { e.preventDefault() });

	function clock() {
	  	var horas = server_date_time.getHours();
	  	var minutos = server_date_time.getMinutes();
	  	var segundos = server_date_time.getSeconds(); 
  		if(horas < 10)
  			horas = '0' + horas;
  		if(minutos < 10)
  			minutos = '0' + minutos;
  		if(segundos < 10)
  			segundos = '0' + segundos;
  		$('#reloj').html(horas+':'+minutos+':'+segundos);
  		server_date_time.setSeconds(server_date_time.getSeconds()+1);
	} setInterval(clock, 1000);

	function isEmpty($input) {
		if ($input.val() == null || $($input).val().length == 0 || /^\s+$/.test($($input).val()))
			return true;
		return false;
	}

	function isZero($input) {
		if ($input.val() == '0')
			return true;
		return false;
	}

	function isMontoValido(monto) {
		if (Number.isInteger(parseInt(monto)) && monto > 0)
			return true;
		return false;
	}

	function setFocusIn($element) {
		$element.focus();
	}
	setFocusIn($('#form-numero-animalito #numero_animalito'));

	function afterCheckedAnimalitoSorteo($input_checkbox) {
		$input_checkbox.next().attr('class', 'label label-info2 multiline capitalize');
	}

	function afterUncheckedAnimalitoSorteo($input_checkbox) {
		$input_checkbox.next().attr('class', 'label label-info2-filter multiline capitalize');
	}

	function cancelarJugada(ticket) {
		ticket.reset();
		restablecerCampos();
		$('.listado-sorteos input[type="checkbox"]').prop('checked', false);
		$('.listado-sorteos  span.label').attr('class', 'label label-info2-filter multiline capitalize');
		$('.sorteo_seleccionado input[type="checkbox"]').prop('checked', false);
		$('.sorteo_seleccionado  span.label').attr('class', 'label label-info2-filter multiline capitalize');
		
	}

	function restablecerCampos() {
		$('input[data-toggle ^= select-all-]').prop('checked', false);
		$('.listado-animalitos input[type="checkbox"]').prop('checked', false);
		$('.listado-animalitos  span.label').attr('class', 'label label-info2-filter multiline capitalize');
		$('.sorteo_seleccionado input[type="checkbox"]').prop('checked', false);
		$('.sorteo_seleccionado  span.label').attr('class', 'label label-info2-filter multiline capitalize');
		$('.listado-sorteos input[type="checkbox"]').prop('checked', false);
		$('.listado-sorteos  span.label').attr('class', 'label label-info2-filter multiline capitalize');
		setFocusIn($('.jugada-rapida input#numero_animalito'));
	}

	function disabledAndAddIconLoading($button) {
		$button.attr('disabled', 'disabled');
		$button.children('span').attr('class', ICONO_CARGANDO);
	}

	function enabledAndRemoveIconLoading($button, icon_name) {
		$button.attr('disabled', false);
		$button.children('span').attr('class', 'fa fa-'+icon_name);
	}

	function addIconLoadingIn($element) {
		$element.html('<div class="cargando"><span class="'+ICONO_CARGANDO+' fa-fw'+'"></span></div>');
	}

	function showMessage($type, $message, $permanent=false) {
		$.ntf({text: '<span class="fa fa-'+$type+'"></span> '+$message, type: $type,
			permanent: $permanent, duration: 4});
	}

	function clearSelect($select) {
		$select.empty().append('<option value="">Seleccionar</option>');
	}

	function bootstrapAlert($type, $message) {
		var $alert = '<div class="alert alert-'+$type+' alert-dismissible fade in" role="alert">'+
			'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
				'<span aria-hidden="true">&times;</span>'+
			'</button>'+
			'<span class="fa fa-'+$type+'"></span> ' + $message + '</div>'
		return $alert;
	}

	function addBootstrapAlert($modal, $type, $message) {
		$modal.find('.modal-body').prepend(bootstrapAlert($type, $message));
	}

	function removeBootstrapAlert() {
		$('.modal').find('.modal-body .alert').remove();
	}

	function disabledAndClearSelect($select, placeholder) {
		$select.empty().append('<option value="">'+placeholder+'</option>');
		$select.attr('disabled', 'disabled');
	}

	function enabledSelect($select) {
		$select.removeAttr('disabled');
	}

	function formatDateServerTime() {
		var date = server_date_time.getDate();
		var moth = server_date_time.getMonth() + 1;
		var year = server_date_time.getFullYear();
		return (date + '-' + moth + '-' + year);
	}

	function updateLabelSaldo(nuevo_saldo)
	{
		var number_format = new Intl.NumberFormat('es-ES');
		$('.label-saldo span').html(number_format.format(nuevo_saldo));
	}

	function ajaxSaveTicket($form, $ticket) {
		$.ajax({
			dataType: 'JSON',
			type: $form.attr('method'),
			url: $form.attr('action'),
			data: {
				jugadas: $ticket.jugadas,
				monto_total: $ticket.monto_total,
				id_agencia: $('#hidden_id_agencia').val(),
				moneda_data: $ticket.obtenerMonedaData(),
			},
			beforeSend: function() {
				disabledAndAddIconLoading($form.find('button'));
				$('form[name="save_and_imprimir_ticket"] button').attr('disabled', 'disabled');
			},
			success: function(response) {
				enabledAndRemoveIconLoading($form.find('button'), 'save');
				$('form[name="save_and_imprimir_ticket"] button').removeAttr('disabled');
				if (response.type != 'success') {
					if (response.messages) {
						var message = '', cantidad_messages = response.messages.length;
						response.messages.forEach(function(data) {
							message += data.message;
							if (data.id_sorteo)
								$('.listado-sorteos input[data-id='+data.id_sorteo+']').parent().parent().parent().parent().remove();
						});
						showMessage(response.type, message, true);
						$('.alert_elminar').on('click', function() {
							$ticket.deleteJugada($(this));
							$(this).parent().remove();
							cantidad_messages -= 1;
							if (cantidad_messages == 0)
								showMessage('success', 'La jugada ha sido eliminada de forma exitosa.');
						});
						$('.alert_jugar').on('click', function() {
							$ticket.changeMontoJugada($(this).data('jugada'), $(this).data('cupo'));
							$(this).parent().remove();
							cantidad_messages -= 1;
							if (cantidad_messages == 0)
								showMessage('success', 'La jugada ha sido modificada de forma exitosa.');
						});
					}
					else
						showMessage(response.type, response.message, true);
				}
				else {
					loadTicket(response.id_ticket, 'imprime');
					$('#modal_ticket').modal('show');
					$ticket.reset();
					restablecerCampos();
					updateLabelSaldo(response.saldo_actualizado);
				}
			},
			error: function() {
				showMessage('danger', AJAX_ERROR_INESPERADO, true);
				enabledAndRemoveIconLoading($form.find('button'), 'save');
				$('form[name="save_and_imprimir_ticket"] button').removeAttr('disabled');
			}
		});
	}
	$("#seleccion-moneda777").change(function() {


		//alert($("option:selected", this).attr("data-moneda2"));
	  var $monedadatex = $("option:selected", this).attr("data-moneda2");
	  //alert($monedadatex);
	  return $monedadatex;
	  }).change()

	////aqui comienza impresiopn
	function ajaxSaveAndPrintTicket($form, $ticket) {
				//esta es la funcion que se ejecuta cuando se manda a im primir el ticket
				var eee = document.getElementById("ddlViewBy");
var value2 = eee.value;
				//alert(value2);
		//777 $ticket.monto_total
		//alert($form); return $('#form-monto button[data-toggle="dropdown"]').attr('data-moneda');


		$.ajax({
			dataType: 'JSON',
			type: $form.attr('method'),
			url: $form.attr('action'),
			data: {
				jugadas: $ticket.jugadas,
				monto_total: $ticket.monto_total,
				id_agencia: $('#hidden_id_agencia').val(),
				moneda_data: value2,
			},
			beforeSend: function() {
				disabledAndAddIconLoading($form.find('button'));
				$('form[name="imprimir_ticket"] button').attr('disabled', 'disabled');
			},
			success: function(response) {
				enabledAndRemoveIconLoading($form.find('button'), 'print');
				$('form[name="imprimir_ticket"] button').removeAttr('disabled');



				if (response.type != 'success') {
					Swal.fire({
						position: 'top-end',
						icon: 'error',
						title: response.message,
						showConfirmButton: false,
						timer: 7000
					  })
					//alert('555555555555');
					if (response.messages) {
						var message = '', cantidad_messages = response.messages.length;
						response.messages.forEach(function(data) {
							message += data.message;
							if (data.id_sorteo)
								$('.listado-sorteos input[data-id='+data.id_sorteo+']').parent().parent().parent().parent().remove();
						});
						showMessage(response.type, message, true);
						$('.alert_elminar').on('click', function() {
							$ticket.deleteJugada($(this));
							$(this).parent().remove();
							cantidad_messages -= 1;
							if (cantidad_messages == 0)
								showMessage('success', 'La jugada ha sido eliminada de forma exitosa.');
						});
						$('.alert_jugar').on('click', function() {
							$ticket.changeMontoJugada($(this).data('jugada'), $(this).data('cupo'));
							$(this).parent().remove();
							cantidad_messages -= 1;
							if (cantidad_messages == 0)
								showMessage('success', 'La jugada ha sido modificada de forma exitosa.');
						});
					}
					else
						showMessage(response.type, response.message, true);
				}


				
				else {
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: response.message,
						showConfirmButton: false,
						timer: 7000
					  })
					loadAndPrintTicket(response.id_ticket, 'imprime');
					$ticket.reset();
					restablecerCampos();
					updateLabelSaldo(response.saldo_actualizado);
				}
			},
			error: function() {
				showMessage('danger', AJAX_ERROR_INESPERADO, true);
				enabledAndRemoveIconLoading($form.find('button'), 'print');
				$('form[name="imprimir_ticket"] button').removeAttr('disabled');
			}
		});
	}
//aqui termina impresion






















	function loadTicket(id_ticket, print_or_reprint) {
		alert('1111');
		var $modal = $('#modal_ticket');
		//var url = print_or_reprint+'Ticket/'+id_ticket;
		var url = print_or_reprint+'Ticket/'+id_ticket;
		$modal.one('shown.bs.modal', function(event) {
			$.post(url, function(data) {
				$('#print-ticket-area').html('').append(data);
				$modal.find('.modal-body').html('').append(data);
				$modal.find('[data-action=email]').data('id', id_ticket);
				$modal.find('[data-action=sms]').data('id', id_ticket);
				$modal.find('[data-action=anular]').data('id', id_ticket);
			})
			.done(function() {
				$modal.find('[data-action=print]').removeAttr('disabled');
				$modal.find('[data-action=email]').removeAttr('disabled');
				$modal.find('[data-action=sms]').removeAttr('disabled');
				$modal.find('[data-action=anular]').removeAttr('disabled');
				$modal.find('[data-action=copy]').removeAttr('disabled');
			});
		});
	}

	function loadAndPrintTicket(id_ticket, print_or_reprint) {

	var url = print_or_reprint+'Ticket/imp.php?num='+id_ticket; //respaldo
		//var url = impresion.php;
		$.post(url, function(data) {
			$('#print-ticket-area').html('').append(data);
		})
		.done(function() {
			printAction();
		});
	}

		function loadAndPrintTicket2(id_ticket) {

	var url = '/imprimeTicket/Ticket/imp.php?reimpresion=1&num='+id_ticket; //respaldo
		//var url = impresion.php;
		$.post(url, function(data) {
			$('#print-ticket-area').html('').append(data);
		})
		.done(function() {
			printAction();
		});
	}

	function printAction() {
		var winprint = window.open('','Impresión');
	    winprint.document.open();	      	
	    winprint.document.write($('#print-ticket-area').html());
	    winprint.document.close();
	    winprint.focus();
	    winprint.print();
		winprint.close();
		setFocusIn($('.jugada-rapida input#numero_animalito'));
	}

	function postAjaxDependentSelects($form, $select_parent, $disabled, $placeholder) {
		var $array_select_child = $select_parent.data('select-dependent-child').split(',').map(JSON.parse);
		var $form_name = $form.attr('name');
		$.ajax({
			dataType: 'JSON',
			type: 'post',
			url: $form.attr('action'),
			data: {
				'ajax_action': 'select_dependent_action',
				id_select_parent: $select_parent.attr('id'),
				value_select_parent: $select_parent.val()
			},
			beforeSend: function() {
				for (var i=0; i<$array_select_child.length; i++) {
					$('label[for='+$form_name+'_'+$array_select_child[i]+']').append(
						'<span class="'+ICONO_CARGANDO+'"></span>');
				}
			},
			success: function(response) {
				if (response.type == 'success') {
					for (var i=0; i<$array_select_child.length; i++) {
						var $select_child = $('#'+$form_name+'_'+$array_select_child[i]);
						var data = response.data[$select_child.attr('id')];
						$select_child.empty();
						if ($placeholder.length > 0)
							$select_child.append('<option value="">'+$placeholder+'</option>');
						for (value in data) {
							var id = data[value];
							$select_child.append('<option value="'+id+'">'+value+'</option');
						}
						$('label[for='+$form_name+'_'+$array_select_child[i]+']').children('span').remove();
						if ($disabled == true)
							$select_child.removeAttr('disabled');
					}
				}
			},
			error: function() {
				showMessage('danger', AJAX_ERROR_INESPERADO);
			}
		});
	}

	function updateListadoAnimalitosAndSorteos(url, loteria) {
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: url,
			beforeSend: function() {
				$('.dashboard-data').addClass('cargando-full-screen');
			},
			success: function(response) {
				$('.seleccion-animalito').html('').append(response.animalitos);
				$('.seleccion-sorteo').html('').append(response.sorteos);
				$('#hidden_id_loteria').val(loteria.id);
				$('#hidden_nombre_loteria').val(loteria.nombre);
				$('.dashboard-data').removeClass('cargando-full-screen');
			},
			error: function() {
				showMessage('danger', AJAX_ERROR_INESPERADO);
			}
		});
	}

	function postAjaxBuscarResultados($form) {
		var $modal = $('#modal_resultados');
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			beforeSend: function() {
				removeBootstrapAlert();
				disabledAndAddIconLoading($form.find('button[type=submit]'));
			},
			success: function(response) {
				if (response.type == 'success')
					$modal.find('.modal-body section.resultados').html(response.data);
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), 'search');
			},
			error: function() {
				addBootstrapAlert($modal, 'danger', AJAX_ERROR_INESPERADO);
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), 'search');
			}
		});
	}

	function postAjaxBuscarTicket($form) {
		var $modal = $('#modal_buscar_ticket');
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			beforeSend: function() {
				removeBootstrapAlert();
				disabledAndAddIconLoading($form.find('button[type=submit]'));
			},
			success: function(response) {
				if (response.type == 'success')
					$modal.find('.modal-body section.ticket_area').html(response.data);
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), 'search');
			},
			error: function() {
				addBootstrapAlert($modal, 'danger', AJAX_ERROR_INESPERADO);
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), 'search');
			}
		});
	}

	function postAjaxBuscarAnularTicket($form) {
		var $modal = $('#modal_anular_ticket');
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			beforeSend: function() {
				removeBootstrapAlert();
				disabledAndAddIconLoading($form.find('button[type=submit]'));
			},
			success: function(response) {
				if (response.type == 'success') {
					$modal.find('.modal-body section.ticket_area').html(response.data);
					if (response.ticket_estatus == 'no premiado') {
						$modal.find('.modal-footer button[data-action=anular]').removeAttr('disabled');
						$modal.find('.modal-footer button[data-action=anular]').data('id', (response.ticket_id));
					}
					else
						$modal.find('.modal-footer button[data-action=anular]').attr('disabled', 'disabled');
				}
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), 'search');
			},
			error: function() {
				addBootstrapAlert($modal, 'danger', AJAX_ERROR_INESPERADO);
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), 'search');
			}
		});
	}

	function postAjaxSendEmailTicket($form, $modal) {
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			beforeSend: function() {
				removeBootstrapAlert();
				$form.find('button').attr('disabled', 'disabled');
				$form.find('button[type=submit]').prepend('<span class="'+ICONO_CARGANDO+' fa-fw'+'"></span>');
			},
			success: function(response) {
				if (response.type == 'success') {
					$('.modal').modal('hide');
					showMessage(response.type, response.message);
				}
				else
					addBootstrapAlert($modal, response.type, response.message);
				$form.find('button').removeAttr('disabled');
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), '');
			},
			error: function(response) {
				if (response.responseText)
					$form.parent().html('').append(response.responseText);
				else {
					addBootstrapAlert($modal, 'danger', AJAX_ERROR_INESPERADO);
					enabledAndRemoveIconLoading($form.find('button[type=submit]'), 'search');
				}
			}
		});
	}

	function postAjaxSendSMSTicket($form, $modal) {
		var url = $form.attr('action');
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			beforeSend: function() {
				removeBootstrapAlert();
				$form.find('button').attr('disabled', 'disabled');
				$form.find('button[type=submit]').prepend('<span class="'+ICONO_CARGANDO+' fa-fw'+'"></span>');
			},
			success: function(response) {
				if (response.type == 'success') {
					$('.modal').modal('hide');
					showMessage(response.type, response.message);
				}
				else
					addBootstrapAlert($modal, response.type, response.message);
				$form.find('button').removeAttr('disabled');
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), '');
			},
			error: function(response) {
				if (response.responseText) {
					$form.parent().html('').append(response.responseText);
					$('#modal_send_sms form[name=send_ticket_sms]').attr('action', url);
				}
				else {
					addBootstrapAlert($modal, 'danger', AJAX_ERROR_INESPERADO);
					enabledAndRemoveIconLoading($form.find('button[type=submit]'), 'search');
				}
			}
		});
	}

	function postAjaxAnularTicket($form, $modal) {
		$modal_parent = $('#modal_anular_ticket');
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			beforeSend: function() {
				removeBootstrapAlert();
				$form.find('button').attr('disabled', 'disabled');
				$form.find('button[type=submit]').prepend('<span class="'+ICONO_CARGANDO+' fa-fw'+'"></span>');
			},
			success: function(response) {
				if (response.type != 'danger') {
					if (response.type == 'success') {
						if ($('#modal_listado_ventas_recientes').css('display') == 'block') {
							$modal_parent.modal('hide');
							$('#table_ventas_recientes').DataTable().draw();
							addBootstrapAlert($('#modal_listado_ventas_recientes'), response.type, response.message);
						}
						else if ($('#modal_ticket').css('display') == 'block') {
							$('.modal').modal('hide');
							showMessage(response.type, response.message);
						}
						else {
							$('#modal_anular_ticket form[name=buscar_ticket]').submit();
							addBootstrapAlert($modal_parent, response.type, response.message);
						}
					}
					else
						addBootstrapAlert($modal_parent, response.type, response.message);
					$modal.modal('hide');
				}
				else {
					addBootstrapAlert($modal, response.type, response.message);
				}
				$form.find('button').removeAttr('disabled');
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), '');
			},
			error: function() {
				$form.find('button').removeAttr('disabled');
				addBootstrapAlert($modal, 'danger', AJAX_ERROR_INESPERADO);
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), '');
			}
		});
	}

	function postAjaxPagarTicket($form) {
		var $modal = $('#modal_pagar_ticket');
		var $modal_parent = $('#modal_listado_pagos');
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			beforeSend: function() {
				removeBootstrapAlert();
				$form.find('button').attr('disabled', 'disabled');
				disabledAndAddIconLoading($form.find('button[type=submit]'));
			},
			success: function(response) {
				if (response.type == 'success') {
					var table = $('#modal_listado_pagos #table_pagos').DataTable();
					$modal.modal('hide');
					table.draw();
					addBootstrapAlert($modal_parent, response.type, response.message);
				}
				else {
					addBootstrapAlert($modal, response.type, response.message);
				}
				$form.find('button').removeAttr('disabled');
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), '');
			},
			error: function() {
				$form.find('button').removeAttr('disabled');
				addBootstrapAlert($modal, 'danger', AJAX_ERROR_INESPERADO);
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), '');
			}
		});
	}

	function execAjaxSaveTicket($form, $ticket) {
		alert('244444444444444');
		if ($ticket.cantidad_jugadas > 0)
			ajaxSaveTicket($form, $ticket);
		else
			showMessage('info', 'El ticket no tiene ninguna jugada.');
	}

	function execAjaxSaveAndPrintTicket($form, $ticket) {

		if ($ticket.cantidad_jugadas > 0)
			ajaxSaveAndPrintTicket($form, $ticket);
		else
			showMessage('info', 'El ticket no tiene ninguna jugada.');
	}

	function sorteoEstaCerrado(hora_cierre) {
		var hora_cierre = new Date($('#server_date').html() + ' ' + hora_cierre);
		return server_date_time >= hora_cierre;
	}

	function messageSorteoCerrado($sorteo) {
		var message = '<strong>Sorteo cerrado</strong>: ';
		message += $('#hidden_nombre_loteria').val().toUpperCase() + ' -- ' + $sorteo.data('hora');
		return message;
	}

	var Animalito = function() {
		var _this = this;

		this.seleccionarAnimalitoEnListadoSegunDataInput = function($data_input) {
			let $numeros_animalitos = [];
			$numeros_animalitos = $data_input.split(',');
			for (let $numero of $numeros_animalitos) {
				if (Number.isInteger(parseInt($numero))) {
					var $checkbox_animalito = this.getCheckboxAnimalito($numero);
					if ($checkbox_animalito.length > 0) {
						this.seleccionarCheckboxAnimalito($checkbox_animalito);
						if ($('.listado-sorteos [name="sorteo_seleccionado"]:checked').length > 0)
							setFocusIn($('#monto'));							
						else
							setFocusIn($('#form-hora-sorteo #hora_sorteo'));
					}
				}
			}
		}

		this.getCheckboxAnimalito = function($numero_animalito) {
			return $('.listado-animalitos').find('input[data-numero="'+$numero_animalito+'"]');
		}

		this.seleccionarCheckboxAnimalito = function($input_checkbox) {
			$input_checkbox.prop('checked', true);
			afterCheckedAnimalitoSorteo($input_checkbox);
		}
	}

	var Sorteo = function() {
		var _this = this;

		this.seleccionarSorteoEnListadoSegunDataInput = function($data_input) {
			let $ids_sorteos = [];
			$ids_sorteos = $data_input.split(',');
			for (let $id of $ids_sorteos) {
				if (Number.isInteger(parseInt($id))) {
					var $checkbox_sorteo = this.getCheckboxSorteo($id);
					if ($checkbox_sorteo.length > 0) {
						this.seleccionarCheckboxSorteo($checkbox_sorteo);
						setFocusIn($('#monto'));
					}
				}
			}
		}

		this.getCheckboxSorteo = function($id_sorteo) {
			return $('.listado-sorteos').find('input[data-id="'+$id_sorteo+'"]');
		}

		this.seleccionarCheckboxSorteo = function($input_checkbox) {
			$input_checkbox.prop('checked', true);
			afterCheckedAnimalitoSorteo($input_checkbox);
		}
	}

	var Ticket = function() {
		var _this = this;
		this.monto_total = 0;
		this.cantidad_jugadas = 0;
		this.jugadas = {};

		this.reset = function() {
			this.monto_total = 0;
			this.cantidad_jugadas = 0;
			this.jugadas = {};
			$('#cantidad_jugadas_ticket').text(this.cantidad_jugadas);
			$('#monto_total_ticket').text(this.monto_total.toFixed(2));
			$('.detalle-ticket .list-group').html('');
			$('form[name=imprimir_ticket] button[data-toggle=save]').attr('disabled', 'disabled');
			$('form[name=save_and_imprimir_ticket] button[data-toggle=save]').attr('disabled', 'disabled');
		}

		/* Creación de una jugada */

		this.newJugada = function() {
			var ok_jugada = false;
			var id_loteria = $('#hidden_id_loteria').val();
			var nombre_loteria = $('#hidden_nombre_loteria').val();
			let $animalitos = this.getAnimalitosSeleccionados();
			let $sorteos = this.getSorteosSeleccionados();

			if ($animalitos.length > 0) {
				if ($sorteos.length > 0) {
					for (let $sorteo of $sorteos) {
						for (let $animalito of $animalitos) {
							var $id_jugada = parseInt('' + $sorteo.data('id') + $animalito.data('id'));
							var $monto_jugada = parseFloat($('#monto').val());
							var $monto_jugada_duplicada = this.getMontoJugadaFromJugadas($id_jugada);
							if ($monto_jugada_duplicada == false)
								this.addJugada($id_jugada, $animalito, $sorteo, $monto_jugada, id_loteria, nombre_loteria);
							else {
								this.updateMontoJugada($id_jugada, $monto_jugada_duplicada, $monto_jugada,
									id_loteria, nombre_loteria);
							}
						}
					}
					ok_jugada = true;
				}
				else {
					showMessage('info', 'Debe seleccionar al menos un sorteo.');
					setFocusIn($('#form-hora-sorteo #hora_sorteo'));
				}
			}
			else {
				showMessage('info', 'Debe seleccionar al menos un animalito.');
				setFocusIn($('#numero_animalito'));
			}

			return ok_jugada;
		}

		this.newJugadaRepetir = function(array) {
			if (array.length > 0) {
				for (var i=0; i<array.length; i++) {
					var id_loteria = array[i]['id_loteria'];
					var nombre_loteria = array[i]['nombre_loteria'];
					var id_jugada = parseInt('' + array[i]['id_sorteo'] + array[i]['id_animalito']);
					var monto_jugada = parseFloat(array[i]['monto']);
					var monto_jugada_duplicada = this.getMontoJugadaFromJugadas(id_jugada);
					if (monto_jugada_duplicada == true)
						this.updateMontoJugada(id_jugada, monto_jugada_duplicada, monto_jugada);
					else {
						$animalito = $('<input data-id="'+array[i]['id_animalito']+'" ' +
							'data-numero="'+array[i]['numero_animalito']+'" ' +
							'data-nombre="'+array[i]['nombre_animalito']+'" ' +
							'data-alias="'+array[i]['alias_animalito']+'">');
						$sorteo = $('<input data-id="'+array[i]['id_sorteo']+'" ' +
							'data-hora="'+array[i]['hora_sorteo']+'" ' +
							'data-hora-cierre="'+array[i]['cierre_sorteo']+'">');
						this.addJugada(id_jugada, $animalito, $sorteo, monto_jugada, id_loteria, nombre_loteria);
					}
				}
				this.setDataMoneda(array[0]['id_moneda'], array[0]['simbolo_moneda']);
			}
			else {
				showMessage('info', 'No hay sorteos disponibles.');
				setFocusIn($('#numero_animalito'));
			}
		}

		this.setDataMoneda = function(id, simbolo) {
			$('.simbolo-moneda').text(simbolo);
			$('#form-monto button[data-toggle="dropdown"]').html(simbolo + ' ' + '<span class="caret"></span>');
			$('#form-monto button[data-toggle="dropdown"]').attr(id + ',' + simbolo);
		}

		this.getAnimalitosSeleccionados = function() {
			var animalitos = [];
			$('.listado-animalitos input[name="animalito_seleccionado"]').each(function() {
		    	if ($(this).prop('checked') == true)
		            animalitos.push($(this));
			});
			return animalitos;
		}

		this.getSorteosSeleccionados = function() {
			var sorteos = [];
			$('.listado-sorteos input[name="sorteo_seleccionado"]').each(function() {
		    	if ($(this).prop('checked') == true)
		            sorteos.push($(this));
			});
			return sorteos;
		}

		this.getMontoJugadaFromJugadas = function($id_jugada) {
			try {
				return this.jugadas[$id_jugada].monto;
			} catch(e) {
				return false;
			}
		}

		/* Agregación de una jugada */

		this.addJugada = function($id_jugada, $animalito, $sorteo, $monto, id_loteria, nombre_loteria) {
			this.jugadas[$id_jugada] = this.createObjetoJugada(
				$animalito, $sorteo, $monto, id_loteria, nombre_loteria);
			this.appendJugadaHtml(this.createHtmlJugada(
				$id_jugada, $animalito.data('alias'), $sorteo.data('hora'), $monto, nombre_loteria));
			this.incrementarCantidadJugadas();
			this.incrementarMontoTotal($monto);
			$('form[name=imprimir_ticket] button[data-toggle=save]').attr('disabled', false);
			$('form[name=save_and_imprimir_ticket] button[data-toggle=save]').attr('disabled', false);
		}

		this.createObjetoJugada = function($animalito, $sorteo, $monto, id_loteria, nombre_loteria) {
			var $jugada = {
				'id_animalito': $animalito.data('id'),
				'nombre_animalito': $animalito.data('nombre'),
				'id_sorteo': $sorteo.data('id'),
				'hora_sorteo': $sorteo.data('hora'),
				'monto': $monto,
				'id_loteria': id_loteria,
				'nombre_loteria': nombre_loteria
			};			
			return $jugada;
		}

		this.appendJugadaHtml = function($detalle_html) {
			$('.detalle-ticket .list-group').append($detalle_html);
		}

		this.createHtmlJugada = function($id_jugada, $alias_animalito, $hora_sorteo, $monto, nombre_loteria) {
			var $li_detalle =
				'<li data-id="'+$id_jugada+'">' +
					'<input type="hidden" value="'+$id_jugada+'">' +
					'<div class="row detalle-jugada">' +
						'<div class="col-sm-8 col-md-8 col-lg-8">' +
							'<div class="sorteo">' +
								'<span class="text-muted">' +
									'<strong class="ucwords">'+nombre_loteria+'</strong> ' +
									'<strong>'+$hora_sorteo+'</strong>' +
								'</span>' +
							'</div>' +
							'<div class="animalito capitalize">' +
								'<span class="text-primary"><strong>'+$alias_animalito+'</strong></span>' +
							'</div>' +
						'</div>' +
						'<div class="col-sm-4 col-md-4 col-lg-4">' +
							'<div class="monto"><strong>'+$monto.toFixed(2)+'</strong></div>' +
							'<div class="eliminar">' +
								'<button class="btn btn-danger btn-xs" name="eliminar_detalle"' +
									' data-jugada="'+$id_jugada+'">Eliminar</button>' +
							'</div>' +
						'</div>' +
					'</div>' +
				'</li>'
			return $li_detalle;
		}

		this.incrementarCantidadJugadas = function() {
			this.cantidad_jugadas += 1
			$('#cantidad_jugadas_ticket').text(this.cantidad_jugadas);
		}

		this.incrementarMontoTotal = function($monto) {
			this.monto_total += $monto;
			this.updateHtmlMontoTotal(this.monto_total);
		}

		/* Actualización de una jugada */

		this.updateMontoJugada = function($id_jugada, $monto_actual, $monto_nuevo) {
			$monto = $monto_actual + $monto_nuevo;
			this.updateMontoObjetoJugada($id_jugada, $monto);
			this.updateMontoHtmlJugada($id_jugada, $monto);
			this.modificarMontoTotal($monto_actual, $monto);
		}

		this.changeMontoJugada = function(id_jugada, monto_nuevo) {
			var monto_actual = this.getMontoJugadaFromJugadas(id_jugada);
			if (monto_actual != false) {
				this.updateMontoObjetoJugada(id_jugada, monto_nuevo);
				this.updateMontoHtmlJugada(id_jugada, monto_nuevo);
				this.modificarMontoTotal(monto_actual, monto_nuevo);
			}
		}

		this.updateMontoObjetoJugada = function($id_jugada, $monto_nuevo) {
			this.jugadas[$id_jugada].monto = $monto_nuevo;
		}

		this.updateMontoHtmlJugada = function($id_jugada, $monto_nuevo) {
			$li = $('.detalle-ticket .list-group').find('li[data-id="'+$id_jugada+'"]');
			if ($li.length > 0)
				$li.find('.monto').html('<strong>'+$monto_nuevo.toFixed(2)+'</strong>');
		}

		this.modificarMontoTotal = function($monto_actual, $monto_nuevo) {
			this.monto_total -= $monto_actual;
			this.monto_total += $monto_nuevo;
			this.updateHtmlMontoTotal(this.monto_total);
		}

		/* Eliminación de una jugada */

		this.deleteJugada = function($button_eliminar) {
			if (this.cantidad_jugadas > 0) {
				$id_jugada = $button_eliminar.data('jugada');
				$monto_a_decrementar = this.getMontoJugadaFromJugadas($id_jugada);
				this.deleteObjetoJugada($id_jugada);
				this.deleteHtmlJugada($id_jugada);
				this.decrementarCantidadJugadas();
				this.decrementarMontoTotal($monto_a_decrementar);
				if (this.cantidad_jugadas == 0) {
					$('form[name=imprimir_ticket] button[data-toggle=save]').attr('disabled', 'disabled');
					$('form[name=save_and_imprimir_ticket] button[data-toggle=save]').attr('disabled', 'disabled');
				}
			}
		}

		this.deleteObjetoJugada = function($id_jugada) {
			delete this.jugadas[$id_jugada];
		}

		this.deleteHtmlJugada = function($id_jugada) {
			$('.detalle-ticket .list-group').find('li[data-id="'+$id_jugada+'"]').remove();
		}	

		this.decrementarCantidadJugadas = function() {
			this.cantidad_jugadas -= 1
			$('#cantidad_jugadas_ticket').text(this.cantidad_jugadas);
		}

		this.decrementarMontoTotal = function($monto) {
			this.monto_total -= $monto;
			this.updateHtmlMontoTotal(this.monto_total);
		}

		/* Html monto total */
		this.updateHtmlMontoTotal = function($monto) {
			$('#monto_total_ticket').text($monto.toFixed(2));
		}

		this.obtenerMonedaData = function() {
			return $('#form-monto button[data-toggle="dropdown"]').attr('data-moneda');
		}

		this.obtenerMontoMinimoMoneda = function() {
			return $('#form-monto button[data-toggle="dropdown"]').attr('data-minimo');
		}
	}

	/**
	 *
	 * Todas las acciones relacionadas con la venta del ticket.
	 *
	 */
	
	var $ticket = new Ticket();

	$(function() {
		$('#loteria_seleccionada').on('change', function(event) {
			var $option_seleced = $(this).children(':selected');
			var loteria = {'nombre': $option_seleced.data('nombre'), 'id': $option_seleced.val()};
			var url = $option_seleced.data('url');
			updateListadoAnimalitosAndSorteos(url, loteria);
		});
	});

	$(function() {
		$(document).on('change', 'div[class ^= listado-] input[type="checkbox"]', function() {
			if ($(this).prop('checked') == true) {
				if ($(this).attr('name') == 'sorteo_seleccionado') {
					if (sorteoEstaCerrado($(this).data('hora-cierre')) == true) {
						$(this).parent().parent().parent().remove();
						showMessage('info', messageSorteoCerrado($(this)));
					}
				}
				afterCheckedAnimalitoSorteo($(this));
			}
			else
				afterUncheckedAnimalitoSorteo($(this));
			setFocusIn($('#monto'));
		});
	});

 	// Seleccionar todos los animalitos ó sorteos.
	$(function() {
		$('input[data-toggle ^= select-all-]').change(function() {
			var $input_checkbox = $(this).parent().parent().parent().parent().find(
				'div[class ^= listado-] input[type=checkbox]');
			if ($(this).prop('checked') == true) {
				$input_checkbox.prop('checked', true);
				afterCheckedAnimalitoSorteo($input_checkbox);
				setFocusIn($('#monto'));
			}
			else {
				$input_checkbox.prop('checked', false);
				afterUncheckedAnimalitoSorteo($input_checkbox);
			}
		});
	});

	// Selección de animalitos por entrada de datos.
	$(function() {
		$('#form-numero-animalito').on('submit', function(event) {			
			event.preventDefault();
			if (isEmpty($('#numero_animalito')) == false) {
				var $animalito = new Animalito();
				$animalito.seleccionarAnimalitoEnListadoSegunDataInput($('#numero_animalito').val());
				$('#numero_animalito').val('');
			}
		});
	});

	// Selección de sorteos por entrada de datos.
	$(function() {
		$('#form-hora-sorteo').on('submit', function(event) {			
			event.preventDefault();
			if (isEmpty($('#hora_sorteo')) == false) {
				var $sorteo = new Sorteo();
				$sorteo.seleccionarSorteoEnListadoSegunDataInput($('#hora_sorteo').val());
				$('#hora_sorteo').val('');
			}
		});
	});

	// Carga símbolo de la primera moneda del listado.
	$(function() {
		var simboloMonedaSeleccionada = $('#form-monto button[data-toggle="dropdown"]').text().replace(' ', '');
		$('.simbolo-moneda').text(simboloMonedaSeleccionada);
	});

	$(function() {
		$('#form-monto').on('submit', function(event) {
			event.preventDefault();
			var moneda = $ticket.obtenerMonedaData().split(',')[1];
			var montoMinimo = parseFloat($ticket.obtenerMontoMinimoMoneda());
			if (isEmpty($('#monto')) == false && isMontoValido($('#monto').val()) == true) {
				if (parseFloat($('#monto').val()) < montoMinimo)
					showMessage('info', 'Debe ingresar un monto mayor o igual que ' + montoMinimo + ' ' + moneda);
				else {
					if ($ticket.newJugada() == true)
						restablecerCampos();
				}
			}
			else {
				showMessage('info', 'Ingrese un monto válido.');
				setFocusIn($('#monto'));
			}
		});
	});

	// Elimina una jugada del ticket.
	$(function() {
		$(document).on('click', '.detalle-ticket button[name="eliminar_detalle"]', function() {
			$ticket.deleteJugada($(this));
		});
	});

	$(function() {
		$('.detalle-ticket form[name=imprimir_ticket]').on('submit', function(event) {
			event.preventDefault();
			var $form = $(this);
			execAjaxSaveTicket($form, $ticket);
		});
	});

	$(function() {
		$('.detalle-ticket form[name=save_and_imprimir_ticket]').on('submit', function(event) {
			event.preventDefault();
			var $form = $(this);
			execAjaxSaveAndPrintTicket($form, $ticket);
		});
	});

	$(function() {
		$('.detalle-ticket form[name=reimprimir_ticket]').on('submit', function(event) {
			event.preventDefault();



			var url = '/Venta_Animalitos/imprimeTicket/imp.php?reimpresion=1'; //respaldo
			//var url = impresion.php;
			$.post(url, function(data) {
				$('#print-ticket-area').html('').append(data);
			})
			.done(function() {
				printAction();
			});



		});
	});

	$(function() {
		$('.hotkeys button[data-toggle="cancel"]').on('click', function(event) {
			cancelarJugada($ticket);
		});
	});

	$(function() {
		$('#modal_ticket button[data-action=print]').on('click', function() {
			printAction();
			$('#modal_ticket').modal('hide');
		});
	});

	$(function() {
		$('#modal_ticket button[data-action=copy]').on('click', function() {
			var content = "", contentArray = [];
			$('.copy').each(function(index) {
				var includeValidation = $(this).data('copy') + $(this).data('copy-loteria')
				if (!contentArray.includes(includeValidation))
					content += $(this).data('copy') + "\n";
				contentArray.push(includeValidation)
			});
			navigator.clipboard.writeText(content)
				.then(() => {
					showMessage('success', 'Ticket copiado.');
				})
				.catch(err => {
					console.log('Algo salió mal al copiar el ticket.', err);
				});
		});
	});

	$(function() {
		$('#modal_ticket').find('button[data-target="#modal_anular_ticket"]').click(function() {
			var id_ticket = $(this).data('id');
			$('#modal_anular_ticket form[name=buscar_ticket]').find('#buscar_ticket_id_ticket').val(id_ticket);
			$('#modal_anular_ticket form[name=buscar_ticket]').submit();
		});
	});

	$(function() {
		$('#modal_ticket').on('hide.bs.modal', function(event) {
			addIconLoadingIn($(this).find('.modal-body'));
			$(this).find('[data-action=print]').attr('disabled', 'disabled');
			$(this).find('[data-action=email]').attr('disabled', 'disabled');
			$(this).find('[data-action=sms]').attr('disabled', 'disabled');
			$(this).find('[data-action=anular]').attr('disabled', 'disabled');
			$(this).find('[data-action=copy]').attr('disabled', 'disabled');
		});
	});

	/**
	 *
	 * Toolbar.
	 *
	 */

	$(function() {
		// Consulto resultados con la fecha actual al abrirse el modal.
		$('#modal_resultados').on('show.bs.modal', function(event) {
			$('form[name=ventas_buscar_resultados]').find('#buscar_resultados_fecha').val(formatDateServerTime());
			postAjaxBuscarResultados($('form[name=ventas_buscar_resultados]'));
		});

		$('form[name=ventas_buscar_resultados]').on('submit', function(event) {
			event.preventDefault();
			if (isEmpty($(this).find('#buscar_resultados_fecha')) == false)
				postAjaxBuscarResultados($(this));
		});
	});

	$(function() {
		$('#modal_buscar_ticket').on('show.bs.modal', function(event) {
			$(this).find('.modal-body section.ticket_area').html('');
		});

		$('#modal_buscar_ticket form[name=buscar_ticket]').on('submit', function(event) {
			event.preventDefault();
			if (isEmpty($(this).find('#buscar_ticket_id_ticket')) == false &&
				isZero($(this).find('#buscar_ticket_id_ticket')) == false)
			{
				postAjaxBuscarTicket($(this));
			}
		});
	});

	$(function() {
		$('#modal_anular_ticket').on('show.bs.modal', function(event) {
			$(this).find('.modal-body section.ticket_area').html('');
		});

		$('#modal_anular_ticket form[name=buscar_ticket]').on('submit', function(event) {
			event.preventDefault();
			if (isEmpty($(this).find('#buscar_ticket_id_ticket')) == false &&
				isZero($(this).find('#buscar_ticket_id_ticket')) == false)
			{
				postAjaxBuscarAnularTicket($(this));
			}
		});

		$('#modal_anular_ticket').on('hidden.bs.modal', function(event) {
			$('#modal_anular_ticket button[data-action=anular]').attr('disabled', 'disabled');
		});
	});

	$(function() {		
		$('#modal_reporte').on('shown.bs.modal', function(event) {
			$.post($(this).data('url'), function(data) {
				$('#modal_reporte').find('.modal-body section.reporte').html(data.reporte_modal);
				$('#print-ticket-area').html('').append(data.reporte_print);				
			}, 'json');			
		});

		$('#modal_reporte button[data-action=print]').on('click', function() {
			printAction();
		});

		$('#modal_reporte').on('hidden.bs.modal', function(event) {
			addIconLoadingIn($('#modal_reporte').find('.modal-body section.reporte'));
		});

		$(document).on('change', '#reporte-moneda', function() {
			addIconLoadingIn($('#modal_reporte').find('.modal-body section.reporte'));
			var url = $(this).children(':selected').data('url')
			$.post(url, function(data) {
				$('#modal_reporte').find('.modal-body section.reporte').html(data.reporte_modal);
				$('#print-ticket-area').html('').append(data.reporte_print);				
			}, 'json');	
		});
	});

	$(function() {		
		$('#modal_reporte_jugadas').on('shown.bs.modal', function(event) {
			$.post($(this).data('url'), function(data) {
				$('#modal_reporte_jugadas').find('.modal-body section.reporte_jugadas').html(data);			
			});			
		});



	});

	$(function() {
		$('#modal_listado_pagos').on('shown.bs.modal', function(event) {
			console.log('sdasd')
			var table = $('#table_pagos').DataTable( {
				'processing': true,
		        'serverSide': true,
		        'destroy': true,
		        'bLengthChange': false,
		        'language': {
		            'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
		        },
		        'ajax': {
		            'url': $('#modal_listado_pagos').data('url'),
		            'type': 'POST',
		            'dataType': 'JSON'
		        },
		        columns: [
		            {'data': 'id'},
		            {'data': 'fecha'},
		            {'data': 'hora', 'width': '20%'},
					{'data': 'simbolo_moneda'},
		            {'data': 'total'},
		            {'data': 'email'},
		            {'data': 'sms'},
		            {'data': 'premio'},
		            {'data': 'accion'}
		        ],
		        'columnDefs': [{
		            'targets': -1,
		            'data': null,
		            'defaultContent': '<a href="#" class="btn btn-default" data-toggle="modal"' +
		            	'data-target="#modal_pagar_ticket" title="Pagar este ticket">' +
		            	'<span class="fa fa-money"></span></a>'
		        }]
		    });

		    $('#table_pagos tbody').on('click', 'a', function () {
		    	var id_ticket = $(this).parent().parent().find('td').eq(0).text();
		    	$('#modal_pagar_ticket').data('ticket', id_ticket);
		    });
		});

		$('#modal_listado_pagos').on('hidden.bs.modal', function(event) {
			$('#table_pagos tbody').html('');
		});
	});

	$(function() {
		$('#modal_pagar_ticket form[name=venta_pagos_pagar_ticket]').on('submit', function(event) {
			event.preventDefault();
			$(this).find('#venta_pagos_pagar_ticket_id_ticket').val($('#modal_pagar_ticket').data('ticket'));
			if (isEmpty($(this).find('#venta_pagos_pagar_ticket_serial')) == false &&
				isZero($(this).find('#venta_pagos_pagar_ticket_serial')) == false)
			{
				postAjaxPagarTicket($(this));
			}
		});
	});

	/**
	 *
	 * Confirmar - Anular ticket
	 *
	 */

	$(function() {
		$('#modal_confirmar[data-type=ajax]').on('shown.bs.modal', function(event) {
			var url = $('#modal_confirmar #hidden_confirmar_url').val();
			$(this).find('.modal-body').load(url, function() {
				$('#modal_confirmar form[name=confirmar]').attr('action', url);
				$('form[name=confirmar] #confirmar_confirmar_hidden').val($('#modal_confirmar #hidden_id').val());
				$('form[name=confirmar]').on('submit', function(event) {
					event.preventDefault();
					postAjaxAnularTicket($('form[name=confirmar]'), $('#modal_confirmar'));
				});
			});
		});
	});

	/**
	 *
	 * Enviar email.
	 *
	 */
	$(function() {
		$(document).on('click', '[data-target="#modal_send_email"]', function(event) {
			event.preventDefault();
			$('#modal_send_email #hidden_email_id_ticket').val($(this).data('id'));
			$('#modal_send_email #hidden_email_url').val($(this).data('url'));
		});
		$('#modal_send_email').on('shown.bs.modal', function(event) {
			var url = $('#modal_send_email #hidden_email_url').val();
			$(this).find('.modal-body').load(url, function() {
				$('#modal_send_email form[name=send_ticket_email]').attr('action', url);
				$('form[name=send_ticket_email] #send_ticket_email_ticket_id').val(
					$('#modal_send_email #hidden_email_id_ticket').val());
				$('form[name=send_ticket_email]').on('submit', function(event) {
					event.preventDefault();
					postAjaxSendEmailTicket($('form[name=send_ticket_email]'), $('#modal_send_email'));
				});
			});
		});
	});

	/**
	 *
	 * Enviar SMS.
	 *
	 */
	$(function() {
		$('[data-target="#modal_send_sms"]').on('click', function(event) {
			event.preventDefault();
			console.log($(this).data('id'))
			$('#modal_send_sms #hidden_sms_id_ticket').val($(this).data('id'));
			$('#modal_send_sms #hidden_sms_url').val($(this).data('url'));
		});
	});

	$(function() {
		$('#modal_send_sms').on('shown.bs.modal', function(event) {
			var url = $('#modal_send_sms #hidden_sms_url').val();
			$(this).find('.modal-body').load(url, function() {
				$('#modal_send_sms form[name=send_ticket_sms]').attr('action', url);
				$('form[name=send_ticket_sms] #send_ticket_sms_ticket_id').val(
					$('#modal_send_sms #hidden_sms_id_ticket').val());
			});
		});
		
		$(document).on('submit', '#modal_send_sms form[name=send_ticket_sms]', function(event) {
			event.preventDefault();
			postAjaxSendSMSTicket($('form[name=send_ticket_sms]'), $('#modal_send_sms'));
		});
	})

	/**
	 *
	 * Ventas recientes.
	 *
	 */
	
	$(function() {
		$('#modal_listado_ventas_recientes').on('shown.bs.modal', function(event) {
			var table = $('#table_ventas_recientes').DataTable( {
				'processing': true,
		        'serverSide': true,
		        'destroy': true,
		        'bLengthChange': false,
		        'language': {
		            'url': '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'
		        },
		        'ajax': {
		            'url': $('#modal_listado_ventas_recientes').data('url'),
		            'type': 'POST',
		            'dataType': 'JSON'
		        },
		        columns: [
		            {'data': 'id'},
		            {'data': 'hora'},
					{'data': 'simbolo_moneda'},
		            {'data': 'total'},
		            {'data': 'premio'},
		            {'data': 'email'},
		            {'data': 'sms'},
		            {'data': 'estatus'},
		            {'data': 'accion'}
		        ],
		        'columnDefs': [{
		            'targets': -1,
		            'data': null,
		            'defaultContent':
		            	'<a href="#" class="btn btn-default" data-toggle="modal"' +
		            		'data-target="#modal_buscar_ticket" title="Ver ticket">' +
		            		'<span class="fa fa-eye"></span></a> ' +
		            	'<button class="btn btn-default" data-target="#modal_anular_ticket"' +
		            		'data-toggle="modal" title="Anular ticket"' +
		            		'data-url="/movimientos/anularTicket/0/anularAjax">' +
		            		'<span class="fa fa-ban"></span></button> ' +
		            	'<button class="btn btn-default" data-toggle="modal"' +
		            		'data-target="#modal_ticket" title="Reimprimir ticket">' +
		            		'<span class="fa fa-print"></span></button>'
		        }],
		        'rowCallback': function(row, data, index) {
		        	var label = '<label class="label label-'+data['estatus']+'">'+data['estatus'].toUpperCase()+'</label>';
				    $(row).find('td:eq(7)').empty().append(label);
				    if (data['estatus'] != 'no premiado') {
				    	var $btn_print = $(row).find('td:eq(7)').find('[data-target="#modal_ticket"]');
				    	var $btn_anular = $(row).find('td:eq(7)').find('[data-target="#modal_anular_ticket"]');
				    	$btn_print.removeAttr('data-toggle');
				    	$btn_print.removeAttr('data-target');
				    	$btn_print.attr('disabled', 'disabled');
				    	$btn_anular.removeAttr('data-target');
				    	$btn_anular.removeAttr('data-toggle');
				    	$btn_anular.attr('disabled', 'disabled');
				    }
			    }
		    });
		});

		// Buscar ticket.
		$('#table_ventas_recientes').on('click', 'a[data-target="#modal_buscar_ticket"]', function() {
			var id_ticket = $(this).parent().parent().find('td').eq(0).text();
			$('#modal_buscar_imprimeTicketticket form[name=buscar_ticket]').find('#buscar_ticket_id_ticket').val(id_ticket);
			$('#modal_buscar_ticket form[name=buscar_ticket]').submit();
		});

		// Anular ticket.
		$('#table_ventas_recientes').on('click', 'button[data-target="#modal_anular_ticket"]', function() {
			var id_ticket = $(this).parent().parent().find('td').eq(0).text();
			$('#modal_anular_ticket form[name=buscar_ticket]').find('#buscar_ticket_id_ticket').val(id_ticket);
			$('#modal_anular_ticket form[name=buscar_ticket]').submit();
		});

		// Reimprimir ticket.
		$('#table_ventas_recientes').on('click', 'button[data-target="#modal_ticket"]', function() {
			$('#modal_listado_ventas_recientes').modal('hide');
			var id_ticket = $(this).parent().parent().find('td').eq(0).text();
			loadTicket(id_ticket, 'reimprime');
		});
	});

	$(function() {
		$('#modal_listado_ventas_recientes').on('hidden.bs.modal', function(event) {
			$('#table_ventas_recientes tbody').html('');
		});
	});

	/**
	 *
	 * Repetir ticket.
	 *
	 */

	$('form[name=repetir_ticket_cargar] #repetir_ticket_cargar_loterias').on('change', function(event) {
		var $select_parent = $(this);
		var $form = $('form[name=repetir_ticket_cargar]');
		postAjaxDependentSelects($form, $select_parent, false, 'Todos');
	});

	function postAjaxRepetirTicketBuscar($form) {
		var $modal = $('#modal_repetir_ticket');
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			beforeSend: function() {
				removeBootstrapAlert();
				disabledAndAddIconLoading($form.find('button[type=submit]'));
			},
			success: function(response) {
				if (response.type != 'danger') {
					if (response.type == 'success') {
						$modal.find('#repetir_ticket_cargar_id_ticket').val(response.data.id_ticket);
						$('#repetir_ticket_cargar_loterias option').not(':first').remove();
						response.data.loterias.forEach(function(loteria) {
							$('#repetir_ticket_cargar_loterias').append(
								'<option value="'+loteria['id']+'">'+loteria['nombre'].toUpperCase()+'</option>');
						});
						enabledSelect($modal.find('select'));
						$('#modal_repetir_ticket button[data-action=cargar]').removeAttr('disabled');
					}
					else {
						disabledAndClearSelect($modal.find('select'), 'Todos');
						$('#modal_repetir_ticket button[data-action=cargar]').attr('disabled', 'disabled');
					}
				}
				addBootstrapAlert($modal, response.type, response.message);
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), 'search');
			},
			error: function() {
				addBootstrapAlert($modal, 'danger', AJAX_ERROR_INESPERADO);
				enabledAndRemoveIconLoading($form.find('button[type=submit]'), 'search');
			}
		});
	}

	function postAjaxRepetirTicketCargar($form) {
		var $modal = $('#modal_repetir_ticket');
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: $form.attr('action'),
			data: $form.serialize(),
			beforeSend: function() {
				removeBootstrapAlert();
				$modal.find('.modal-footer button').attr('disabled', 'disabled');
				disabledAndAddIconLoading($modal.find('button[data-action=cargar]'));
			},
			success: function(response) {
				if (response.type == 'success') {
					$ticket.reset();
					$ticket.newJugadaRepetir(response.data);
					$modal.modal('hide');
				}
				$modal.find('.modal-footer button').removeAttr('disabled');
				enabledAndRemoveIconLoading($modal.find('button[data-action=cargar]'), '');
			},
			error: function() {
				addBootstrapAlert($modal, 'danger', AJAX_ERROR_INESPERADO);
				$modal.find('.modal-footer button').removeAttr('disabled');
				enabledAndRemoveIconLoading($modal.find('button[data-action=cargar]'), '');
			}
		});
	}

	$(function() {
		$('form[name=repetir_ticket_buscar]').on('submit', function(event) {
			event.preventDefault();
			if (!isEmpty($('form[name=repetir_ticket_buscar]').find('#repetir_ticket_buscar_numero_ticket')))
				postAjaxRepetirTicketBuscar($('form[name=repetir_ticket_buscar]'));
		});

		$('form[name=repetir_ticket_cargar]').submit(function(event) {
			event.preventDefault();
			postAjaxRepetirTicketCargar($(this));
		});

		$('#modal_repetir_ticket button[data-action=cargar]').click(function() {
			if ($('#modal_repetir_ticket #repetir_ticket_cargar_id_ticket').val())
				$('form[name=repetir_ticket_cargar]').submit();
		});

		$('#modal_repetir_ticket').on('hidden.bs.modal', function(event) {
			disabledAndClearSelect($(this).find('select'), 'Todos');
			$('#modal_repetir_ticket button[data-action=cargar]').attr('disabled', 'disabled');
		});
	});

	/**
	 *
	 * Hotkeys.
	 *
	 */
	
	$(function() {
		$(document).bind('keydown', 'f1x',function (event){
			if ($('.hotkeys button[data-toggle=save]').attr('disabled') != 'disabled')
				execAjaxSaveTicket($('form[name=imprimir_ticket]'), $ticket);
			return false;
		});
		$('.form-control').bind('keydown', 'f1x',function (event) {
			if ($('.hotkeys button[data-toggle=save]').attr('disabled') != 'disabled')
				execAjaxSaveTicket($('form[name=imprimir_ticket]'), $ticket);
			return false;
		});

		$(document).bind('keydown', 'escx',function (event){
			cancelarJugada($ticket);
			return false;
		});
		$('.form-control').bind('keydown', 'escx',function (event) {
			cancelarJugada($ticket);
			return false;
		});

		$(document).bind('keydown', 'f2x',function (event){
			$('#modal_repetir_ticket').modal('show');
			return false;
		});
		$('.form-control').bind('keydown', 'f2x',function (event) {
			$('#modal_repetir_ticket').modal('show');
			return false;
		});

		$(document).bind('keydown', 'f3x',function (event){
			$('#modal_listado_ventas_recientes').modal('show');
			return false;
		});
		$('.form-control').bind('keydown', 'f3x',function (event) {
			$('#modal_listado_ventas_recientes').modal('show');
			return false;
		});

		$(document).bind('keydown', 'f4x',function (event){
			$('#modal_buscar_ticket').modal('show');
			return false;
		});
		$('.form-control').bind('keydown', 'f4x',function (event) {
			$('#modal_buscar_ticket').modal('show');
			return false;
		});

		$(document).bind('keydown', 'f6x',function (event){
			$('#modal_anular_ticket').modal('show');
			return false;
		});
		$('.form-control').bind('keydown', 'f6x',function (event) {
			$('#modal_anular_ticket').modal('show');
			return false;
		});

		$(document).bind('keydown', 'f8x',function (event){
			$('#modal_listado_pagos').modal('show');
			return false;
		});
		$('.form-control').bind('keydown', 'f8x',function (event) {
			$('#modal_listado_pagos').modal('show');
			return false;
		});

		$(document).bind('keydown', 'f9x',function (event){
			$('#modal_resultados').modal('show');
			return false;
		});
		$('.form-control').bind('keydown', 'f9x',function (event) {
			$('#modal_resultados').modal('show');
			return false;
		});

		$(document).bind('keydown', 'f10',function (event){
			$('#modal_reporte').modal('show');
			return false;
		});
		$('.form-control').bind('keydown', 'f10',function (event) {
			$('#modal_reporte').modal('show');
			return false;
		});

		$(document).bind('keydown', 'ctrl+f1',function (event){
			alert('222222222222');
			if ($('.hotkeys button[data-toggle=save]').attr('disabled') != 'disabled')
				execAjaxSaveAndPrintTicket($('form[name=save_and_imprimir_ticket]'), $ticket);
			return false;
		});
		$('.form-control').bind('keydown', 'ctrl+f1',function (event) {
			alert('1111111111111');
			if ($('.hotkeys button[data-toggle=save]').attr('disabled') != 'disabled')
				execAjaxSaveAndPrintTicket($('form[name=save_and_imprimir_ticket]'), $ticket);
			return false;
		});
	});

	/**
	 * Muestra el monto en Bs.F al ingresar un valor en el campo monto jugada.
	 */
	/*$('#monto').keyup(function() {
		if (isEmpty($(this)))
			$('.monto-bsf > span').html(0);
		else {
			monto = parseFloat($(this).val()) * 100000;
			$('.monto-bsf > span').html(new Intl.NumberFormat('de-DE').format(monto));
		}
	});*/

	/**
	 * Multimoneda.
	 */
	$('#seleccion-moneda').click(function() {
		
		var idMoneda = $(this).data('id-moneda');
		var simboloMoneda = $(this).text();
		var montoMinimoJugada = $(this).data('minimo');
		var buttonText = simboloMoneda + ' ' + '<span class="caret"></span>';
		var $toggleButtonMoneda = $(this).parent().parent().parent().find('button[data-toggle="dropdown"]');
		var idMonedaActual = $toggleButtonMoneda.attr('data-moneda').split(',')[0];
		alert(idMonedaActual);
		if ($ticket.cantidad_jugadas > 0) {
			if (idMonedaActual != idMoneda) {
				var message = '<div style="display: inline"><strong>Debe cancelar todas las jugadas para cambiar de Moneda</strong>';
				message += '<br><strong>Seleccione una opción</strong>: ';
				message += '<button class="btn btn-default btn-xs reiniciar_ticket">Cancelar todas las jugadas</button><br><br></div>';
				showMessage('warning', message, true);

				$('.reiniciar_ticket').on('click', function() {
					$toggleButtonMoneda.html(buttonText);
					$toggleButtonMoneda.attr('data-moneda', idMoneda + ',' + simboloMoneda);
					$toggleButtonMoneda.attr('data-minimo', montoMinimoJugada);
					$('.simbolo-moneda').text(simboloMoneda);
					cancelarJugada($ticket);
					showMessage('success', 'Las jugadas han sido canceladas de forma exitosa.');
				});
			}
		}
		else {
			$toggleButtonMoneda.html(buttonText);
			$toggleButtonMoneda.attr('data-moneda', idMoneda + ',' + simboloMoneda);
			$toggleButtonMoneda.attr('data-minimo', montoMinimoJugada);
			$('.simbolo-moneda').text(simboloMoneda);
		}
	});

})
