let divLoading = document.querySelector("#divLoading");

document.addEventListener("DOMContentLoaded", () => {
  fntCambiarPassPerfil();
});

//Funcion para actualizar contraseña del perfil
function fntCambiarPassPerfil() {
  const formCambiarPass = document.getElementById("formCambioPass");
  const btn = document.querySelector("#btn");
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
    //Agregar un loading
    btn.disabled = true;
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
      })
      .finally(() => {
        divLoading.style.display = "none";
        btn.disabled = false;
      });
  };
}
