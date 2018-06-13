Pace.on('done', function(){
	init();
});

var registros_dia;
var horas_dia;
var horas_usuario;
var horas_dia_usuario;
var horario_usuario;

Chart.plugins.register({
	afterDatasetsDraw: function(chart) {
		var ctx = chart.ctx;

		if(chart.canvas.id == 'horas-usuario'){
			chart.data.datasets.forEach(function(dataset, i) {
				var meta = chart.getDatasetMeta(i);
				if (!meta.hidden) {
					meta.data.forEach(function(element, index) {
					// Draw the text in black, with the specified font
					ctx.fillStyle = 'rgb(0, 0, 0)';

					var fontSize = 16;
					var fontStyle = 'normal';
					var fontFamily = 'Helvetica Neue';
					ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

					// Just naively convert to string for now
					var dataString = dataset.data[index].toString();

					// Make sure alignment settings are correct
					ctx.textAlign = 'center';
					ctx.textBaseline = 'middle';

					var padding = 5;
					var position = element.tooltipPosition();

					if(dataString != '0'){
						ctx.fillText(dataString, position.x, position.y + (fontSize / 2) + padding);
					}
				});
				}
			});
		}
	}
});

function eliminar(id, nombre) {
	$.ajax({
		url:  base_url + 'checador/Main_controller/register_data',
		type:  'post',
		data: {'id': id},
		success: function(respuesta){
			if(respuesta){
				$("#datos-registro").html(respuesta);
				$('#id_eliminar').val(id);
				$("#eliminar_registro").modal('open');
			}
		},
		error:  function(xhr,err){ 
			console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
		}
	});
}

function change_password(id, nombre) {
	$("#cp_nombre").html(nombre);
	$('#id').val(id);
	$("#change_password").modal('open');
}

function detalles(id) {
	$.ajax({
		url:  base_url + 'checador/Main_controller/get_activity',
		type:  'post',
		data: {'id': id},
		success: function(respuesta){
			if(respuesta){
				$("#datos-actividad").html(respuesta);
				$("#ver_actividad").modal('open');
			}
		},
		error:  function(xhr,err){ 
			console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
		}
	});
}

function get_username(clave) {
	var name = '';

	$.ajax({
		url:  base_url + 'checador/Main_controller/get_username',
		type:  'post',
		data: {'clave': clave},
		success: function(respuesta){
			if(respuesta){
				name = respuesta;
			}
			return name;
		},
		error:  function(xhr,err){ 
			console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
		}
	});
}

