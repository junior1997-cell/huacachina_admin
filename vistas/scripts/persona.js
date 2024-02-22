var tabla_persona;
var modoDemo = false;
//Función que se ejecuta al inicio
function init() {

	listar();

	// ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#guardar_registro_persona").on("click", function (e) { if ( $(this).hasClass('send-data')==false) { $("#submit-form-persona").submit(); }  });

  // ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T 2 ══════════════════════════════════════
  $("#tipo_documento").select2({dropdownParent: $('#modal-agregar-persona'), theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });
  $("#cargo").select2({dropdownParent: $('#modal-agregar-persona'),  theme: "bootstrap4", placeholder: "Seleccione", allowClear: true, });

	$("#imagenmuestra").hide();

}

//Función limpiar
function limpiar_form() {
	$("#nombres").val("");
	// $("#apellidos").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#cargo").val("").trigger("change");
	$("#edad").val("");
	$(".edad").html("");
	$("#nacimiento").val("");	
	$("#tipo_documento").val("");

  $("#imagen").val("");
  $("#imagenactual").val("");
  $("#imagenmuestra").attr("src", "../assets/modulo/usuario/perfil/no-perfil.jpg");
  $("#imagenmuestra").attr("src", "../assets/modulo/usuario/perfil/no-perfil.jpg").show();
  var imagenMuestra = document.getElementById('imagenmuestra');
  if (!imagenMuestra.src || imagenMuestra.src == "") {
    imagenMuestra.src = '../assets/modulo/usuario/perfil/no-perfil.jpg';
  }

  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();
}

$("#imagenmuestra").css("display", "block");


