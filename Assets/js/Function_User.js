let divLoading = document.querySelector("#divLoading");
let tableUsuarios;
let rowTable;

//Las funciones que se almacenen se ejecutaran al cargar la pagina
document.addEventListener("DOMContentLoaded", () => {
  fntRegistrosUsuarios();
  validarCampos();
  fntRoles_Departamentos();
  fntAgregarUsuarios();
});

//function para los regostros de la tabla
function fntRegistrosUsuarios() {
  tableUsuarios = $("#table_usuarios").DataTable({
    procesing: true,
    responsive: true,
    columnDefs: [
      {
        targets: -1,
        responsivePriority: 1,
      },
    ],
    destroy: true,
    lengthMenu: [10, 25, 50],
    pageLength: 10,
    order: [[0, "asc"]],
    ajax: {
      url: Base_URL + "/Usuarios/getUsuarios",
      dataSrc: "",
    },
    columns: [
      { data: "idUsuario", className: "text-center" },
      { data: "colaborador_num", className: "text-center" },
      { data: "nombres", className: "text-center" },
      { data: "apellidos", className: "text-center" },
      { data: "usuario", className: "text-center" },
      { data: "nombreDepartamento", className: "text-center" },
      { data: "nombreRol", className: "text-center" },
      { data: "status", className: "text-center" },
      { data: "email_verified", className: "text-center" },
      { data: "options", className: "text-center", orderable: false },
    ],
    dom:
      "<'row'<'col-12 mb-3'B>>" + // Botones de exportación
      "<'row'<'col-12 mb-2'<<'col-12 mb-2'l> <<'col-12'f>>>>" + // Selector de longitud y cuadro de búsqueda
      "<'row'<'col-12 mb-4'tr>>" + // Tabla
      "<'row'<'col-12'p>>", // Paginación
    buttons: [
      {
        extend: "copyHtml5",
        text: "<i class='fas fa-copy'></i> Copy",
        titleAttr: "Copy",
        className: "btn btn-secondary col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7], // Excluir la columna de acciones
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Excel",
        className: "btn btn-success col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7], // Excluir la columna de acciones
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "CSV",
        className: "btn btn-light col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7], // Excluir la columna de acciones
        },
      },
    ],
  });
}

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

//Funcion para obtener los roles
function fntRoles_Departamentos() {
  //cremos un objeto XMLHttpRequest de forma segura esto nos sirve para haver solicitudes HTTP desde un navegador web
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  //Creamos una varaible donde le almacenados el metodo del helper donde esta la ruta raiz del proyecto y le concatenamos el controlador a ocupar y el metodo a crear
  let ajaxUrl = Base_URL + "/Roles/getSelectRoles";
  request.open("GET", ajaxUrl, true);
  request.send();
  //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector("#listTipoRol").innerHTML = request.responseText;
      document.querySelector("#listTipoRol").value = 1;
      document.querySelector("#listTipoRolUpdate").innerHTML =
        request.responseText;
      document.querySelector("#listTipoRolUpdate").value = 1;

      fntDepartamentos();
    }
  };
}

//Funcion para obtener los departamentos
function fntDepartamentos() {
  //cremos un objeto XMLHttpRequest de forma segura esto nos sirve para haver solicitudes HTTP desde un navegador web
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  //Creamos una varaible donde le almacenados el metodo del helper donde esta la ruta raiz del proyecto y le concatenamos el controlador a ocupar y el metodo a crear
  let ajaxUrl = Base_URL + "/Departamentos/getSelectDepartamentos";
  request.open("GET", ajaxUrl, true);
  request.send();
  //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector("#listDepartamento").innerHTML =
        request.responseText;
      document.querySelector("#listDepartamento").value = 1;
      document.querySelector("#listDepartamentoUpdate").innerHTML =
        request.responseText;
      document.querySelector("#listDepartamentoUpdate").value = 1;
    }
  };
}

