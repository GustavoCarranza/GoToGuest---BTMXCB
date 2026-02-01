let divLoading = document.querySelector("#divLoading");
let tableCompensation;
let rowTable;

document.addEventListener("DOMContentLoaded", () => {
  fntViewCompensation();
  validarCampos();
  fntAddCompensation();
});

//Funcion para mostrar registros en la tabla
function fntViewCompensation() {
  tableCompensation = $("#table_compensations").DataTable({
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
    pageLength: 10,
    order: [[0, "asc"]],
    ajax: {
      url: Base_URL + "/Compensations/getCompensations",
      dataSrc: "",
    },
    columns: [
      { data: "id_compensation", className: "text-center" },
      { data: "name", className: "text-center" },
      { data: "description", className: "text-center" },
      { data: "status", className: "text-center" },
      { data: "create_date", className: "text-center" },
      { data: "time_create", className: "text-center" },
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
        text: "<i class='fas fa-copy'></i> Copiar",
        titleAttr: "Copiar",
        className: "btn btn-secondary col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5], // Excluir la columna de acciones
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Excel",
        className: "btn btn-success col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5], // Excluir la columna de acciones
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "CSV",
        className: "btn btn-light col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5], // Excluir la columna de acciones
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
        const contieneCaracteresInvalidos = /[^a-zA-Z0-9()$% ]/.test(
          campo.value,
        );

        if (!contieneCaracteresInvalidos) {
          campo.classList.remove("is-invalid");
        } else {
          campo.classList.add("is-invalid");
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

//Funcion para agregar registros
function fntAddCompensation() {
  const btnCompensation = document.getElementById("btnCompensation");
  const btn = document.getElementById("btn");
  btnCompensation.addEventListener("click", () => {
    $("#modalCompensations").modal("show");

    document.getElementById("formCompensation").reset();
    const formComensation = document.getElementById("formCompensation");
    formComensation.onsubmit = (e) => {
      e.preventDefault();
      const strName = document.getElementById("txtName");
      const strDescription = document.getElementById("txtDescription");
      const intStatus = document.getElementById("listStatus");
      if (strName == "" || strDescription == "" || intStatus == "") {
        Swal.fire({
          title: "¡Attention!",
          text: "The fields are required",
          icon: "error",
          confirmButtonText: "Accept",
        });
        return false;
      }
      const camposTexto = document.querySelectorAll(".valid.validText");
      let contieneNumerosOSimbolos = false;
      camposTexto.forEach((campo) => {
        if (/[!@#^*_+\=\[\]{};':"\\|,.<>\?]/.test(campo.value)) {
          contieneNumerosOSimbolos = true;
          campo.classList.add("is-invalid");
        }
      });
      if (contieneNumerosOSimbolos) {
        Swal.fire({
          title: "¡Atención!",
          text: "Invalid fields containing numbers or symbols",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return false;
      }
      //Agregar un loading
      btn.disabled = true;
      divLoading.style.display = "flex";
      fetch(Base_URL + "/Compensations/setCompensation", {
        method: "POST",
        body: new FormData(formComensation),
      })
        .then((response) => {
          if (!response) {
            throw new Error("Error in the request");
          }
          return response.json();
        })
        .then((objData) => {
          if (objData.status) {
            intStatus == 1
              ? '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>'
              : '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';
            $("#modalCompensations").modal("hide");
            formComensation.reset();
            Swal.fire({
              title: "Compensations",
              text: objData.msg,
              icon: "success",
              confirmButtonText: "Accept",
            });
            tableCompensation.ajax.reload();
          } else {
            Swal.fire({
              title: "Error",
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
        })
        .finally(() => {
          divLoading.style.display = "none";
          btn.disabled = false;
        });
    };
  });
}

//Funcion para editar registros
function btnUpdateCompensation(element, id_compensation) {
  rowTable = element.parentNode.parentNode.parentNode;
  $("#modalCompensationsUpdate").modal("show");
  fetch(Base_URL + "/Compensations/getCompensation/" + id_compensation, {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error in the request");
      }
      return response.json();
    })
    .then((objData) => {
      if (objData.status) {
        document.getElementById("id_compensation").value =
          objData.data.id_compensation;
        document.getElementById("txtNameUpdate").value = objData.data.name;
        document.getElementById("txtDescriptionUpdate").value =
          objData.data.description;
        if (objData.data.status == 1) {
          document.getElementById("listStatusUpdate").value = 1;
        } else {
          document.getElementById("listStatusUpdate").value = 2;
        }
      }
    })
    .catch((error) => {
      Swal.fire({
        title: "¡Attention!",
        text: "Something happened in the process, error: " + error,
        icon: "error",
        confirmButtonText: "Accept",
      });
    });

  //Creamos el apartado de update
  const formCompensationUpdate = document.getElementById(
    "formCompensationUpdate",
  );
  const btn = document.getElementById("btn");

  formCompensationUpdate.onsubmit = (e) => {
    e.preventDefault();
    const strName = document.getElementById("txtNameUpdate").value;
    const strDescription = document.getElementById(
      "txtDescriptionUpdate",
    ).value;
    const intStatus = document.getElementById("listStatusUpdate").value;
    if (strName == "" || strDescription == "" || intStatus == "") {
      Swal.fire({
        title: "¡Attention!",
        text: "All fields are required",
        icon: "error",
        confirmButtonText: "Accept",
      });
      return false;
    }
    const camposTexto = document.querySelectorAll(".valid.validText");
    let contieneNumerosOSimbolos = false;
    camposTexto.forEach((campo) => {
      if (/[^a-zA-Z0-9()$% ]/.test(campo.value)) {
        contieneNumerosOSimbolos = true;
        campo.classList.add("is-invalid");
      }
    });
    if (contieneNumerosOSimbolos) {
      Swal.fire({
        title: "¡Atención!",
        text: "Correct fields containing numbers or symbols",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false; // Detener el proceso
    }

    //Agregar un loading
    btn.disabled = true;
    divLoading.style.display = "flex";
    fetch(Base_URL + "/Compensations/updateCompensations/" + id_compensation, {
      method: "POST",
      body: new FormData(formCompensationUpdate),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error in the request");
        }
        return response.json();
      })
      .then((objData) => {
        if (objData.status) {
          if (rowTable == "") {
            tableCompensation.ajax.reload();
          } else {
            htmlStatus =
              intStatus == 1
                ? '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>'
                : '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';

            rowTable.cells[1].textContent = strName;
            rowTable.cells[2].textContent = strDescription;
            rowTable.cells[3].innerHTML = htmlStatus;
          }
          $("#modalCompensationsUpdate").modal("hide");
          formCompensationUpdate.reset();
          Swal.fire({
            title: "Compensations",
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

//Funcion para eliminar registros
function btnDeletedCompensation(id_compensation) {
  Swal.fire({
    title: "Delete compensation",
    text: "Do you really wanto to eliminate compensation?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, Delete",
    cancelButtonText: "No, Cancel",
    reverseButtons: true,
    confirmButtonColor: "#800000",
    iconColor: "#800000",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(Base_URL + "/Compensations/deleteCompensation/" + id_compensation, {
        method: "POST",
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error in the request");
          }
          return response.json();
        })
        .then((objData) => {
          if (objData.status) {
            Swal.fire({
              title: "Deleted",
              text: objData.msg,
              icon: "success",
              confirmButtonText: "Accept",
            });
            tableCompensation.ajax.reload();
          } else {
            Swal.fire({
              title: "Attention",
              text: data.msg,
              icon: "error",
              confirmButtonText: "Accept",
            });
          }
        })
        .catch((error) => {
          Swal.fire({
            title: "¡Attention!",
            text: "Something happend in the process, error: " + error,
            icon: "error",
            confirmButtonText: "Accept",
          });
        });
      divLoading.style.display = "none";
      return false;
    }
  });
}
