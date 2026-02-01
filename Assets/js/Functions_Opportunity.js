let divLoading = document.querySelector("#divLoading");
let tableQuejas;
let rowTable;

//Aqui se alojan las funcion a ejecutar una vez recarga la pagina
document.addEventListener("DOMContentLoaded", () => {
  fntClasificaciones().then(() => {
    fntRegistrosQuejas();
  });

  validarCampos();
  fntAgregarQuejas();
});

//funcion para mostrar los registros en la tabla
function fntRegistrosQuejas() {
  tableQuejas = $("#table_quejas").DataTable({
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
      url: Base_URL + "/Quejas/getQuejas",
      dataSrc: "",
    },
    columns: [
      { data: "idQueja", className: "text-center" },
      { data: "nombre", className: "text-center" },
      { data: "descripcion", className: "text-center" },
      { data: "nombreClasificaciones", className: "text-center" },
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
        text: "<i class='fas fa-copy'></i> Copiar",
        titleAttr: "Copiar",
        className: "btn btn-secondary col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Excluir la columna de acciones
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Excel",
        className: "btn btn-success col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Excluir la columna de acciones
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "CSV",
        className: "btn btn-light col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6], // Excluir la columna de acciones
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
        const contieneEspeciales = /[!@#$%^&*()_+\=\[\]{};':"\\|,.<>\?]+/.test(
          campo.value,
        ); // Verifica si contiene caracteres especiales
        if (!contieneLetras && !contieneEspeciales) {
          campo.classList.remove("is-invalid"); // Remover clase de estilo si es válido
        } else {
          campo.classList.add("is-invalid"); // Agregar clase de estilo si contiene letras o caracteres especiales
        }
      }
    });
  });
}

//funcion para traer las clasficaciones
function fntClasificaciones(selectId = "listClasification") {
  return fetch(Base_URL + "/Quejas/getClasificaciones")
    .then((response) => {
      if (!response.ok) throw new Error("Error al obtener datos");
      return response.json();
    })
    .then((data) => {
      const select = document.getElementById(selectId);
      if (!select) {
        console.warn(`Elemento '${selectId}' no encontrado`);
        return;
      }

      select.innerHTML =
        '<option value="" disabled selected style="color:#800000;">⚠ Select a classification </option>';

      data.forEach((item) => {
        const option = document.createElement("option");
        option.value = item.id_clasificacion;
        option.textContent = item.nombre;
        select.appendChild(option);
      });
    })
    .catch((error) => {
      console.error("Error en fntClasificaciones:", error);
    });
}

