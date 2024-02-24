//Función que se ejecuta al inicio
function init() {

  mostrar();

	// ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#actualizar_registro").on("click", function (e) { $("#submit-form-disenio").submit(); });

}

// abrimos el navegador de archivos
$("#doc1_i").click(function() {  $('#doc1').trigger('click'); });
$("#doc1").change(function(e) {  addImageApplication(e,$("#doc1").attr("id")) });
$("#doc2_i").click(function() {  $('#doc2').trigger('click'); });
$("#doc2").change(function(e) {  addImageApplication(e,$("#doc2").attr("id")) });


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
      $("#titulo").val(e.data.titulo);
      $("#descripcion").val(e.data.descripcion);

      // ------------ IMAGEN FONDO -----------
      if (e.data.img_fondo == "" || e.data.img_fondo == null  ) {   } else {
        $("#doc_old_1").val(e.data.img_fondo); 
        $("#doc1_nombre").html(`<div class="row"> <div class="col-md-12"><i>imagen.${extrae_extencion(e.data.img_fondo)}</i></div></div>`);
        // cargamos la imagen adecuada par el archivo
        $("#doc1_ver").html(doc_view_extencion(e.data.img_fondo,'assets/modulo/landing_disenio', '100%', '210' ));   //ruta imagen          
      }


      // ------------- IMAGEN BONO --------------
      if (e.data.img_promocion == "" || e.data.img_promocion == null  ) {   } else {
        $("#doc_old_2").val(e.data.img_promocion); 
        $("#doc2_nombre").html(`<div class="row"> <div class="col-md-12"><i>imagen.${extrae_extencion(e.data.img_promocion)}</i></div></div>`);
        // cargamos la imagen adecuada par el archivo
        $("#doc2_ver").html(doc_view_extencion(e.data.img_promocion,'assets/modulo/landing_disenio', '100%', '210' ));   //ruta imagen          
      }

    }else{
      ver_errores(e);
    }

  }).fail( function(e) { console.log(e); ver_errores(e); } );
}

function activar_editar(estado) {

  if (estado=="1") {
    $(".editar").hide();
    $(".actualizar").show();
    $(".registra_unico").hide();
    $(".unico").hide();


    $("#titulo").removeAttr("readonly");
    $("#descripcion").removeAttr("readonly");
    $("#edit_img").show();
    $("#edit_img2").show();
    $("#doc1_nombre").show();
    toastr.success('Campos habiliados para editar!!!')
    
    $('.jq_image_zoom').zoom({ on:'grab' }); // Dale zoom a la imagen -_-

  }else if (estado=="2") {

    $(".editar").show();
    $(".actualizar").hide();
    $(".registra_unico").hide();
    $(".unico").hide();

    $("#titulo").attr('readonly','true');
    $("#descripcion").attr('readonly','true');
    $("#edit_img").hide();
    $("#edit_img2").hide();
    $("#doc1_nombre").hide();
    

    // Limpiamos las validaciones
    $(".form-control").removeClass('is-valid');
    $(".form-control").removeClass('is-invalid');
    $(".error.invalid-feedback").remove();

    $(".tooltip").removeClass("show").addClass("hidde");

  } else if(estado=="3"){
    $(".unico").show();
    $(".editar").hide();
    $(".registra_unico").show();

    $("#titulo").removeAttr("readonly");
    $("#descripcion").removeAttr("readonly");
    $("#edit_img").show();
    $("#edit_img2").show();
    $("#doc1_nombre").show();
    toastr.success('Campos habiliados para registrar!!!')
  }
}

function actualizar_disenio(e) {

  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../ajax/landing_disenio.php?op=actualizar",
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

    },
    xhr: function () {
      var xhr = new window.XMLHttpRequest();

      xhr.upload.addEventListener(
        "progress",
        function (evt) {
          if (evt.lengthComputable) {
            var percentComplete = (evt.loaded / evt.total) * 100;
            /*console.log(percentComplete + '%');*/
            $("#barra_progress2").css({ width: percentComplete + "%" });

            $("#barra_progress2").text(percentComplete.toFixed(2) + " %");

            if (percentComplete === 100) {
              l_m();
            }
          }
        },
        false
      );
      return xhr;
    },
  });
}

function registrar_unico(){
  var formData = new FormData($("#formulario")[0]);
  $.ajax({
    url: "../ajax/landing_disenio.php?op=registrar_unico",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (e) {
      try {
        e = JSON.parse(e);  console.log(e);
        if (e.status == true) {

          Swal.fire("Correcto!", "El registro se guardó correctamente.", "success");

          mostrar(); activar_editar(2);

        }else{
          ver_errores(e);
        }
      } catch (err) {
        console.log('Error: ', err.message); toastr.error('<h5 class="font-size-16px">Error temporal!!</h5> puede intentalo mas tarde, o comuniquese con <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>');
      }

    },
    xhr: function () {
      var xhr = new window.XMLHttpRequest();

      xhr.upload.addEventListener(
        "progress",
        function (evt) {
          if (evt.lengthComputable) {
            var percentComplete = (evt.loaded / evt.total) * 100;
            /*console.log(percentComplete + '%');*/
            $("#barra_progress2").css({ width: percentComplete + "%" });

            $("#barra_progress2").text(percentComplete.toFixed(2) + " %");

            if (percentComplete === 100) {
              l_m();
            }
          }
        },
        false
      );
      return xhr;
    },
  });
}

// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..
$(function () {
  $("#formulario").validate({
    rules: {
      titulo: { required: true, minlength: 2, maxlength: 100 },
      descripcion: { required: true, minlength: 2, maxlength: 500 },
    },

    messages: {
      titulo: { required: "Por favor rellena el campo" },
      descripcion: { required: "Por favor rellena el campo" },
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
      actualizar_disenio(e);
    },
  });
});


init();


// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..

function doc1_eliminar() {
	$("#doc1").val("");
	$("#doc1_ver").html('<img src="../assets/images/default/img_defecto2.png" alt="" width="50%" >');
	$("#doc1_nombre").html("");
}

function l_m() {
  // limpiar();
  $("#barra_progress").css({ width: "0%" });

  $("#barra_progress").text("0%");

  $("#barra_progress2").css({ width: "0%" });

  $("#barra_progress2").text("0%");
}

function mayus(e) {
	e.value = e.value.toUpperCase();
}