function init(){
	$('#app_container').show();
	
	Materialize.updateTextFields();
	$('select').material_select();
	$('.modal').modal();
	$('.tooltipped').tooltip({delay: 50});
	$(".button-collapse").sideNav();

	$.extend(jQuery.validator.messages, {
		required: "Requerido.",
		remote: "Por favor arregle este campo.",
		email: "Por favor ingrese una dirección de correo válida.",
		number: "Ingrese un número válido.",
		digits: "Ingrese únicamente dígitos.",
		equalTo: "Ingresa el mismo valor.",
		maxlength: $.validator.format("Por favor no ingrese más de {0} caracteres."),
		minlength: $.validator.format("Ingrese al menos {0} caracteres."),
		rangelength: $.validator.format("Ingrese un valor entre {0} y {1} caracteres de longitud."),
		range: $.validator.format("Ingrese un valor entre {0} y {1}."),
		max: $.validator.format("Por favor ingrese un valor menor o igual a {0}."),
		min: $.validator.format("Por favor ingrese un valor mayor o igual a {0}."),
		url: "Ingrese una URL valida, es necesario añadir http o https"
	});

	$.validator.setDefaults({
		ignore: []
	});

	$('#entry-datepicker').pickadate({
		selectMonths: true,
		selectYears: 15,
		closeOnSelect: false,

		monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		showMonthsShort: undefined,
		showWeekdaysFull: undefined,

		today: 'Hoy',
		clear: 'Limpiar',
		close: 'Ok',

		labelMonthNext: 'Siguiente mes',
		labelMonthPrev: 'Mes pasado',
		labelMonthSelect: 'Seleccione un mes',
		labelYearSelect: 'Seleccione un año',

		formatSubmit: 'yyyy-mm-dd',
		hiddenPrefix: 'prefix__',
		hiddenName: true,

		min: false,
		max: false
	});

	$('.timepicker').pickatime({
		default: 'now',
		fromnow: 0,
		twelvehour: false,
		donetext: 'OK',
		cleartext: 'Limpiar',
		canceltext: 'Cancelar',
		container: undefined,
		autoclose: false,
		ampmclickable: true,
		aftershow: function(){}
	});

	var home_data = document.getElementById('home_data');
	if(home_data){
		get_home_data();
	}

	$('#fecha_home_datatable').change(function(){
		get_home_data();
	});

	var users_data = document.getElementById('users_data');
	if(users_data){
		get_users_data();
	}
	
	var graph_data = document.getElementById('reporte-registros');
	if(graph_data){
		$.ajax({
			url:  base_url + 'checador/Main_controller/load_report_users',
			success: function(respuesta){
				$('#usuarios_reporte').html(respuesta);
				$('select').material_select();

				$.ajax({
					url:  base_url + 'checador/Main_controller/get_month',
					success: function(respuesta){
						$('#fecha_periodo').html(respuesta);
						$('select').material_select();

						set_graphs();
					},
					error:  function(xhr,err){ 
						console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
					}
				});
			},
			error:  function(xhr,err){ 
				console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
			}
		});
	}

	var registro_edit = document.getElementById('form_editar_registro');
	if(registro_edit){
		var id_registro = document.getElementById("id_registro").value;

		$.ajax({
			url:  base_url + 'checador/Main_controller/load_calendar',
			type: 'post',
			data: {'id' : id_registro},
			success: function(respuesta){
				if(respuesta){
					var datos = JSON.parse(respuesta);
					$('#nombre-empleado').html(datos.name);

					var $input = $('#entry-datepicker').pickadate();
					var picker = $input.pickadate('picker');
					picker.set('select', datos.entry_date, { format: 'yyyy-mm-dd' });
				}
			},
			error:  function(xhr,err){ 
				console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
			}
		});
	}

	$('#fecha_periodo').change(function(){
		actualizar_graphs();
	});

	$('#usuarios_reporte').change(function(){
		if(document.getElementById("usuarios_reporte").value == '0'){
			$('#graficas-acumuladas').removeClass('hide');
			$('#graficas-individuales').addClass('hide');
		}
		else{
			$('#graficas-acumuladas').addClass('hide');
			$('#graficas-individuales').removeClass('hide');
		}

		actualizar_graphs();
	});

	$('#form_agregar_usuario').validate({
		rules: {
			admin_password: {
				required: true,
				remote: {
					url: "checador/Main_controller/check_admin_hash",
					type: "post",
					data: {
						admin_password: function() {
							return $( "#admin_password" ).val();
						}
					}
				}
			},
			password2: {
				equalTo: "#password1"
			},
		},
		messages: {
			admin_password: {
				required: "Ingrese su clave.",
				remote: "La clave es incorrecta."
			},
			password2: {
				required: "Ingrese la clave nuevamente.",
				equalTo: "La clave no coincide."
			},
		},
		submitHandler: function(form) {
			var respuesta = false;

			$.ajax({
				url:  base_url + 'checador/Main_controller/new_user',
				type:  'post',
				data: $(form).serialize(),
				success: function(respuesta){
					if(respuesta){
						window.location.href = base_url+'users';
					}
					else{
						form.reset();
						Materialize.updateTextFields();
						$('#contact_submit_message').removeClass('hide');
						$('#contact_submit_message').addClass('animated fadeIn');
					}
				},
				error:  function(xhr,err){ 
					console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
				}
			});
		}
	});

	$('#form_editar_registro').validate({
		rules: {
			admin_password: {
				required: true,
				remote: {
					url: base_url + "checador/Main_controller/check_admin_hash",
					type: "post",
					data: {
						admin_password: function() {
							return $( "#admin_password" ).val();
						}
					}
				}
			}
		},
		messages: {
			admin_password: {
				required: "Ingrese su clave.",
				remote: "La clave es incorrecta."
			}
		},
		submitHandler: function(form) {
			var respuesta = false;

			$.ajax({
				url:  base_url + 'checador/Main_controller/edit_register_control',
				type:  'post',
				data: $(form).serialize(),
				success: function(respuesta){
					if(respuesta){
						window.location.href = base_url+'register';
					}
					else{
						$('#edit_message').removeClass('hide');
						$('#edit_message').addClass('animated fadeIn');
					}
				},
				error:  function(xhr,err){ 
					console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
				}
			});
		}
	});

	$('#form_editar_usuario').validate({
		rules: {
			admin_password: {
				required: true,
				remote: {
					url: base_url + "checador/Main_controller/check_admin_hash",
					type: "post",
					data: {
						admin_password: function() {
							return $( "#admin_password" ).val();
						}
					}
				}
			},
			password2: {
				equalTo: "#password1"
			},
		},
		messages: {
			admin_password: {
				required: "Ingrese su clave.",
				remote: "La clave es incorrecta."
			},
			password2: {
				required: "Ingrese la clave nuevamente.",
				equalTo: "La clave no coincide."
			},
		},
		submitHandler: function(form) {
			var respuesta = false;

			$.ajax({
				url:  base_url + 'checador/Main_controller/edit_user_control',
				type:  'post',
				data: $(form).serialize(),
				success: function(respuesta){
					if(respuesta){
						window.location.href = base_url+'users';
					}
					else{
						$('#edit_message').removeClass('hide');
						$('#edit_message').addClass('animated fadeIn');
					}
				},
				error:  function(xhr,err){ 
					console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
				}
			});
		}
	});

	$('#delete_user_form').validate({
		rules: {
			password_admin: {
				required: true,
				remote: {
					url: "checador/Main_controller/check_admin_hash",
					type: "post",
					data: {
						admin_password: function() {
							return $( "#password_admin" ).val();
						}
					}
				}
			}
		},
		messages: {
			password_admin: {
				required: "Ingrese su clave.",
				remote: "La clave no coincide."
			}
		},
		submitHandler: function(form) {
			var respuesta = false;

			$.ajax({
				url:  base_url + 'checador/Main_controller/delete_user',
				type:  'post',
				data: $(form).serialize(),
				success: function(respuesta){
					if(respuesta){
						window.location.href = "users";
					}
					else{
						$('#delete_message').html('Ha ocurrido un error, por favor intente nuevamente.');
						$('#delete_message').removeClass('hide');
						$('#delete_message').addClass('animated fadeIn');

						$('#password_admin').val('');
						Materialize.updateTextFields();
					}
				},
				error:  function(xhr,err){ 
					console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
				}
			});
		}
	});

	$('#delete_register_form').validate({
		rules: {
			password_admin: {
				required: true,
				remote: {
					url: "checador/Main_controller/check_admin_hash",
					type: "post",
					data: {
						admin_password: function() {
							return $( "#password_admin" ).val();
						}
					}
				}
			}
		},
		messages: {
			password_admin: {
				required: "Ingrese su clave.",
				remote: "La clave no coincide."
			}
		},
		submitHandler: function(form) {
			var respuesta = false;

			$.ajax({
				url:  base_url + 'checador/Main_controller/delete_register',
				type:  'post',
				data: $(form).serialize(),
				success: function(respuesta){
					if(respuesta){
						window.location.href = "panel";
					}
					else{
						$('#delete_message').html('Ha ocurrido un error, por favor intente nuevamente.');
						$('#delete_message').removeClass('hide');
						$('#delete_message').addClass('animated fadeIn');

						$('#password_admin').val('');
						Materialize.updateTextFields();
					}
				},
				error:  function(xhr,err){ 
					console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
				}
			});
		}
	});

	$('#form_changep').validate({
		rules: {
			password_confirmation: {
				equalTo: "#password"
			}
		},
		messages: {
			password_confirmation: {
				required: "Ingrese su clave nuevamente.",
				equalTo: "La clave no coincide."
			}
		},
		submitHandler: function(form) {
			var respuesta = false;

			$.ajax({
				url:  base_url + 'checador/Main_controller/change_password',
				type:  'post',
				data: $(form).serialize(),
				success: function(respuesta){
					if(respuesta){
						window.location.href = "users";
					}
					else{
						$('#change_message').html('Ha ocurrido un error, por favor intente nuevamente.');
						$('#change_message').removeClass('hide');
						$('#change_message').addClass('animated fadeIn');

						$('#password').val('');
						$('#password_confirmation').val('');
						Materialize.updateTextFields();
					}
				},
				error:  function(xhr,err){ 
					console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
				}
			});
		}
	});

}

