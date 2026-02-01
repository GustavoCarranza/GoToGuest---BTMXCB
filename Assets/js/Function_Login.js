let divLoading = document.querySelector("#divLoading");
//Cada vez que se recargue la pagina se ejecutaran las funciones que se le vayan agregando
document.addEventListener("DOMContentLoaded", () => {
  fntLogin();
});

function fntLogin() {
  const formLogin = document.getElementById("formLogin");
  const btn = document.getElementById("btn");
  formLogin.onsubmit = (e) => {
    e.preventDefault();

    //Capturamos los id de los inputs
    let txtUser = document.querySelector("#txtUser").value;
    let txtPassword = document.querySelector("#txtPassword").value;
    //Validamos que los inputs no vayan vacios
    if (txtUser == "" || txtPassword == "") {
      Swal.fire({
        title: "¡Attention!",
        text: "Enter username and password",
        icon: "error",
        confirmButtonText: "Accept",
      });
      return false;
    } else {
      //Agregar un loading
      btn.disabled = true;
      divLoading.style.display = "flex";
      fetch(Base_URL + "/Login/loginUser", {
        method: "POST",
        body: new FormData(formLogin),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la solicitus");
          }
          return response.json();
        })
        .then((data) => {
          if (data.status) {
            window.location = Base_URL + "/Dashboard";
          } else {
            Swal.fire({
              title: "¡Attention!",
              text: data.msg,
              icon: "error",
              confirmButtonText: "Accept",
            });
            document.querySelector("#txtPassword").value = "";
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
    }
  };
}