//Funcion para agregar quejas
function fntAgregarQuejas() {
  const btnQuejas = document.getElementById("btnQuejas");
  const btn = document.getElementById("btn");
  btnQuejas.addEventListener("click", () => {
    $("#modalQuejas").modal("show");
    fntClasificaciones();

    document.getElementById("formQuejas").reset();
    const formQuejas = document.getElementById("formQuejas");
    formQuejas.onsubmit = (e) => {
      e.preventDefault();

      //Creamos variable y capturamos el id de los inputs
      const strNombre = document.querySelector("#txtNombre");
      const strDescripcion = document.querySelector("#txtDescripcion");
      const intClasificacion = document.querySelector("#listClasificationes");
      const intStatus = document.querySelector("#listStatus");

      //Validamos que los campos no vayan vacios
      if (
        strNombre == "" ||
        strDescripcion == "" ||
        intStatus == "" ||
        intClasificacion == ""
      ) {
        Swal.fire({
          title: "¡Attention!",
          text: "The fields are required",
          icon: "error",
          confirmButtonText: "Accept",
        });
        return false;
      }
      //Validar si que los campos tipos text no incluyan numero ni simbolos
      const camposTexto = document.querySelectorAll(".valid.validText");
      let contieneNumerosOSimbolos = false;
      camposTexto.forEach((campo) => {
        if (/[0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\?]/.test(campo.value)) {
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
      //Agregar un loading
      btn.disabled = true;
      divLoading.style.display = "flex";
      //Cremos el fetch
      fetch(Base_URL + "/Quejas/setQuejas", {
        method: "POST",
        body: new FormData(formQuejas),
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

            $("#modalQuejas").modal("hide");
            formQuejas.reset();
            Swal.fire({
              title: "Opportunity",
              text: data.msg,
              icon: "success",
              confirmButtonText: "Accept",
            });
            tableQuejas.ajax.reload();
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
  });
}

//funcion para editar quejas
function btnUpdateQueja(element, idQueja) {
  rowTable = element.parentNode.parentNode.parentNode;
  $("#modalUpdateQuejas").modal("show");
  fetch(Base_URL + "/Quejas/getQueja/" + idQueja, {
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
        fntClasificaciones("listClasificationUpdate").then(() => {
          const selectClasificacion = document.getElementById(
            "listClasificationUpdate",
          );
          if (selectClasificacion) {
            selectClasificacion.value = data.data.id_clasificacion;
          }
        });

        //Creamos variables y capturamos el id de los inputs
        document.querySelector("#idQueja").value = data.data.idQueja;
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
    .catch((error) => {
      console.error("Error al procesar la respuesta del servidor:", error);
      Swal.fire({
        title: "¡Attention!",
        text: "Something happened in the process, check code",
        icon: "error",
        confirmButtonText: "Accept",
      });
    });

  //creamos una variable y capturamos el id del formulario
  const formQuejasUpdate = document.querySelector("#formQuejasUpdate");
  const btn = document.getElementById("btn");
  formQuejasUpdate.onsubmit = (e) => {
    e.preventDefault();
    //Creamos variables y capturamos el id de los inputs
    const strNombre = document.querySelector("#txtNombreUpdate").value;
    const strDescripcion = document.querySelector(
      "#txtDescripcionUpdate",
    ).value;
    const intClasificacion = document.querySelector(
      "#listClasificationUpdate",
    ).value;
    const intStatus = document.querySelector("#listStatusUpdate").value;

    //Creamos una validacion para comprobar que los campos no vayan vacios
    if (
      strNombre == "" ||
      strDescripcion == "" ||
      intStatus == "" ||
      intClasificacion == ""
    ) {
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
      if (/[0-9!@#$%^*()_+\=\[\]{};':"\\|,.<>\?]/.test(campo.value)) {
        contieneNumerosOSimbolos = true;
        campo.classList.add("is-invalid"); // Agregar clase de Bootstrap para resaltar el campo
      }
    });
    // Mostrar alerta si hay campos con números o símbolos
    if (contieneNumerosOSimbolos) {
      Swal.fire({
        title: "¡Atención!",
        text: "Campos correctos conteniendo números o símbolos",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false; // Detener el proceso
    }

    //Agregar un loading
    btn.disabled = true;
    divLoading.style.display = "flex";
    //creamos el fetch para mandar solicitudes http al servidor
    fetch(Base_URL + "/Quejas/updateQuejas/" + idQueja, {
      method: "POST",
      body: new FormData(formQuejasUpdate),
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
            tableQuejas.ajax.reload();
          } else {
            htmlStatus =
              intStatus == 1
                ? '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>'
                : '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';

            rowTable.cells[1].textContent = strNombre;
            rowTable.cells[2].textContent = strDescripcion;
            rowTable.cells[3].textContent = document.querySelector(
              "#listClasificationUpdate option:checked",
            ).textContent;
            rowTable.cells[4].innerHTML = htmlStatus;
          }
          $("#modalUpdateQuejas").modal("hide");
          formQuejasUpdate.reset();
          Swal.fire({
            title: "Opportunity",
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

//Funcion para eliminar quejas
function btnDeletedQueja(idQueja) {
  Swal.fire({
    title: "Delete opportunity",
    text: "Do you really want to eliminate the opportunity?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete",
    cancelButtonText: "No, cancel",
    reverseButtons: true,
    confirmButtonColor: "#800000",
    iconColor: "#800000",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(Base_URL + "/Quejas/deleteQueja/" + idQueja, {
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
            tableQuejas.ajax.reload();
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
