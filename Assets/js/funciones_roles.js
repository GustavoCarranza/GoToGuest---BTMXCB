let divLoading = document.querySelector("#divLoading");
let tableRoles;
let rowTable;

//Aqui se van agregar las funciones que se vayan creando
document.addEventListener("DOMContentLoaded", () => {
  fntRegistrosRoles();
  validarCampos();
  fntAgregarRoles();
});

//funcion para los registos de la tabla
function fntRegistrosRoles() {
  tableRoles = $("#table_roles").DataTable({
    procesing: true,
    responsive: true,
    columnDefs: [
      {
        targets: -1,
        responsivePriority: 1,
      },
    ],
    destroy: true,
    lengthMenu: [5, 10, 25, 50],
    pageLength: 5,
    order: [[0, "asc"]],
    ajax: {
      url: Base_URL + "/Roles/getRoles",
      dataSrc: "",
    },
    columns: [
      { data: "idRol", className: "text-center" },
      { data: "nombre", className: "text-center" },
      { data: "descripcion", className: "text-center" },
      { data: "status", className: "text-center" },
      { data: "fechaCreacion", className: "text-center" },
      { data: "horaCreacion", className: "text-center" },
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
          columns: [0, 1, 2, 4, 5], // Excluir la columna de acciones
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Excel",
        className: "btn btn-success col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 4, 5], // Excluir la columna de acciones
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "CSV",
        className: "btn btn-light col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 4, 5], // Excluir la columna de acciones
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

//Funcion para agregar roles
function fntAgregarRoles() {
  const btnRoles = document.getElementById("btnRoles");
  btnRoles.addEventListener("click", () => {
    $("#modalRoles").modal("show");
    document.querySelector("#formRoles").reset();

    const formRol = document.getElementById("formRoles");
    formRol.onsubmit = (e) => {
      e.preventDefault();

      //Creamos variables y capturamos el id de los inputs
      const strNombre = document.querySelector("#txtNombre");
      const strDescripcion = document.querySelector("#txtDescripcion");
      const intStatus = document.querySelector("#listStatus");
      //Validamos que los campos no vayan vacios
      if (strNombre == "" || strDescripcion == "" || intStatus == "") {
        Swal.fire({
          title: "¡Atención!",
          text: "All fields are required",
          icon: "error",
          confirmButtonText: "Aceptar",
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
          title: "¡Atención!",
          text: "Correct fields containing numbers or symbols",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return false; // Detener el proceso
      }
      divLoading.style.display = "flex";
      fetch(Base_URL + "/Roles/setRol", {
        method: "POST",
        body: new FormData(formRol),
      })
        .then((response) => {
          if (!response) {
            throw new Error("Error en la solicitud");
          }
          return response.json();
        })
        .then((data) => {
          if (data.status) {
            intStatus == 1
              ? '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>'
              : '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';
            $("#modalRoles").modal("hide");
            formRol.reset();
            Swal.fire({
              title: "Roles",
              text: data.msg,
              icon: "success",
              confirmButtonText: "Accept",
            });
            tableRoles.ajax.reload();
          } else {
            Swal.fire({
              title: "Roles",
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

//funcion para editar roles
function btnUpdateRol(idRol) {
  $("#modalUpdateRoles").modal("show");
  fetch(Base_URL + "/Roles/getRol/" + idRol, {
    method: "GET",
  })
    .then((response) => {
      if (!response) {
        throw new Error("Error en la solicitud");
      }
      return response.json();
    })
    .then((data) => {
      if (data.status) {
        document.querySelector("#idRol").value = data.data.idRol;
        document.querySelector("#txtNombreUpdate").value = data.data.nombre;
        document.querySelector("#txtDescripcionUpdate").value =
          data.data.descripcion;

        if (data.data.status == 1) {
          document.querySelector("#listStatusUpdate").value = 1;
        } else {
          document.querySelector("#listStatusUpdate").value = 2;
        }
      }
    })
    .catch(() => {
      Swal.fire({
        title: "¡Atención!",
        text: "Something happened in the process, check code",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });

  //ACTUALIZAR INFORMACIÓN
  const formRolesUpdate = document.getElementById("formRolesUpdate");
  formRolesUpdate.onsubmit = (e) => {
    e.preventDefault();

    //Creamos variables y capturamos el id de los inputs
    const strNombre = document.querySelector("#txtNombreUpdate").value;
    const strDescripcion = document.querySelector(
      "#txtDescripcionUpdate"
    ).value;
    const intStatus = document.querySelector("#listStatusUpdate").value;
    //Validamos que los campos no vayan vacios
    if (strNombre == "" || strDescripcion == "" || intStatus == "") {
      Swal.fire({
        title: "¡Attention!",
        text: "All fields are required",
        icon: "error",
        confirmButtonText: "Accept",
      });
      return false;
    }
    // Verificar si hay campos que contienen números o símbolos
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
        title: "¡Atención!",
        text: "Correct fields containing numbers or symbols",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return; // Detener el proceso
    }

    //Agregar un loading
    divLoading.style.display = "flex";
    fetch(Base_URL + "/Roles/updateRoles/" + idRol, {
      method: "POST",
      body: new FormData(formRolesUpdate),
    })
      .then((response) => {
        if (!response) {
          throw new Error("Error en la solicitud");
        }
        return response.json();
      })
      .then((data) => {
        if (data.status) {
          intStatus == 1
            ? '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>'
            : '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';
          $("#modalUpdateRoles").modal("hide");
          formRolesUpdate.reset();
          Swal.fire({
            title: "Roles",
            text: data.msg,
            icon: "success",
            confirmButtonText: "Accept",
          });
          tableRoles.ajax.reload();
        }else{
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
          confirmButtonText: "Aceptar",
        });
      });
    divLoading.style.display = "none";
    return false;
  };
}

//funcion para eliminar roles
function btnDeletedRol(idRol) {
  Swal.fire({
    title: "Delete role",
    text: "Do you really want to eliminate the role?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete",
    cancelButtonText: "No, cancel",
    reverseButtons: true,
    confirmButtonColor: "#800000",
    iconColor: "#800000",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(Base_URL + "/Roles/deleteRol/" + idRol, {
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
            tableRoles.ajax.reload();
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
    }
  });
}

//Funcion para otorgar permisos
function btnPermisos(idRol) {
  fetch(Base_URL + "/Permisos/getPermisosRol/" + idRol, {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.text();
    })
    .then((data) => {
      document.querySelector("#contentAjax").innerHTML = data;
      $("#modalPermisos").modal("show");
      document
        .querySelector("#formPermisos")
        .addEventListener("submit", fntSavePermisos, false);
    });
}

//Funcion para guardar los permisos al rol correspondiente
function fntSavePermisos(event) {
  event.preventDefault();
  let formElement = document.querySelector("#formPermisos");
  fetch(Base_URL + "/Permisos/setPermisos", {
    method: "POST",
    body: new FormData(formElement),
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
          title: "Permits granted",
          text: data.msg,
          icon: "success",
          confirmButtonText: "Accept",
        });
        $("#modalPermisos").modal("hide");
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
}