function get_home_data(){
	var month = document.getElementById("fecha_home_datatable").value;

	$.ajax({
		url:  base_url + 'checador/Main_controller/home_table_data',
		type:  'post',
		data: {'month': month},
		success: function(respuesta){
			$('#dataTable').DataTable().destroy();

			if(respuesta){
				$('#home_data').html(respuesta);

				if(!$('#data_table_error').hasClass('hide')){
					$('#data_table_error').addClass('hide');
				}
			}
			else{
				$('#home_data').html('');
				$('#data_table_error').removeClass('hide');
			}

			$('#dataTable').DataTable({
				dom: 'Bfrtip',
				"order": [[ 1, 'desc' ], [ 2, 'asc' ]],
				buttons: [
				{
					extend: 'excel',
					className: 'waves-effect waves-light btn',
					exportOptions: {
						columns: ':not(:last-child)'
					}
				}
				],
				language: {
					"sProcessing":     "Procesando...",
					"sLengthMenu":     "Mostrar _MENU_ registros",
					"sZeroRecords":    "No se encontraron resultados",
					"sEmptyTable":     "Ningún dato disponible en esta tabla",
					"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
					"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
					"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
					"sInfoPostFix":    "",
					"sSearch":         "Buscar:",
					"sUrl":            "",
					"sInfoThousands":  ",",
					"sLoadingRecords": "Cargando...",
					"oPaginate": {
						"sFirst":    "Primero",
						"sLast":     "Último",
						"sNext":     "Siguiente",
						"sPrevious": "Anterior"
					},
					"oAria": {
						"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
						"sSortDescending": ": Activar para ordenar la columna de manera descendente"
					}
				}
			});

			var datatable = $('#dataTable').DataTable();
			datatable.columns.adjust().draw();

			$('#dataTable_filter').addClass('col m4 s12');
			$('.tooltipped').tooltip({delay: 50});
		},
		error:  function(xhr,err){ 
			console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
		}
	});
}

