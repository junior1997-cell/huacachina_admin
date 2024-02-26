//Función que se ejecuta al inicio
function init() {

  mostrar();

	// ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
	$("#guardar_registro_disenio").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-disenio").submit(); } });

}

// abrimos el navegador de archivos
$("#doc1_i").click(function() {  $('#doc1').trigger('click'); });
$("#doc1").change(function(e) {  addImageApplication(e,$("#doc1").attr("id"), null, null, null, true) });
$("#doc2_i").click(function() {  $('#doc2').trigger('click'); });
$("#doc2").change(function(e) {  addImageApplication(e,$("#doc2").attr("id"), null, null, null, true) });
$("#doc3_i").click(function() {  $('#doc3').trigger('click'); });
$("#doc3").change(function(e) {  addImageApplication(e,$("#doc3").attr("id"), null, null, null, true) });

function doc1_eliminar() {
	$("#doc1").val("");
	$("#doc1_ver").html('<img src="../assets/images/default/img_defecto2.png" alt="" width="78%" >');
	$("#doc1_nombre").html("");
}

function doc2_eliminar() {
	$("#doc2").val("");
	$("#doc2_ver").html('<img src="../assets/images/default/img_defecto2.png" alt="" width="78%" >');
	$("#doc2_nombre").html("");
}

function doc3_eliminar() {
	$("#doc3").val("");
	$("#doc3_ver").html('<img src="../assets/images/default/img_defecto2.png" alt="" width="78%" >');
	$("#doc3_nombre").html("");
}

function activar_editar(estado) {

  if (estado=="1") {
    $(".editar").hide();
    $(".actualizar").show();
    $(".registra_unico").hide();
    $(".unico").hide();

    $("#f_titulo").removeAttr("readonly");
    $("#f_descripcion").removeAttr("readonly");
    $("#fe_titulo").removeAttr("readonly");
    $("#fe_descripcion").removeAttr("readonly");
    $(".edit_img").show();
   
    toastr.success('Campos habiliados para editar!!!');     

  }else if (estado=="2") {

    $(".editar").show();
    $(".actualizar").hide();
    $(".registra_unico").hide();
    $(".unico").hide();

    $("#f_titulo").attr('readonly','true');
    $("#f_descripcion").attr('readonly','true');
    $("#fe_titulo").attr('readonly','true');
    $("#fe_descripcion").attr('readonly','true');
    $(".edit_img").hide();

  } else if(estado=="3"){
    $(".unico").show();
    $(".editar").hide();
    $(".registra_unico").show();

    $("#titulo").removeAttr("readonly");
    $("#descripcion").removeAttr("readonly");
    $(".edit_img").show();
    
    toastr.success('Campos habiliados para registrar!!!')
  }

  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();

  $('.jq_image_zoom').zoom({ on:'grab' }); // Dale zoom a la imagen -_-
  $(".tooltip").removeClass("show").addClass("hidde");
}

