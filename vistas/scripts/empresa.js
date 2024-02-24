
function init() {

  mostrar();
	// ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#actualizar_registro").on("click", function (e) { $("#submit-form-actualizar-registro").submit(); });

  // ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T 2 ══════════════════════════════════════
 
}

function activar_editar(estado) {

  if (estado=="1") {
    $(".editar").hide();
    $(".actualizar").show();

    $("#nombre").removeAttr("readonly");
    $("#direccion").removeAttr("readonly");
    $("#tipo_documento").removeAttr("readonly");
    $("#num_documento").removeAttr("readonly");
    $("#celular").removeAttr("readonly");
    $("#telefono").removeAttr("readonly");
    $("#correo").removeAttr("readonly");
    $("#mapa").removeAttr("readonly");
    $("#longuitud").removeAttr("readonly");
    $("#horario").removeAttr("readonly");

    $("#rs_facebook").removeAttr("readonly");
    $("#rs_instagram").removeAttr("readonly");
    $("#rs_web").removeAttr("readonly");
    toastr.success('Campos habiliados para editar!!!')
  }else if (estado=="2") {

    $(".editar").show();
    $(".actualizar").hide();

    $("#nombre").attr('readonly','true');
    $("#direccion").attr('readonly','true');
    $("#tipo_documento").attr('readonly','true');
    $("#num_documento").attr('readonly','true');
    $("#celular").attr('readonly','true');
    $("#telefono").attr('readonly','true');
    $("#correo").attr('readonly','true');
    $("#mapa").attr('readonly','true');
    $("#longuitud").attr('readonly','true');
    $("#horario").attr('readonly','true');

    $("#rs_facebook").attr('readonly','true');
    $("#rs_instagram").attr('readonly','true');
    $("#rs_web").attr('readonly','true');
  }
}

function mostrar() {

  $("#cargando-1-fomulario").hide();
  $("#cargando-2-fomulario").show();

  $.post("../ajax/empresa.php?op=mostrar_empresa", {}, function (e, status) {

    e = JSON.parse(e);  console.log(e);  
    if (e.status){

      $("#cargando-1-fomulario").show();
      $("#cargando-2-fomulario").hide();

      $("#idnosotros").val(e.data.idnosotros);
      $("#nombre").val(e.data.nombre_empresa);
      $("#direccion").val(e.data.direccion);
      $("#num_documento").val(e.data.num_documento);
      $("#celular").val(e.data.celular);
      $("#telefono").val(e.data.telefono_fijo);
      $("#correo").val(e.data.correo);
      $("#mapa").val(e.data.mapa);
      $("#longuitud").val(e.data.longitud);
      $("#horario").val(e.data.horario);
      $("#rs_facebook").val(e.data.rs_facebook);
      $("#rs_instagram").val(e.data.rs_instagram);
      $("#rs_web").val(e.data.rs_web);
      
    }else{
      ver_errores(e);
    }

  }).fail( function(e) { console.log(e); ver_errores(e); } );
}

function actualizar_datos_generales(e) {
  
  var formData = new FormData($("#form-empresa")[0]);

  $.ajax({
    url: "../ajax/empresa.php?op=actualizar_datos_empresa",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (e) {
      try {
        e = JSON.parse(e);  console.log(e); 
        if (e.status == true) {

          Swal.fire("Correcto!", "El registro se guardo correctamente.", "success");

          // Reiniciar las validaciones y estilos
          $("#form-empresa").validate().resetForm();
          // Limpiar clases de validación en los campos
          $("#form-empresa").find(".is-valid").removeClass("is-valid");
          $("#form-empresa").find(".is-invalid").removeClass("is-invalid");

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

function l_m() {
  // limpiar();
  $("#barra_progress").css({ width: "0%" });

  $("#barra_progress").text("0%");

  $("#barra_progress2").css({ width: "0%" });

  $("#barra_progress2").text("0%");
}

init();

// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function () {
  
  $.validator.setDefaults({ submitHandler: function (e) { actualizar_datos_generales(e) },  });

  $("#form-empresa").validate({
    rules: {
      nombre:       { required: true, minlength: 4, maxlength: 100, } , 
      direccion:    { required: true, minlength: 4, maxlength: 100, } , 
      num_documento:{ required: true, minlength: 8, maxlength: 15, } , 
      celular:      { required: true, minlength: 4, maxlength: 9,} , 
      telefono:     { required: true, minlength: 4, maxlength: 9,} , 
      mapa:      { required: true} , 
      longuitud:    { required: true, minlength: 4, maxlength: 10,} , 
      correo:       { required: true, minlength: 4, maxlength: 100, } , 
      horario:      { required: true },
      rs_facebook:  { required: true, minlength: 4, maxlength: 150,}, 
      rs_instagram: { required: true, minlength: 4, maxlength: 150,}, 
      rs_web:    { required: true, minlength: 4, maxlength: 150,}, 
    },
    messages: {

      direccion: { required: "Por favor rellenar el campo", }, 
      celular: { required: "Por favor rellenar el campo", }, 
      telefono: { required: "Por favor rellenar el campo", }, 
      mapa: { required: "Por favor rellenar el campo", }, 
      longuitud: { required: "Por favor rellenar el campo", }, 
      correo: { required: "Por favor rellenar el campo", }, 
      horario: { required: "Por favor rellenar el campo", }
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

  });

});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..
