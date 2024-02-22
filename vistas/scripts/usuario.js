var tabla_usuario;
var modoDemo = false;
//Función que se ejecuta al inicio
function init() {

	listar();
	// ══════════════════════════════════════ S E L E C T 2 ══════════════════════════════════════  
	lista_select2("../ajax/usuario.php?op=select2persona", '#id_persona', null);
	// ══════════════════════════════════════ INITIALIZE SELECT2 ══════════════════════════════════════

	// ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
	$("#guardar_registro_usuario").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-usuario").submit(); } });

	// ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T 2 ══════════════════════════════════════
	$("#id_persona").select2({ dropdownParent: $('#modal-agregar-usuario'), templateResult: formatStateTrabajador, theme: "bootstrap4", placeholder: "Selecione trabajador", allowClear: true, });

	$("#tipo_documento").select2({ dropdownParent: $('#modal-agregar-usuario'), theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
	$("#cargo").select2({ dropdownParent: $('#modal-agregar-usuario'), theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });


	$.post("../ajax/usuario.php?op=permisos&id=", function (r) { $("#permisos").html(r); });
}

function formatStateTrabajador(state) {
	//console.log(state);
	if (!state.id) { return state.text; }
	var baseUrl = state.title != '' ? `../assets/modulo/persona/${state.title}` : '../assets/modulo/usuario/perfil/no-perfil.jpg';
	var onerror = `onerror="this.src='../assets/modulo/usuario/perfil/no-perfil.jpg;"`;
	var $state = $(`<span><img src="${baseUrl}" class="img-circle mr-2 w-25px" ${onerror} />${state.text}</span>`);
	return $state;
};

// Captura del atributo 'data-atributo' de la opción seleccionada
function capt_cargo() {
	$('#id_persona').change(function () {
		 $(".cargo_persona_edit").hide();
		$(".cargo_persona").show();
		$('.cargo_persona').val("");
		$('.cargo_persona').val($(this).find('option:selected').attr('cargo'));

	});
}

//Función limpiar
function limpiar_form() {

	$("#login").val("");
	$("#clave").val("");
	$("#id_persona").val("").trigger("change");

	$.post("../ajax/usuario.php?op=permisos&id=", function (r) { $("#permisos").html(r); });

	// Limpiamos las validaciones
	$(".form-control").removeClass('is-valid');
	$(".form-control").removeClass('is-invalid');
	$(".error.invalid-feedback").remove();

}

// $("#imagenmuestra").css("display", "block");


//Función Listar
function listar() {
	tabla_usuario = $('#tabla-usuario').dataTable({
		lengthMenu: [[-1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200,]],//mostramos el menú de registros a revisar
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: "<'row'<'col-md-3'B><'col-md-3 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
		buttons: [
			{ text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload btn btn-outline-info btn-wave ", action: function (e, dt, node, config) { if (tabla_usuario) { tabla_usuario.ajax.reload(null, false); } } },
			{ extend: 'copy', exportOptions: { columns: [1, 2, 3, 4, 5, 6], }, text: `<i class="fas fa-copy" ></i>`, className: "btn btn-outline-dark btn-wave ", footer: true, },
			{ extend: 'excel', exportOptions: { columns: [1, 2, 3, 4, 5, 6], }, title: 'Lista de usuarios', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "btn btn-outline-success btn-wave ", footer: true, },
			{ extend: 'pdf', exportOptions: { columns: [1, 2, 3, 4, 5, 6], }, title: 'Lista de usuarios', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "btn btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL', },
			{ extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "btn btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
		],
		"ajax": {
			url: '../ajax/usuario.php?op=listar',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			},
			complete: function () {
				$(".buttons-reload").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Recargar');
				$(".buttons-copy").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Copiar');
				$(".buttons-excel").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Excel');
				$(".buttons-pdf").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'PDF');
				$(".buttons-colvis").attr('data-bs-toggle', 'tooltip').attr('data-bs-original-title', 'Columnas');
				$('[data-bs-toggle="tooltip"]').tooltip();
			},
		},
		language: {
			lengthMenu: "Mostrar: _MENU_ registros",
			buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
			sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[2, "desc"]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardar_y_editar_usuario(e) {
	//e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#form-agregar-usuario")[0]);
	$.ajax({
		url: "../ajax/usuario.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (e) {
			try {
				e = JSON.parse(e);  //console.log(e); 
				if (e.status == true) {
					tabla_usuario.ajax.reload();
					limpiar_form();
					$('#modal-agregar-usuario').modal('hide');
					sw_success('Exito', 'Usuario guardado correctamente.');
				} else {
					ver_errores(jqXhr);
				}
			} catch (err) { console.log('Error: ', err.message); toastr_error("Error temporal!!", 'Puede intentalo mas tarde, o comuniquese con:<br> <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>', 700); }
			$("#guardar_registro_usuario").html('Guardar Cambios').removeClass('disabled send-data');
		},
		xhr: function () {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function (evt) {
				if (evt.lengthComputable) {
					var percentComplete = (evt.loaded / evt.total) * 100;
					/*console.log(percentComplete + '%');*/
					$("#barra_progress_usuario").css({ "width": percentComplete + '%' });
					$("#barra_progress_usuario div").text(percentComplete.toFixed(2) + " %");
				}
			}, false);
			return xhr;
		},

		beforeSend: function () {
			$("#guardar_registro_usuario").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled send-data');
			$("#barra_progress_usuario").css({ width: "0%", });
			$("#barra_progress_usuario div").text("0%");
		},
		complete: function () {
			$("#barra_progress_usuario").css({ width: "0%", });
			$("#barra_progress_usuario div").text("0%");
		},
		error: function (jqXhr, ajaxOptions, thrownError) {
			ver_errores(jqXhr);
		}
	});

}


function mostrar(idusuario) {

	$('#modal-agregar-usuario').modal('show');
	$('#cargando-1-fomulario').hide(); $('#cargando-2-fomulario').show();
	$('#cargando-3-fomulario').hide(); $('#cargando-4-fomulario').show();

	$(".cargo_persona_edit").show(); $(".cargo_persona").hide();

	$.post("../ajax/usuario.php?op=mostrar", { idusuario: idusuario }, function (e, status) {
		e = JSON.parse(e); console.log(e);
		$(".trabajador-name").html(` <i class="fas fa-users-cog fa-xl text-primary"></i> <b class="texto-parpadeante font-size-20px">${e.data.nombres}</b> `);

		$('#idusuario').val(e.data.idusuario);
		$('#persona_old').val(e.data.idpersona);
		$('#password-old').val(e.data.password);
		$('.cargo_persona_edit').val(e.data.cargo);
		$("#login").val(e.data.login);

		$.post("../ajax/usuario.php?op=permisos&id=" + idusuario, function (r) {
			$("#permisos").html(r);
			$('#cargando-1-fomulario').show(); $('#cargando-2-fomulario').hide();
			$('#cargando-3-fomulario').show(); $('#cargando-4-fomulario').hide();
		});

	});
}

// //Función para desactivar registros
// function desactivar(idusuario) {
// 	if (modoDemo) {
// 		Swal.fire({
// 			icon: 'warning',
// 			title: 'Modo demo',
// 			text: 'No puedes editar o guardar en modo demo',
// 		});
// 		return;
// 	}
// 	$("#btnGuardar").prop("disabled", true);
// 	swal.fire({
// 		title: "¿Está seguro de desactivar el usuario?",
// 		icon: "warning",
// 		showCancelButton: true,
// 		confirmButtonColor: "#3085d6",
// 		cancelButtonColor: "#d33",
// 		confirmButtonText: "Sí, desactivar",
// 		cancelButtonText: "Cancelar"
// 	}).then((result) => {
// 		if (result.isConfirmed) {
// 			$.post("../ajax/usuario.php?op=desactivar", { idusuario: idusuario }, function (e) {
// 				swal.fire({
// 					title: "Usuario desactivado",
// 					text: e,
// 					icon: "success",
// 					showConfirmButton: false,
// 					timer: 1500
// 				});
// 				tabla_usuario.ajax.reload();
// 			});
// 		}
// 	});
// }

// //Función para activar registros
// function activar(idusuario) {
// 	swal.fire({
// 		title: "¿Está seguro de activar el usuario?",
// 		icon: "warning",
// 		showCancelButton: true,
// 		confirmButtonColor: "#3085d6",
// 		cancelButtonColor: "#d33",
// 		confirmButtonText: "Sí, activar",
// 		cancelButtonText: "Cancelar",
// 	}).then((result) => {
// 		if (result.isConfirmed) {
// 			$.post("../ajax/usuario.php?op=activar", { idusuario: idusuario }, function (e) {
// 				swal.fire({
// 					title: "Usuario activado",
// 					text: e,
// 					icon: "success",
// 					showConfirmButton: false,
// 					timer: 1500
// 				});
// 				tabla_usuario.ajax.reload();
// 			});
// 		}
// 	});
// }

//Función para desactivar y eliminar registros
function eliminar(idusuario, nombre) {
	crud_eliminar_papelera(
		"../ajax/usuario.php?op=desactivar",
		"../ajax/usuario.php?op=delete",
		idusuario,
		"!Elija una opción¡",
		`<b class="text-danger"><del>${nombre}</del></b> <br> En <b>papelera</b> encontrará este registro! <br> Al <b>eliminar</b> no tendrá acceso a recuperar este registro!`,
		function () { sw_success('♻️ Papelera! ♻️', "Tu registro ha sido reciclado.") },
		function () { sw_success('Eliminado!', 'Tu registro ha sido Eliminado.') },
		function () { tabla_usuario.ajax.reload(null, false); },
		false,
		false,
		false,
		false
	);

}




function mayus(e) {
	e.value = e.value.toUpperCase();
}

function cambiarImagen() {
	var imagenInput = document.getElementById('imagen');
	imagenInput.click();
}

function removerImagen() {
	var imagenMuestra = document.getElementById('imagenmuestra');
	var imagenActualInput = document.getElementById('imagenactual');
	imagenMuestra.src = '../assets/images/faces/9.jpg';
	imagenActualInput.value = '';
}

// // Esto se encarga de mostrar la imagen cuando se selecciona una nueva
// document.addEventListener('DOMContentLoaded', function () {
// 	var imagenMuestra = document.getElementById('imagenmuestra');
// 	var imagenInput = document.getElementById('imagen');

// 	imagenInput.addEventListener('change', function () {
// 		if (imagenInput.files && imagenInput.files[0]) {
// 			var reader = new FileReader();

// 			reader.onload = function (e) {
// 				imagenMuestra.src = e.target.result;
// 			}

// 			reader.readAsDataURL(imagenInput.files[0]);
// 		}
// 	});
// });


$(document).ready(function () {
	$('#tipo_documento').change(function () {
		if ($(this).val() == 'DNI') {
			$('#num_documento').focus(); // Asumiendo que tu input para ingresar el número tiene el id 'num_documento'.
		}
	});
});

$('#num_documento').keypress(function (e) {
	if (e.which == 13) { // 13 es el código de tecla para Enter
		var numero = $(this).val();
		if (numero) { // verifica si el número no está vacío
			consultaDniSunat(numero);
		} else {
			toastr_warning('Vacio!!', 'El numero de documento esta vacio, porfavor ingresa un numero.');
		}
	}
});


function consultaDniSunat(numero) {
	var dni_ruc = numero == '' || numero == null ? $('#num_documento').val() : numero;
	$('#icon-search-sr').html(`<i class='bx bx-loader bx-spin fs-5' ></i>`);
	$.ajax({
		type: 'POST',
		url: "../ajax/ajax_general.php?op=reniec_otro&dni=" + dni_ruc,
		dataType: 'json',
		beforeSend: function () {
			// Aquí puedes mostrar un loader o similar
		},
		complete: function (data) {
			// Acciones después de completar la solicitud, por ejemplo, ocultar el loader
		},
		success: function (e) {
			console.log(e);
			if (e.status == true) {
				$("#num_documento").val(e.numeroDocumento);
				$('#nombre').val(e.nombres);
				$('#apellidos').val(e.apellidoPaterno + ' ' + e.apellidoMaterno);
			} else {
				ver_errores(e);
			}
			$('#icon-search-sr').html(`<i class='bx bx-search-alt fs-5'></i>`);
		},
		error: function (e) {
			console.log(e); toastr_error('Error!!', `Tenemos este error: ${e.statusText}`);
		}
	});
}

function ver_password(click) {
	var x = document.getElementById("clave");
	//var y = document.getElementById("confirm_password");
	if (x.type === "password") {
		x.type = "text";
		//y.type = "text"; 
		$('#icon-view-password').html(`<i class="fa-solid fa-eye-slash text-white"></i>`);
		$(click).attr('data-original-title', 'Ocultar contraseña');
	} else {
		x.type = "password";
		//y.type = "password";  
		$('#icon-view-password').html(`<i class="fa-solid fa-eye text-white"></i>`);
		$(click).attr('data-original-title', 'Ver contraseña');
	}

	$('[data-toggle="tooltip"]').tooltip();
}

$(document).ready(function () {
	init();
});

// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function () {
	$('#cargo').on('change', function () { $(this).trigger('blur'); });
	$("#form-agregar-usuario").validate({
		ignore: "",
		rules: {
			clave: { required: true, },
			login: {
				required: true, minlength: 4, maxlength: 20,
				remote: {
					url: "../ajax/usuario.php?op=validar_usuario",
					type: "get",
					data: {
						action: function () { return "checkusername"; },
						username: function () { var username = $("#login").val(); return username; },
						idusuario: function () { var idusuario = $("#idusuario").val(); return idusuario; }
					}
				}
			},
		},
		messages: {
			login: { required: "Campo requerido", remote: "Usuario en uso." },
			clave: { required: "Campo requerido", },
		},

		errorElement: "span",

		errorPlacement: function (error, element) {
			error.addClass("invalid-feedback");
			element.closest(".form-group").append(error);
		},

		highlight: function (element, errorClass, validClass) {
			$(element).addClass("is-invalid").removeClass("is-valid");
		},

		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass("is-invalid").addClass("is-valid");
		},
		submitHandler: function (e) {
			$(".modal-body").animate({ scrollTop: $(document).height() }, 600); // Scrollea hasta abajo de la página
			guardar_y_editar_usuario(e);
		},
	});
	$('#cargo').rules('add', { required: true, messages: { required: "Campo requerido" } });
});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..
