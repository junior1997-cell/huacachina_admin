
$(function () {
  $("#frmAcceso").on("submit", function (e) {
    e.preventDefault();

    var btnIngresar = $(".login-btn");
    var logina = $("#logina").val();
    var clavea = $("#clavea").val();
    // var st = $("#estadot").val();
    var st = 0;

    btnIngresar.prop("disabled", true).html(`<i class="bx bx-loader-circle bx-spin font-size-15px" ></i> Validando datos<span class="bx-burst">...</span>`).removeClass('btn-primary').addClass('btn-outline-dark');


    $.post("../ajax/usuario.php?op=verificar", { "logina": logina, "clavea": clavea, "st": st }, function (e) {
      try {
        e = JSON.parse(e); //console.log(e);		

        setTimeout(validar_response(e), 1000);

      } catch (error) {
        console.log(error);
        btnIngresar.prop("disabled", false).html("Iniciar sesion");
      }

    }).fail(function (e) {
      btnIngresar.prop("disabled", false).html("Iniciar sesion");
      const dangert = document.getElementById('error-servidor');
      const toast = new bootstrap.Toast(dangert); toast.show();
    });
  });
});

function validar_response(e) {

  if (e.status == true) {

    if (e.data == null || e.data.length===0) {
      const dangert = document.getElementById('user-incorrecto');
      const toast = new bootstrap.Toast(dangert); toast.show();

      $('.login-btn').html('Iniciar sesion').prop("disabled", false).removeClass('disabled btn-outline-dark').addClass('btn-primary');
    } else {

      var redirecinando = varaibles_get();

      $('.login-btn').html('Iniciar sesion').prop("disabled", false).removeClass('disabled btn-outline-dark').addClass('btn-primary');
      
      localStorage.setItem('nube_id_usuario', e.data.idusuario);
      localStorage.setItem('nube_nombre_usuario', e.data.nombre_usuario);


      if (redirecinando.file == '' || redirecinando.file == null) { $(location).attr("href", "escritorio.php"); } else { $(location).attr("href", redirecinando.file); }
    }

  } else {
    $('.login-btn').html('Ingresar').removeClass('disabled btn-outline-dark').addClass('btn-primary');
    ver_errores(e);
  }
}

function varaibles_get() {
  var v_args = location.search.substring(1).split("&");
  var param_values = [];
  if (v_args != '' && v_args != 'undefined')
    for (var i = 0; i < v_args.length; i++) {
      var pair = v_args[i].split("=");
      if (typeOfVar(pair) === 'array') {
        param_values[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
      }
    }
  return param_values;
}

function typeOfVar(obj) {
  return {}.toString.call(obj).split(' ')[1].slice(0, -1).toLowerCase();
}

