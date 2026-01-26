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
        const contieneNumeros = /\d/.test(campo.value); // Verifica si contiene números
        const contieneEspeciales = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\?]+/.test(
          campo.value,
        ); // Verifica si contiene caracteres especiales
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

//Funcion para agregar registros
function fntAddCompensation() {
  const btnCompensation = document.getElementById("btnCompensation");
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
        if (/[0-9!@#$%^*()_+\=\[\]{};':"\\|,.<>\?]/.test(campo.value)) {
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
