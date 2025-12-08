let divLoading = document.querySelector("#divLoading");

//Las funciones que se almacenen se ejecutaran al cargar la pagina
document.addEventListener("DOMContentLoaded", () => {
  fntToken();
});

//Funcion para capturar el token
function fntToken() {
  //Obtenemos el token desde el url
  const params = new URLSearchParams(window.location.search);
  const token = params.get("token");

  //capturamos al boton
  const btnverify = document.getElementById("bntVerificar");

  if (btnverify) {
    btnverify.addEventListener("click", function (e) {
      e.preventDefault(); // Evita recargar página
      fntEmailVerified(token);
    });
  }
}

//Funcion para verificar email
function fntEmailVerified(token) {
  fetch(Base_URL + "/Verification/active_account", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ token: token }),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json();
    })
    .then((data) => {
      if (data.status) {
        Swal.fire({
          title: "¡Users!",
          text: data.msg,
          icon: "success",
          confirmButtonText: "Accept",
        }).then((result) => {
            if(result.isConfirmed){
                window.location.href = Base_URL;
            }
        })
      } else {
        Swal.fire({
          title: "¡Users!",
          text: data.msg,
          icon: "error",
          confirmButtonText: "Accept",
        });
      }
    });
}