//Función Listar
function listar() {
	tabla_persona = $('#tabla-persona').dataTable({
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom:"<'row'<'col-md-3'B><'col-md-3 float-left'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",//Definimos los elementos del control de tabla
    buttons: [
      { text: '<i class="fa-solid fa-arrows-rotate"></i> ', className: "buttons-reload btn btn-outline-info btn-wave ", action: function ( e, dt, node, config ) { if (tabla_persona) { tabla_persona.ajax.reload(null, false); } } },
      { extend: 'copy', exportOptions: { columns: [1,2,3,4,5,6], }, text: `<i class="fas fa-copy" ></i>`, className: "btn btn-outline-dark btn-wave ", footer: true,  }, 
      { extend: 'excel', exportOptions: { columns: [1,2,3,4,5,6], }, title: 'Lista de usuarios', text: `<i class="far fa-file-excel fa-lg" ></i>`, className: "btn btn-outline-success btn-wave ", footer: true,  }, 
      { extend: 'pdf', exportOptions: { columns: [1,2,3,4,5,6], }, title: 'Lista de usuarios', text: `<i class="far fa-file-pdf fa-lg"></i>`, className: "btn btn-outline-danger btn-wave ", footer: false, orientation: 'landscape', pageSize: 'LEGAL',  },
      { extend: "colvis", text: `<i class="fas fa-outdent"></i>`, className: "btn btn-outline-primary", exportOptions: { columns: "th:not(:last-child)", }, },
    ],
		"ajax":	{
			url: '../ajax/persona.php?op=listar',
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
function guardar_y_editar_persona(e) {
	//e.preventDefault(); //No se activará la acción predeterminada del evento
	if (modoDemo) {
		sw_warning('Modo demo', 'No puedes editar o guardar en modo demo');		
		return;
	}

	// Validar el campo de contraseña
	var clave = $('#clave').val();
	if (clave == '') {
		Swal.fire({
			icon: 'warning',
			title: 'Contraseña requerida',
			text: 'Para validar tus cambios, ingresa tu contraseña actual',
		});
		return;
	}

	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#form-agregar-persona")[0]);

	$.ajax({
		url: "../ajax/persona.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (e) {
			try {
				e = JSON.parse(e);  //console.log(e); 
        if (e.status == true) {	
					tabla_persona.ajax.reload();
					$('#modal-agregar-persona').modal('hide');
					sw_success('Exito', 'Usuario guardado correctamente.');
				} else {
					ver_errores(jqXhr);
				}				
			} catch (err) { console.log('Error: ', err.message); toastr_error("Error temporal!!",'Puede intentalo mas tarde, o comuniquese con:<br> <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>', 700); }      
		},
		error: function (jqXhr, ajaxOptions, thrownError) {
			ver_errores(jqXhr);
		}
	});

}

function mostrar(idpersona) {
	limpiar_form()
	$('#modal-agregar-persona').modal('show');
	$.post("../ajax/persona.php?op=mostrar", { idpersona: idpersona }, function (e, status) {
		e = JSON.parse(e);
console.log(e);
		$("#nombres").val(e.data.nombres);
		// $("#tipo_documento").append('<option value="' + e.data.tipo_documento + '">' + e.data.tipo_documento + '</option>');
		$("#tipo_documento").val(e.data.tipo_documento).trigger("change"); 
		//$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(e.data.numero_documento);
		$("#direccion").val(e.data.direccion);
		$("#telefono").val(e.data.celular);
		$("#email").val(e.data.correo);
		$("#cargo").val(e.data.idcargo_trabajador).trigger("change"); 
		$("#nacimiento").val(e.data.fecha_nacimiento);
		$("#edad").val(e.data.edad);
		$(".edad").html(e.data.edad);
		

		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src", "../assets/modulo/persona/" + e.data.foto_perfil);
		$("#imagenactual").val(e.data.foto_perfil);
		$("#idpersona").val(e.data.idpersona);

	});	
}

//Función para desactivar y eliminar registros
function eliminar(idpersona, nombre ) {
  crud_eliminar_papelera(
    "../ajax/persona.php?op=desactivar",
    "../ajax/persona.php?op=delete", 
    idpersona, 
    "!Elija una opción¡", 
    `<b class="text-danger"><del>${nombre}</del></b> <br> En <b>papelera</b> encontrará este registro! <br> Al <b>eliminar</b> no tendrá acceso a recuperar este registro!`, 
    function(){ sw_success('♻️ Papelera! ♻️', "Tu registro ha sido reciclado." ) }, 
    function(){ sw_success('Eliminado!', 'Tu registro ha sido Eliminado.' ) }, 
    function(){  tabla_persona.ajax.reload(null, false); },
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
	// var imagenMuestra = document.getElementById('imagenmuestra');
	// var imagenActualInput = document.getElementById('imagenactual');
	// var imagenInput = document.getElementById('imagen');
	// imagenMuestra.src = '../assets/images/faces/9.jpg';
	$("#imagenmuestra").attr("src", "../assets/images/faces/9.jpg");
	// imagenActualInput.value = '';
	// imagenInput.value = '';
	$("#imagen").val("");
  $("#imagenactual").val("");
}

// Esto se encarga de mostrar la imagen cuando se selecciona una nueva
document.addEventListener('DOMContentLoaded', function () {
	var imagenMuestra = document.getElementById('imagenmuestra');
	var imagenInput = document.getElementById('imagen');

	imagenInput.addEventListener('change', function () {
		if (imagenInput.files && imagenInput.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				imagenMuestra.src = e.target.result;
			}

			reader.readAsDataURL(imagenInput.files[0]);
		}
	});
});


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
		url: "../ajax/ajax_general.php?op=reniec_jdl",
		data: {dni:dni_ruc},
		dataType: 'json',
		beforeSend: function () {
			// Aquí puedes mostrar un loader o similar
		},
		complete: function (data) {			
			// Acciones después de completar la solicitud, por ejemplo, ocultar el loader
		},
		success: function (e) {
			console.log(e);
			if (e.success == true) {
				$("#num_documento").val(e.dni);
				$('#nombres').val(e.nombres+ ' ' + e.apellidoPaterno + ' ' + e.apellidoMaterno);
				// $('#apellidos').val(e.apellidoPaterno + ' ' + e.apellidoMaterno);
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

$(document).ready(function () {
  init();
});

// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function () {
  $('#cargo').on('change', function() { $(this).trigger('blur'); });
  $("#form-agregar-persona").validate({
    ignore: "",
    rules: { 
      tipo_documento: { required: true, },
      num_documento:  { required: true, },
      nombres:  				{ required: true, },
      apellidos:      { required: true, },
      direccion:      { required: true, minlength:2, maxlength:100 },
      email:    			{  minlength:2, maxlength:200 },
      telefono:       { required: true, minlength:5, maxlength:12 },
      cargo:          { required: true,   },      
      imagen:         { extension: "png|jpg|jpeg|webp|svg",  }, 
			nacimiento:     { required: true },
    },
    messages: {
      tipo_documento:	{ required: "Campo requerido", },
      num_documento:  { required: "Campo requerido", },
      nombres:  				{ required: "Campo requerido", },
      apellidos:      { required: "Campo requerido", },
      direccion:      { required: "Campo requerido", minlength:"Minimo {0} caracteres", maxlength:"Maximo {0} caracteres" },
      email:    			{ minlength:"Minimo {0} caracteres", maxlength:"Maximo {0} caracteres" },
      telefono:       { required: "Campo requerido", minlength:"Minimo {0} caracteres", maxlength:"Maximo {0} caracteres" },
      cargo:          { required: "Campo requerido",  },
      nacimiento:    	{ required: "Campo requerido", },      
      imagen:         { extension: "Ingrese imagenes validas ( {0} )", },
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
      guardar_y_editar_persona(e);      
    },
  });
  $('#cargo').rules('add', { required: true, messages: {  required: "Campo requerido" } });
});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..