function get_users_data(){
	$.ajax({
		url:  base_url + 'checador/Main_controller/users_table_data',
		type:  'post',
		success: function(respuesta){
			$('#users_dataTable').DataTable().destroy();

			if(respuesta){
				$('#users_data').html(respuesta);

				if(!$('#data_table_error').hasClass('hide')){
					$('#data_table_error').addClass('hide');
				}
			}
			else{
				$('#users_data').html('');
				$('#data_table_error').removeClass('hide');
			}

			$('#users_dataTable').DataTable({
				dom: 'Bfrtip',
				buttons: [
				{
					extend: 'excel',
					className: 'waves-effect waves-light btn',
					exportOptions: {
						columns: ':not(:last-child)'
					}
				}
				],
				language: {
					"sProcessing":     "Procesando...",
					"sLengthMenu":     "Mostrar _MENU_ registros",
					"sZeroRecords":    "No se encontraron resultados",
					"sEmptyTable":     "Ningún dato disponible en esta tabla",
					"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
					"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
					"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
					"sInfoPostFix":    "",
					"sSearch":         "Buscar:",
					"sUrl":            "",
					"sInfoThousands":  ",",
					"sLoadingRecords": "Cargando...",
					"oPaginate": {
						"sFirst":    "Primero",
						"sLast":     "Último",
						"sNext":     "Siguiente",
						"sPrevious": "Anterior"
					},
					"oAria": {
						"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
						"sSortDescending": ": Activar para ordenar la columna de manera descendente"
					}
				}
			});

			var datatable = $('#users_dataTable').DataTable();
			datatable.columns.adjust().draw();

			$('#dataTable_filter').addClass('col m4 s12');
			$('.tooltipped').tooltip({delay: 50});
		},
		error:  function(xhr,err){ 
			console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
		}
	});
}

