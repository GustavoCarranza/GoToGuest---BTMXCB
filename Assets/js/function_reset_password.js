let divLoading = document.querySelector("#divLoading");

document.addEventListener("DOMContentLoaded", () => {
  fntValidationEmail();
  fntResetPassword();
});

function fntValidationEmail() {
  const formReset = document.getElementById("formReset");
  if (!formReset) return;
  formReset.onsubmit = (e) => {
    e.preventDefault();
    const btn = formReset.querySelector("button");

    //Capturamos el ID del email
    const txtEmail = document.getElementById("txtEmail").value.trim();
    if (txtEmail === "") {
      Swal.fire({
        title: "¡Attention!",
        text: "The E-mail is required",
        icon: "error",
        confirmButtonText: "Accept",
      });
      return false;
    }
    btn.disabled = true;
    divLoading.style.display = "flex";

    const formData = new FormData();
    formData.append("txtEmail", txtEmail);
    divLoading.style.display = "flex";
    fetch(Base_URL + "/Login/requestResetPassword", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la solucitud");
        }
        return response.json();
      })
      .then((objData) => {
        if (objData.status) {
          Swal.fire({
            title: "¡Attention!",
            text: objData.msg,
            icon: "success",
            confirmButtonText: "Accept",
          }).then((result) => {
            if (result.isConfirmed) {
              window.location = Base_URL + "/Login";
            }
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
        btn.disabled = false;
        divLoading.style.display = "none";
      });
  };
}

function fntResetPassword() {
  const formReset = document.getElementById("formResetPassword");
  if (!formReset) return;

  const btn = formReset.querySelector("button");
  const divLoading = document.getElementById("divLoading");

  formReset.onsubmit = (e) => {
    e.preventDefault();

    const password = document.getElementById("password").value.trim();
    const confirm = document.getElementById("password_confirm").value.trim();
    const token = document.getElementById("token").value;

    if (password === "" || confirm === "") {
      Swal.fire({
        title: "¡Attention!",
        text: "All fields are required",
        icon: "error",
        confirmButtonText: "Accept",
      });
      return;
    }

    if (password.length < 8) {
      Swal.fire({
        title: "¡Attention!",
        text: "Password must be at least 8 characteres",
        icon: "info",
        confirmButtonText: "Accept",
      });
      return;
    }

    if (password !== confirm) {
      Swal.fire({
        title: "¡Attention!",
        text: "Passwords don't match",
        icon: "warning",
        confirmButtonText: "Accept",
      });
      return;
    }

    btn.disabled = true;
    divLoading.style.display = "flex";

    const formData = new FormData();
    formData.append("password", password);
    formData.append("token", token);

    fetch(Base_URL + "/Login/updatePassword", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la solicitud");
        }
        return response.json();
      })
      .then((objData) => {
        if (objData.status) {
          Swal.fire({
            title: "¡Attention!",
            text: objData.msg,
            icon: "success",
            confirmButtonText: "Accept",
          }).then(() => {
            window.location = Base_URL + "/Login";
          });
        } else {
          Swal.fire({
            title: "¡Attention!",
            text: objData.msg,
            icon: "error",
            confirmButtonText: "Accept",
          });
          btn.disabled = false;
        }
      })
      .catch(() => {
        Swal.fire({
          title: "¡Attention!",
          text: objData.msg,
          icon: "error",
          confirmButtonText: "Accept",
        });
        btn.disabled = false;
      })
      .finally(() => {
        divLoading.style.display = "none";
      });
  };
}