function mostrar() {

  $("#cargando-1-fomulario").hide();
  $("#cargando-2-fomulario").show();

  $.post("../ajax/landing_disenio.php?op=mostrar", {}, function (e, status) {
    e = JSON.parse(e);  console.log(e);
    
    if(e.data == null || e.data == ""){
      $("#cargando-1-fomulario").show();
      $("#cargando-2-fomulario").hide();
      activar_editar(3);

    }else if (e.status){

      $("#cargando-1-fomulario").show();
      $("#cargando-2-fomulario").hide();

      // ------------ INFO ----------
      $("#f_titulo").val(e.data.f_titulo);
      $("#f_descripcion").val(e.data.f_descripcion);
      $("#fe_titulo").val(e.data.fe_titulo);
      $("#fe_descripcion").val(e.data.fe_descripcion);

      // ------------ IMAGEN FONDO -----------
      if (e.data.f_img_fondo == "" || e.data.f_img_fondo == null  ) {   } else {
        $("#doc_old_1").val(e.data.f_img_fondo); 
        $("#doc1_nombre").html(`<div class="row"> <div class="col-md-12"><i>imagen.${extrae_extencion(e.data.f_img_fondo)}</i></div></div>`);
        // cargamos la imagen adecuada par el archivo
        $("#doc1_ver").html(doc_view_extencion(e.data.f_img_fondo,'assets/modulo/landing_disenio', '100%', '210' ));   //ruta imagen          
      }

      // ------------- IMAGEN BONO --------------
      if (e.data.f_img_promocion == "" || e.data.f_img_promocion == null  ) {   } else {
        $("#doc_old_2").val(e.data.f_img_promocion); 
        $("#doc2_nombre").html(`<div class="row"> <div class="col-md-12"><i>imagen.${extrae_extencion(e.data.f_img_promocion)}</i></div></div>`);
        // cargamos la imagen adecuada par el archivo
        $("#doc2_ver").html(doc_view_extencion(e.data.f_img_promocion,'assets/modulo/landing_disenio', '100%', '210' ));   //ruta imagen          
      }

      // ------------ IMAGEN FONDO -----------
      if (e.data.fe_img_fondo == "" || e.data.fe_img_fondo == null  ) {   } else {
        $("#doc_old_3").val(e.data.fe_img_fondo); 
        $("#doc3_nombre").html(`<div class="row"> <div class="col-md-12"><i>imagen.${extrae_extencion(e.data.fe_img_fondo)}</i></div></div>`);
        // cargamos la imagen adecuada par el archivo
        $("#doc3_ver").html(doc_view_extencion(e.data.fe_img_fondo,'assets/modulo/landing_disenio', '100%', '210' ));   //ruta imagen          
      }
      $('.jq_image_zoom').zoom({ on:'grab' }); // Dale zoom a la imagen -_-
    }else{
      ver_errores(e);
    }

  }).fail( function(e) { console.log(e); ver_errores(e); } );
}

function actualizar_disenio(e) {

  var formData = new FormData($("#formulario-agregar-disenio")[0]);

  $.ajax({
    url: "../ajax/landing_disenio.php?op=guardar_y_editar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (e) {
      try {
        e = JSON.parse(e);  console.log(e);
        if (e.status == true) {
          Swal.fire("Correcto!", "El registro se actualizó correctamente.", "success");
          mostrar(); activar_editar(2);
        }else{
          ver_errores(e);
        }
      } catch (err) {
        console.log('Error: ', err.message); toastr.error('<h5 class="font-size-16px">Error temporal!!</h5> puede intentalo mas tarde, o comuniquese con <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>');
      }
      $("#guardar_registro_disenio").html('Guardar Cambios').removeClass('disabled send-data');
    },
    xhr: function () {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function (evt) {
				if (evt.lengthComputable) {
					var percentComplete = (evt.loaded / evt.total) * 100;
					/*console.log(percentComplete + '%');*/
					$("#barra_progress_disenio").css({ "width": percentComplete + '%' });
					$("#barra_progress_disenio div").text(percentComplete.toFixed(2) + " %");
				}
			}, false);
			return xhr;
		},

		beforeSend: function () {
			$("#guardar_registro_disenio").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled send-data');
			$("#barra_progress_disenio").css({ width: "0%", });
			$("#barra_progress_disenio div").text("0%");
      $("#barra_progress_disenio_div").show();
		},
		complete: function () {
			$("#barra_progress_disenio").css({ width: "0%", });
			$("#barra_progress_disenio div").text("0%");
      $("#barra_progress_disenio_div").hide();
		},
		error: function (jqXhr, ajaxOptions, thrownError) {
			ver_errores(jqXhr);
		}
  });
}


// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..
$(function () {
  $("#formulario-agregar-disenio").validate({
    rules: {
      f_titulo:       { required: true, minlength: 2, maxlength: 100 },
      f_descripcion:  { required: true, minlength: 2, maxlength: 500 },
      fe_titulo:      { required: true, minlength: 2, maxlength: 100 },
      fe_descripcion: { required: true, minlength: 2, maxlength: 500 },
    },

    messages: {
      f_titulo:       { required: "Por favor rellena el campo" },
      f_descripcion:  { required: "Por favor rellena el campo" },
      fe_titulo:      { required: "Por favor rellena el campo" },
      fe_descripcion: { required: "Por favor rellena el campo" },
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
      // $("html").animate({ scrollTop: $(document).height() }, 600); // Scrollea hasta abajo de la página
      window.scroll({ top: document.body.scrollHeight, left: document.body.scrollHeight, behavior: "smooth", });
      actualizar_disenio(e);
    },
  });
});


init();


// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..



function mayus(e) {
	e.value = e.value.toUpperCase();
}