function set_graphs(){
	var month = document.getElementById("fecha_periodo").value;

	$.ajax({
		url:  base_url + 'checador/Main_controller/get_graph_registros_dia',
		type:  'post',
		data: {'month': month},
		success: function(respuesta){
			var dataset2 = JSON.parse(respuesta);

			var nombre_mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

			var ctx = document.getElementById("registros-dia").getContext('2d');
			registros_dia = new Chart(ctx, {
				type: 'line',
				data: {
					labels: dataset2[0],
					datasets: [{
						label: 'Numero de registros',
						data: dataset2[1],
						backgroundColor: [
						'rgba(54, 162, 235, 0.2)'
						],
						borderColor: [
						'rgba(54, 162, 235, 1)'
						],
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true,
								min: 0,
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Registros'
								}
							}
						}]
					},
					tooltips: {
						position: 'nearest',
						mode: 'index',
						intersect: false,
						callbacks: {
							label: function(tooltipItem, data) {
								var label = data.datasets[tooltipItem.datasetIndex].label || '';

								if (label) {
									label += ': ' + tooltipItem.yLabel;
								}
								return label;
							},
							title: function(tooltipItem, data) {
								var label = tooltipItem[0].xLabel + ' de ' + nombre_mes[month-1];
								return label;
							}
						}
					}
				}
			});
		},
		error:  function(xhr,err){ 
			console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
		}
	});

	$.ajax({
		url:  base_url + 'checador/Main_controller/get_graph_horas_dia',
		type:  'post',
		data: {'month': month},
		success: function(respuesta){
			var dataset2 = JSON.parse(respuesta);

			var nombre_mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

			var ctx = document.getElementById("horas-dia").getContext('2d');
			horas_dia = new Chart(ctx, {
				type: 'line',
				data: {
					labels: dataset2[0],
					datasets: [{
						label: 'Horas trabajadas',
						data: dataset2[1],
						backgroundColor: [
						'rgba(54, 162, 235, 0.2)'
						],
						borderColor: [
						'rgba(54, 162, 235, 1)'
						],
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true,
								min: 0,
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Horas'
								}
							}
						}]
					},
					tooltips: {
						position: 'nearest',
						mode: 'index',
						intersect: false,
						callbacks: {
							label: function(tooltipItem, data) {
								var label = data.datasets[tooltipItem.datasetIndex].label || '';

								if (label) {
									label += ': ' + tooltipItem.yLabel;
								}
								return label;
							},
							title: function(tooltipItem, data) {
								var label = tooltipItem[0].xLabel + ' de ' + nombre_mes[month-1];
								return label;
							}
						}
					}
				}
			});
		},
		error:  function(xhr,err){ 
			console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
		}
	});

	$.ajax({
		url:  base_url + 'checador/Main_controller/get_graph_horas_usuario',
		type:  'post',
		data: {'month': month},
		success: function(respuesta){
			var dataset2 = JSON.parse(respuesta);

			var ctx = document.getElementById('horas-usuario').getContext('2d');
			horas_usuario = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: [dataset2[0]],
					datasets: dataset2[1]
				},
				options: {
					responsive: true,
					legend: {
						position: 'bottom',
					},
					scales:{
						yAxes:[{
							ticks:{
								beginAtZero:true,
								min: 0
							}
						}]
					}
				}
			});
		},
		error:  function(xhr,err){ 
			console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
		}
	});
}