//function para agregar usuarios
function fntAgregarUsuarios() {
  const btnUsuarios = document.getElementById("btnUsuarios");
  btnUsuarios.addEventListener("click", () => {
    $("#modalUsuarios").modal("show");
    document.querySelector("#formUsuario").reset();

    //creamos una variable y capturamos el id del formulario del modal
    const formUsuario = document.querySelector("#formUsuario");
    formUsuario.onsubmit = (e) => {
      e.preventDefault();
      //Creamos variables donde le capturamos el id de los inputs
      const strColaborador = document.querySelector("#num_colaborador");
      const strNombres = document.querySelector("#txtNombres");
      const strApellidos = document.querySelector("#txtApellidos");
      const strCorreo = document.querySelector("#txtCorreo");
      const strUsuario = document.querySelector("#txtUsuario");
      const strPassword = document.querySelector("#txtPassword");
      const strPasswordConfirm = document.querySelector("#txtPasswordConfirm");
      const intDepartamento = document.querySelector("#listDepartamento");
      const intRol = document.querySelector("#listTipoRol");
      const intStatus = document.querySelector("#listStatus");
      //Realizamos una validacion para verificar que los campos no vayan vacios
      if (
        strColaborador == "" ||
        strNombres == "" ||
        strApellidos == "" ||
        strCorreo == "" ||
        strUsuario == "" ||
        strPassword == "" ||
        strPasswordConfirm == "" ||
        intDepartamento == "" ||
        intRol == "" ||
        intStatus == ""
      ) {
        Swal.fire({
          title: "¡Attention!",
          text: "All fields are required",
          icon: "error",
          confirmButtonText: "Accept",
        });
        return false;
      }
      //Validamos que las contraseñas sean iguales
      if (strPassword.value !== strPasswordConfirm.value) {
        Swal.fire({
          title: "¡Attention!",
          text: "Passwords must be the same, verify",
          icon: "info",
          confirmButtonText: "Accept",
        });
        return false;
      }
      //Validamos que la contraseña contenga almenos 5 caracteres
      if (strPassword.value.length < 5) {
        Swal.fire({
          title: "¡Atención!",
          text: "The pasword must contain at least 5 characters",
          icon: "info",
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

      // Verificar que los campos de tipo number no incluyan letras o simbolos
      const camposNumeros = document.querySelectorAll(".valid.validNumber");
      let contieneLetrasOSimbolos = false;
      camposNumeros.forEach((campo) => {
        if (/[a-zA-Z]/.test(campo.value)) {
          contieneLetrasOSimbolos = true;
          campo.classList.add("is-invalid"); // Agregar clase de Bootstrap para resaltar el campo
        }
      });
      // Mostrar alerta si hay campos con letras o símbolos
      if (contieneLetrasOSimbolos) {
        Swal.fire({
          title: "¡Atención!",
          text: "Correct fields where only numbers are valid",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return false; // Detener el proceso
      }

      //Agregar un loading
      btnUsuarios.disabled = true;
      divLoading.style.display = "flex";
      fetch(Base_URL + "/Usuarios/setUsuario", {
        method: "POST",
        body: new FormData(formUsuario),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la solicitud");
          }
          return response.json(); // Obtén la respuesta como JSON
        })
        .then((data) => {
          if (data.status) {
            intStatus == 1
              ? '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>'
              : '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';

            $("#modalUsuarios").modal("hide");
            formUsuario.reset();
            Swal.fire({
              title: "¡Users!",
              text: data.msg,
              icon: "success",
              confirmButtonText: "Accept",
            });
            tableUsuarios.ajax.reload();
          } else {
            Swal.fire({
              title: "Error",
              text: data.msg,
              icon: "error",
              confirmButtonText: "accept",
            });
          }
        })
        .catch(() => {
          Swal.fire({
            title: "¡Attention!",
            text: "Something happened in the process",
            icon: "error",
            confirmButtonText: "Accept",
          });
        })
        .finally(() => {
          divLoading.style.display = "none";
          btnUsuarios.disabled = false;
        });
    };
  });
}

//Funcion para visualizar la informacion del usuario
function btnViewUsuario(idUsuario) {
  fetch(Base_URL + "/Usuarios/getUsuario/" + idUsuario, {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json(); // Obtén la respuesta como JSON
    })
    .then((data) => {
      if (data.status) {
        let estadoUsuario =
          data.data.status == 1
            ? '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>'
            : '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';

        document.querySelector("#cellColaborador").innerHTML =
          data.data.colaborador_num;
        document.querySelector("#cellNombres").innerHTML = data.data.nombres;
        document.querySelector("#cellApellidos").innerHTML =
          data.data.apellidos;
        document.querySelector("#cellCorreo").innerHTML = data.data.email;
        document.querySelector("#cellUsuario").innerHTML = data.data.usuario;
        document.querySelector("#cellDepartamento").innerHTML =
          data.data.nombreDepartamento;
        document.querySelector("#cellRol").innerHTML = data.data.nombreRol;
        document.querySelector("#cellStatus").innerHTML = estadoUsuario;
        document.querySelector("#cellDate").innerHTML = data.data.fechaCreacion;
        document.querySelector("#cellHour").innerHTML = data.data.horaCreacion;
        $("#modalViewUsuarios").modal("show");
      } else {
        Swal.fire({
          title: "¡Attention!",
          text: objData.msg,
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
}

//Function para cambiar la contraseña del usuario
function btnUpdatePass(idUsuario) {
  $("#modalUpdatePass").modal("show");
  //Creamos una variable para capturar el id del formulario del moda
  const formPassUpdate = document.querySelector("#formUpdatePass");
  const btnPasword = document.getElementById("btnPassword");
  formPassUpdate.onsubmit = (e) => {
    e.preventDefault();
    //Capturar los valores de los campos de contrseña
    const strPassword = document.querySelector("#txtUpdatePassword").value;
    const strPasswordConfirm = document.querySelector(
      "#txtUpdatePasswordConfirm",
    ).value;
    //Validar que estos campos no vayan vacios
    if (strPassword == "" || strPasswordConfirm == "") {
      Swal.fire({
        title: "¡Attention!",
        text: "The fields are required",
        icon: "error",
        confirmButtonText: "Accept",
      });
      return false;
    }
    //validar que las contraseñas sean iguales
    if (strPassword !== strPasswordConfirm) {
      Swal.fire({
        title: "¡Attention!",
        text: "Passwords must be the same, verify",
        icon: "info",
        confirmButtonText: "Accept",
      });
      return false;
    }
    //Validar que las contraseñas tengan almenos 5 caracteres
    if (strPassword.length < 5) {
      Swal.fire({
        title: "¡Attention!",
        text: "The password must contain at least 5 characters",
        icon: "info",
        confirmButtonText: "Accept",
      });
      return false;
    }
    //Agregar un loading
    btnPasword.disabled = true;
    divLoading.style.display = "flex";

    fetch(Base_URL + "/Usuarios/updatePass/" + idUsuario, {
      method: "POST",
      body: new FormData(formPassUpdate),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la solicitud");
        }
        return response.json(); // Obtén la respuesta como JSON
      })
      .then((data) => {
        if (data.status) {
          $("#modalUpdatePass").modal("hide");
          formPassUpdate.reset();
          Swal.fire({
            title: "¡Users!",
            text: data.msg,
            icon: "success",
            confirmButtonText: "Accept",
          });
          tableUsuarios.ajax.reload();
        } else {
          Swal.fire({
            title: "Error",
            text: data.msg,
            icon: "error",
            confirmButtonText: "accept",
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
        btnPasword.disabled = false;
      });
  };
}

//function para editar informacion de usuario
function btnUpdateUser(element, idUsuario) {
  rowTable = element.parentNode.parentNode.parentNode;
  $("#modalUpdateUsuarios").modal("show");
  fetch(Base_URL + "/Usuarios/getUsuario/" + idUsuario, {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json(); // Obtén la respuesta como JSON
    })
    .then((data) => {
      if (data.status) {
        //Creamos variables y capturamos el id de los inputs
        document.querySelector("#idUsuario").value = data.data.idUsuario;
        document.querySelector("#num_colaboradorUpdate").value =
          data.data.colaborador_num;
        document.querySelector("#txtNombresUpdate").value = data.data.nombres;
        document.querySelector("#txtApellidosUpdate").value =
          data.data.apellidos;
        document.querySelector("#txtCorreoUpdate").value = data.data.email;
        document.querySelector("#txtUsuarioUpdate").value = data.data.usuario;
        document.querySelector("#listDepartamentoUpdate").value =
          data.data.idDepartamento;
        document.querySelector("#listTipoRolUpdate").value = data.data.idRol;
        if (data.data.status == 1) {
          document.querySelector("#listStatusUpdate").value = 1;
        } else {
          document.querySelector("#listStatusUpdate").value = 2;
        }
      }
    })
    .catch((error) => {
      console.error("Error al procesar la respuesta del servidor:", error);
      Swal.fire({
        title: "¡Atención!",
        text: "Algo ocurrió en el proceso, revisa el código",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });

  //creamos una variable y capturamos el id del formulario
  const formUsuarioUpdate = document.querySelector("#formUsuarioUpdate");
  const btnUpdate = document.getElementById("btnUpdate");
  formUsuarioUpdate.onsubmit = (e) => {
    e.preventDefault();
    //Creamos variables y capturamos el id de los inputs
    const strColaborador = document.querySelector(
      "#num_colaboradorUpdate",
    ).value;
    const strNombres = document.querySelector("#txtNombresUpdate").value;
    const strApellidos = document.querySelector("#txtApellidosUpdate").value;
    const strCorreo = document.querySelector("#txtCorreoUpdate").value;
    const strUsuario = document.querySelector("#txtUsuarioUpdate").value;
    const intDepartamento = document.querySelector(
      "#listDepartamentoUpdate",
    ).value;
    const intRol = document.querySelector("#listTipoRolUpdate").value;
    const intStatus = document.querySelector("#listStatusUpdate").value;

    //Creamos una validacion para comprobar que los campos no vayan vacios
    if (
      strColaborador == "" ||
      strNombres == "" ||
      strApellidos == "" ||
      strCorreo == "" ||
      strUsuario == "" ||
      intDepartamento == "" ||
      intRol == "" ||
      intStatus == ""
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

    // Verificar que los campos de tipo number no incluyan letras o simbolos
    const camposNumeros = document.querySelectorAll(".valid.validNumber");
    let contieneLetrasOSimbolos = false;
    camposNumeros.forEach((campo) => {
      if (/[a-zA-Z]/.test(campo.value)) {
        contieneLetrasOSimbolos = true;
        campo.classList.add("is-invalid"); // Agregar clase de Bootstrap para resaltar el campo
      }
    });
    // Mostrar alerta si hay campos con letras o símbolos
    if (contieneLetrasOSimbolos) {
      Swal.fire({
        title: "¡Attention!",
        text: "Correct fields where only numbers are valid",
        icon: "error",
        confirmButtonText: "Accept",
      });
      return false; // Detener el proceso
    }

    //Agregar un loading
    btnUpdate.disabled = true;
    divLoading.style.display = "flex";
    //creamos el fetch para mandar solicitudes http al servidor
    fetch(Base_URL + "/Usuarios/updateUsuario/" + idUsuario, {
      method: "POST",
      body: new FormData(formUsuarioUpdate),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la solicitud");
        }
        return response.json(); // Obtén la respuesta como JSON
      })
      .then((objData) => {
        if (objData.status) {
          if (rowTable == "") {
            tableUsuarios.ajax.reload();
          } else {
            htmlStatus =
              intStatus == 1
                ? '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>'
                : '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';

            rowTable.cells[1].textContent = strColaborador;
            rowTable.cells[2].textContent = strNombres;
            rowTable.cells[3].textContent = strApellidos;
            rowTable.cells[5].textContent = strUsuario;
            rowTable.cells[6].textContent = document.querySelector(
              "#listDepartamentoUpdate",
            ).selectedOptions[0].text;
            rowTable.cells[7].textContent =
              document.querySelector(
                "#listTipoRolUpdate",
              ).selectedOptions[0].text;
            rowTable.cells[8].innerHTML = htmlStatus;
            tableUsuarios.ajax.reload();
          }
          $("#modalUpdateUsuarios").modal("hide");
          formUsuarioUpdate.reset();
          Swal.fire({
            title: "Users",
            text: objData.msg,
            icon: "success",
            confirmButtonText: "Accept",
          });
        } else {
          Swal.fire({
            title: "Error",
            text: objData.msg,
            icon: "error",
            confirmButtonText: "Accept",
          });
        }
      })
      .catch((error) => {
        console.error("Error al procesar la respuesta del servidor:", error);
        Swal.fire({
          title: "¡Atención!",
          text: "Somethin happened in the process, verify code",
          icon: "error",
          confirmButtonText: "Accept",
        });
      })
      .finally(() => {
        divLoading.style.display = "none";
        btnUpdate.disabled = false;
      });
  };
}

//function para eliminar usuarios
function btnDeletedUser(idUsuario) {
  Swal.fire({
    title: "Delete user",
    text: "You really want to delete the user?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete",
    cancelButtonText: "No, cancel",
    reverseButtons: true,
    confirmButtonColor: "#800000",
    iconColor: "#800000",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(Base_URL + "/Usuarios/deleteUsuario/" + idUsuario, {
        method: "POST",
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la solicitud");
          }
          return response.json(); // Obtén la respuesta como JSON
        })
        .then((data) => {
          if (data.status) {
            Swal.fire({
              title: "Deleted",
              text: data.msg,
              icon: "success",
              confirmButtonText: "Accept",
            });
            tableUsuarios.ajax.reload();
          } else {
            Swal.fire({
              title: "Attention",
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
    }
  });
}
