Pace.on('done', function(){
	startTime();
	init();
	update_last_register();
});

function startTime() {
	var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();
	m = checkTime(m);
	s = checkTime(s);
	document.getElementById('hora').innerHTML =
	h + ":" + m + ":" + (s);
	var t = setTimeout(startTime, 1000);
}

function checkTime(i) {
	if (i < 10) {i = "0" + i};
	return i;
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

function registrar_actividad(id, nombre) {
	var last_id = document.getElementById("clave_trabajador").value;

	if(last_id != id){
		$("#nombre_trabajador").html(nombre);
		$('#clave_trabajador').val(id);
		$('#actividad').val('');
		$('#actividad').trigger('autoresize');
		Materialize.updateTextFields();
	}

	$("#checkout_activity").modal('open');
}

function show_login(){
	$('#login_message').addClass('hide');
	$("#login_modal").modal('open');
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

	$("#clave").keyup(function(){
		$('#register_form').submit();
	});

	$('#register_form').validate({
		rules: {
			clave: {
				required: true,
				remote: {
					url: "checador/Main_controller/check_hash",
					type: "post",
					data: {
						password: function() {
							return $( "#clave" ).val();
						}
					}
				}
			}
		},
		messages: {
			clave: {
				required: "Ingrese su clave.",
				remote: "La clave no coincide con ningun usuario."
			}
		},
		submitHandler: function(form) {
			var respuesta = false;

			$.ajax({
				url:  base_url + 'checador/Main_controller/register_hash',
				type:  'post',
				data: $(form).serialize(),
				success: function(respuesta){
					var register_response = JSON.parse(respuesta);

					switch(register_response.type){
						case 1:
						$('#last-insert').removeClass('animated fadeInUp');
						update_last_register();
						break;

						case 2:
						var clave = document.getElementById("clave").value;
						var name = '';

						$.ajax({
							url:  base_url + 'checador/Main_controller/get_username',
							type:  'post',
							data: {'clave': clave},
							success: function(respuesta){
								if(respuesta){
									registrar_actividad(clave, respuesta);
								}
							},
							error:  function(xhr,err){ 
								console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
							}
						});

						break;

						default:
						$('#register_submit_message').html(register_response.message);
						$('#register_submit_message').removeClass('hide');
						$('#register_submit_message').addClass('animated fadeIn');
						break;
					}
					
					$('#clave').val('');
					Materialize.updateTextFields();
				},
				error:  function(xhr,err){ 
					console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
				}
			});
		}
	});

	$('#agregar_actividad_form').validate({
		submitHandler: function(form) {
			var respuesta = false;

			$.ajax({
				url:  base_url + 'checador/Main_controller/checkout',
				type:  'post',
				data: $(form).serialize(),
				success: function(respuesta){
					if(respuesta){
						$('#last-insert').removeClass('animated fadeInUp');
						update_last_register();

						form.reset();
						Materialize.updateTextFields();
						$("#checkout_activity").modal('close');
					}
					else{
						$('#register_submit_message').html('Ha ocurrido un error en el servidor, por favor intente nuevamente.');
						$('#register_submit_message').removeClass('hide');
						$('#register_submit_message').addClass('animated fadeIn');
					}

					$('#clave').val('');
					Materialize.updateTextFields();
				},
				error:  function(xhr,err){ 
					console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
				}
			});
		}
	});

	$('#login_form').validate({
		rules: {
			admin_password: {
				required: true,
				remote: {
					url: "checador/Main_controller/check_admin_hash",
					type: "post",
					data: {
						password: function() {
							return $( "#clave" ).val();
						}
					}
				}
			}
		},
		messages: {
			clave: {
				required: "Ingrese su clave.",
				remote: "La clave es incorrecta."
			}
		},
		submitHandler: function(form) {
			var respuesta = false;

			$.ajax({
				url:  base_url + 'checador/Main_controller/login_auth',
				type:  'post',
				data: $(form).serialize(),
				success: function(respuesta){
					if(respuesta){
						window.location.href = base_url+'panel';
					}
					else{
						form.reset();
						Materialize.updateTextFields();
						$('#login_message').removeClass('hide');
					}
				},
				error:  function(xhr,err){ 
					console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
				}
			});
		}
	});

}

function update_last_register(){
	$.ajax({
		url:  base_url + 'checador/Main_controller/last_register_data',
		success: function(respuesta){
			if(respuesta){
				$('#last-insert').removeClass('hide');
				$('#last-insert').addClass('animated fadeInUp');
				$('#last-insert-data').html(respuesta);
			}
			else{
				$('#last-insert').addClass('hide');
				$('#last-insert').removeClass('animated fadeInUp');
				$('#last-insert-data').html('');
			}

			$('#register_submit_message').html('');
			$('#register_submit_message').removeClass('animated fadeIn');
			$('#register_submit_message').addClass('hide');
		},
		error:  function(xhr,err){ 
			console.log("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
		}
	});
}