function actualizar_graphs(){
	var month = document.getElementById("fecha_periodo").value;
	var usuario = document.getElementById("usuarios_reporte").value;

	if(usuario=='0'){
		$.ajax({
			url:  base_url + 'checador/Main_controller/get_graph_registros_dia',
			type:  'post',
			data: {'month': month},
			success: function(respuesta){
				var dataset2 = JSON.parse(respuesta);

				registros_dia.destroy();

				var nombre_mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

				var ctx = document.getElementById("registros-dia").getContext('2d');
				registros_dia = new Chart(ctx, {
					type: 'line',
					data: {
						labels: dataset2[0],
						datasets: [{
							label: 'Numero de registros',
							data: dataset2[1],
							backgroundColor: [
							'rgba(54, 162, 235, 0.2)'
							],
							borderColor: [
							'rgba(54, 162, 235, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero:true,
									min: 0,
									display: true,
									scaleLabel: {
										display: true,
										labelString: 'Registros'
									}
								}
							}]
						},
						tooltips: {
							position: 'nearest',
							mode: 'index',
							intersect: false,
							callbacks: {
								label: function(tooltipItem, data) {
									var label = data.datasets[tooltipItem.datasetIndex].label || '';

									if (label) {
										label += ': ' + tooltipItem.yLabel;
									}
									return label;
								},
								title: function(tooltipItem, data) {
									var label = tooltipItem[0].xLabel + ' de ' + nombre_mes[month-1];
									return label;
								}
							}
						}
					}
				});
			},
			error:  function(xhr,err){ 
				console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
			}
		});

		$.ajax({
			url:  base_url + 'checador/Main_controller/get_graph_horas_dia',
			type:  'post',
			data: {'month': month},
			success: function(respuesta){
				var dataset2 = JSON.parse(respuesta);

				horas_dia.destroy();

				var nombre_mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

				var ctx = document.getElementById("horas-dia").getContext('2d');
				horas_dia = new Chart(ctx, {
					type: 'line',
					data: {
						labels: dataset2[0],
						datasets: [{
							label: 'Horas trabajadas',
							data: dataset2[1],
							backgroundColor: [
							'rgba(54, 162, 235, 0.2)'
							],
							borderColor: [
							'rgba(54, 162, 235, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero:true,
									min: 0,
									display: true,
									scaleLabel: {
										display: true,
										labelString: 'Horas'
									}
								}
							}]
						},
						tooltips: {
							position: 'nearest',
							mode: 'index',
							intersect: false,
							callbacks: {
								label: function(tooltipItem, data) {
									var label = data.datasets[tooltipItem.datasetIndex].label || '';

									if (label) {
										label += ': ' + tooltipItem.yLabel;
									}
									return label;
								},
								title: function(tooltipItem, data) {
									var label = tooltipItem[0].xLabel + ' de ' + nombre_mes[month-1];
									return label;
								}
							}
						}
					}
				});
			},
			error:  function(xhr,err){ 
				console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
			}
		});

		$.ajax({
			url:  base_url + 'checador/Main_controller/get_graph_horas_usuario',
			type:  'post',
			data: {'month': month},
			success: function(respuesta){
				var dataset2 = JSON.parse(respuesta);

				horas_usuario.destroy();

				var ctx = document.getElementById('horas-usuario').getContext('2d');
				horas_usuario = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: [dataset2[0]],
						datasets: dataset2[1]
					},
					options: {
						responsive: true,
						legend: {
							position: 'bottom',
						},
						scales:{
							yAxes:[{
								ticks:{
									beginAtZero:true,
									min: 0
								}
							}]
						}
					}
				});
			},
			error:  function(xhr,err){ 
				console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
			}
		});
	}
	else{
		$.ajax({
			url:  base_url + 'checador/Main_controller/get_graph_horas_dia_usuario',
			type:  'post',
			data: {'month': month, 'usuario': usuario},
			success: function(respuesta){
				var dataset2 = JSON.parse(respuesta);

				if(horas_dia_usuario){
					horas_dia_usuario.destroy();
				}

				var nombre_mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

				var ctx = document.getElementById("horas-dia-usuario").getContext('2d');
				horas_dia_usuario = new Chart(ctx, {
					type: 'line',
					data: {
						labels: dataset2[0],
						datasets: [{
							label: 'Horas trabajadas',
							data: dataset2[1],
							backgroundColor: [
							'rgba(54, 162, 235, 0.2)'
							],
							borderColor: [
							'rgba(54, 162, 235, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero:true,
									min: 0,
									display: true,
									scaleLabel: {
										display: true,
										labelString: 'Horas'
									}
								}
							}]
						},
						tooltips: {
							position: 'nearest',
							mode: 'index',
							intersect: false,
							callbacks: {
								label: function(tooltipItem, data) {
									var label = data.datasets[tooltipItem.datasetIndex].label || '';

									if (label) {
										label += ': ' + tooltipItem.yLabel;
									}
									return label;
								},
								title: function(tooltipItem, data) {
									var label = tooltipItem[0].xLabel + ' de ' + nombre_mes[month-1];
									return label;
								}
							}
						}
					}		
				});

				$('#total-horas-trabajadas').html(dataset2[2] + ' Horas');
			},
			error:  function(xhr,err){ 
				console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
			}
		});

		// $.ajax({
		// 	url:  base_url + 'checador/Main_controller/get_graph_horario_usuario',
		// 	type:  'post',
		// 	data: {'month': month, 'usuario': usuario},
		// 	success: function(respuesta){
		// 		var data = JSON.parse(respuesta);

		// 		Highcharts.chart('horario_usuario', {
		// 			chart: {
		// 				type: 'arearange',
		// 				zoomType: 'x',
		// 				scrollablePlotArea: {
		// 					minWidth: 600,
		// 					scrollPositionX: 1
		// 				}
		// 			},

		// 			title: {
		// 				text: 'Horario de asistencia por día'
		// 			},
		// 			xAxis: {
		// 				type: 'datetime',
		// 				labels: {
		// 					format: '{value:%Y-%b-%e}'
		// 				},
		// 			},
		// 			yAxis: {
		// 				title: {
		// 					text: null
		// 				},
		// 				type: 'datetime',
		// 				dateTimeLabelFormats: {
		// 					second: '%H:%M:%S',
		// 					minute: '%H:%M:%S',
		// 					hour: '%H:%M:%S',
		// 					day: '%H:%M:%S',
		// 					week: '%H:%M:%S',
		// 					month: '%H:%M:%S',
		// 					year: '%H:%M:%S'
		// 				}
		// 			},
		// 			tooltip: {
		// 				crosshairs: true,
		// 				shared: true,
		// 				valueSuffix: 'hrs',
		// 				xDateFormat: '%Y-%m-%d',
		// 				formatter: function() {
		// 					//console.log(this);
		// 					if(this.points[0].point.low == this.points[0].point.high){
		// 						return 'El día <b>' + Highcharts.dateFormat('%Y/%m/%d', this.x) +'</b><br/> No asistió';
		// 					}
		// 					else{
		// 						return 'El día <b>' + Highcharts.dateFormat('%Y/%m/%d', this.x) +'</b><br/> Asistió de las '+ Highcharts.dateFormat('%H:%M:%S', this.points[0].point.low) + ' a las '+ Highcharts.dateFormat('%H:%M:%S', this.points[0].point.high);
		// 					}
		// 				}
		// 			},
		// 			legend: {
		// 				enabled: false
		// 			},
		// 			series: [{
		// 				name: 'Horario',
		// 				data: data
		// 			}]
		// 		});
		// 	},
		// 	error:  function(xhr,err){ 
		// 		console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
		// 	}
		// });
		
	}
}