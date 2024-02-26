
function init() {

  mostrar();
	// ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#guardar_registro_empresa").on("click", function (e) { if ($(this).hasClass('send-data') == false) { $("#submit-form-empresa").submit(); } });

  // ══════════════════════════════════════ I N I T I A L I Z E   S E L E C T 2 ══════════════════════════════════════
 
}

function activar_editar(estado) {

  if (estado=="1") {
    $(".editar").hide();
    $(".actualizar").show();

    $(".inpur_edit").removeAttr("readonly");

    toastr.success('Campos habiliados para editar!!!')
  }else if (estado=="2") {

    $(".editar").show();
    $(".actualizar").hide();

    $(".inpur_edit").attr('readonly','true');
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
      $("#mapa").val(e.data.mapa);      
      $("#horario").val(e.data.horario);

      $("#correo").val(e.data.correo);
      $("#celular").val(e.data.celular);
      $("#telefono").val(e.data.telefono_fijo);
      $("#link_grupo_whats").val(e.data.link_grupo_whats);      

      $("#rs_facebook").val(e.data.rs_facebook);
      $("#rs_instagram").val(e.data.rs_instagram);
      $("#rs_web").val(e.data.rs_web);

      $("#rs_facebook_etiqueta").val(e.data.rs_facebook_etiqueta);
      $("#rs_instagram_etiqueta").val(e.data.rs_instagram_etiqueta);
      $("#rs_web_etiqueta").val(e.data.rs_web_etiqueta);
      
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

            
          }
        },
        false
      );
      return xhr;
    },
  });
}

function view_mapa() {
  
  $(".preview-mapa").html($("#mapa").val());
  $('.preview-mapa iframe').attr('width', '100%').attr('height', '400px');
  $("#modal-agregar-mapa").modal("show");
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
      mapa:         { required: true} , 
      horario:      { required: true, minlength: 4, maxlength: 200,},
      
      correo:           { required: true, minlength: 4, maxlength: 100, } , 
      celular:          { required: true, minlength: 4, maxlength: 9,} , 
      telefono:         { minlength: 4, maxlength: 9,} , 
      link_grupo_whats: { required: true, minlength: 4, maxlength: 150,} , 
      

      rs_facebook:          { required: true, minlength: 4, maxlength: 150,}, 
      rs_instagram:         { required: true, minlength: 4, maxlength: 150,}, 
      rs_web:               { required: true, minlength: 4, maxlength: 150,}, 
      rs_facebook_etiqueta: { required: true, minlength: 4, maxlength: 150,}, 
      rs_instagram_etiqueta:{ required: true, minlength: 4, maxlength: 150,}, 
      rs_web_etiqueta:      { required: true, minlength: 4, maxlength: 150,}, 
    },
    messages: {

      direccion:  { required: "Campo requerido.", }, 
      celular:    { required: "Campo requerido.", }, 
      telefono:   { required: "Campo requerido.", }, 
      mapa:       { required: "Campo requerido.", }, 
      longuitud:  { required: "Campo requerido.", }, 
      correo:     { required: "Campo requerido.", }, 
      horario:    { required: "Campo requerido.", }
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
