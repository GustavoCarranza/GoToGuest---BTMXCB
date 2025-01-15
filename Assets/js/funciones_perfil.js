let divLoading = document.querySelector("#divLoading");

document.addEventListener("DOMContentLoaded", () => {
  fntActualizarInformacion();
  validarCampos();
  fntCambiarPassPerfil();
});

//Funcion para validar campos
function validarCampos() {
  const campos = document.querySelectorAll(".valid");
  campos.forEach((campo) => {
    campo.addEventListener("input", () => {
      const esCampoTexto = campo.classList.contains("validText");
      const esCampoNumero = campo.classList.contains("validNumber");

      if (esCampoTexto) {
        const contieneNumeros = /\d/.test(campo.value); // Verifica si contiene números
        const contieneEspeciales =
          /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(campo.value); // Verifica si contiene caracteres especiales
        if (!contieneNumeros && !contieneEspeciales) {
          campo.classList.remove("is-invalid"); // Remover clase de estilo si es válido
        } else {
          campo.classList.add("is-invalid"); // Agregar clase de estilo si contiene números o caracteres especiales
        }
      }

      if (esCampoNumero) {
        const contieneLetras = /[a-zA-Z]/.test(campo.value); // Verifica si contiene letras
        const contieneEspeciales =
          /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(campo.value); // Verifica si contiene caracteres especiales
        if (!contieneLetras && !contieneEspeciales) {
          campo.classList.remove("is-invalid"); // Remover clase de estilo si es válido
        } else {
          campo.classList.add("is-invalid"); // Agregar clase de estilo si contiene letras o caracteres especiales
        }
      }
    });
  });
}

//Funcion para actualizar la informacion del perfil
function fntActualizarInformacion() {
  const btnModal = document.getElementById("btnPerfil");
  btnModal.addEventListener("click", () => {
    $("#modalPerfil").modal("show");
    document.getElementById("formPerfil").reset();

    const formPerfil = document.getElementById("formPerfil");
    formPerfil.onsubmit = (e) => {
      e.preventDefault();
      //Creamos variables y capturamos el id de los inputs
      const strNombre = document.querySelector("#txtNombresUpdate").value;
      const strApellido = document.querySelector("#txtApellidosUpdate").value;
      const strEmail = document.querySelector("#txtCorreoUpdate").value;
      const strUsuario = document.querySelector("#txtUsuarioUpdate").value;
      //Validamos que los campos no vayan vacios
      if (
        strNombre == "" ||
        strApellido == "" ||
        strEmail == "" ||
        strUsuario == ""
      ) {
        Swal.fire({
          title: "¡Attention!",
          text: "All fields are required",
          icon: "error",
          confirmButtonText: "Accept",
        });
        return false;
      }
      //Validar si que los campos tipos text no incluyan numero ni simbolos
      const camposTexto = document.querySelectorAll(".valid.validText");
      let contieneNumerosOSimbolos = false;
      camposTexto.forEach((campo) => {
        if (/[0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(campo.value)) {
          contieneNumerosOSimbolos = true;
          campo.classList.add("is-invalid"); // Agregar clase de Bootstrap para resaltar el campo
        }
      });
      // Mostrar alerta si hay campos con números o símbolos
      if (contieneNumerosOSimbolos) {
        Swal.fire({
          title: "¡Attention!",
          text: "Correct fields containing numbers or symbols",
          icon: "error",
          confirmButtonText: "Accept",
        });
        return false; // Detener el proceso
      }

      divLoading.style.display = "flex";
      fetch(Base_URL + "/Usuarios/putPerfil", {
        method: "POST",
        body: new FormData(formPerfil),
      })
        .then((Response) => {
          if (!Response) {
            throw new Error("Error en la solicitud");
          }
          return Response.json();
        })
        .then((data) => {
          if (data.status) {
            $("#modalPerfil").modal("hide");
            formPerfil.reset();
            Swal.fire({
              title: "Profile",
              text: data.msg,
              icon: "success",
              confirmButtonText: "Accept",
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload();
              }
            });
          } else {
            Swal.fire({
              title: "Error",
              text: data.msg,
              icon: "error",
              confirmButtonText: "Accept",
            });
          }
        })
        .catch(() => {
          Swal.fire({
            title: "¡Attention!",
            text: "Something happened in the process, check code",
            icon: "error",
            confirmButtonText: "Accept",
          });
        });
      divLoading.style.display = "none";
      return false;
    };
  });
}

//Funcion para actualizar contraseña del perfil
function fntCambiarPassPerfil() {
  const formCambiarPass = document.getElementById("formCambioPass");
  formCambiarPass.onsubmit = (e) => {
    e.preventDefault();
    //Capturamos los datos
    const strPasswordActual =
      document.querySelector("#txtPasswordActual").value;
    const strPasswordNew = document.querySelector("#txtPasswordNew").value;
    const strPasswordNewConfirm = document.querySelector(
      "#txtPasswordNewConfirm"
    ).value;
    // Validar que los campos no estén vacíos
    if (
      strPasswordActual === "" ||
      strPasswordNew === "" ||
      strPasswordNewConfirm === ""
    ) {
      Swal.fire({
        title: "¡Attention!",
        text: "The fields are required",
        icon: "error",
        confirmButtonText: "Accept",
      });
      return false;
    }
    // Validar que las contraseñas coincidan
    if (strPasswordNew !== strPasswordNewConfirm) {
      Swal.fire({
        title: "!Attention¡",
        text: "The new password and the confirmation are not the same, please check",
        icon: "info",
        confirmButtonText: "Accept",
      });
      return false;
    }
    // Validar la longitud de la contraseña
    if (strPasswordNew.length < 5) {
      Swal.fire({
        title: "!Attention¡",
        text: "The new password must contain at least 5 characters",
        icon: "info",
        confirmButtonText: "Accept",
      });
      return false;
    }
    // Agregar un indicador de carga
    divLoading.style.display = "flex";
    fetch(Base_URL + "/Usuarios/updatePassPerfil", {
      method: "POST",
      body: new FormData(formCambiarPass),
    })
      .then((Response) => {
        if (!Response) {
          throw new Error("Error en la solicitud");
        }
        return Response.json();
      })
      .then((data) => {
        if (data.status) {
          formCambiarPass.reset();
          Swal.fire({
            title: "Profile",
            text: data.msg,
            icon: "success",
            confirmButtonText: "Accept",
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
        } else {
          Swal.fire({
            title: "Error",
            text: data.msg,
            icon: "error",
            confirmButtonText: "Accept",
          });
        }
      })
      .catch(() => {
        Swal.fire({
          title: "¡Attention!",
          text: "Something happened in the process, check code",
          icon: "error",
          confirmButtonText: "Accept",
        });
      });
    // Ocultar el indicador de carga
    divLoading.style.display = "none";
    return false;
  };
}
