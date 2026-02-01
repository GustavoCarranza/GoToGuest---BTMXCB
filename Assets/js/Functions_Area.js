let divLoading = document.querySelector("#divLoading");
let tableLugar;
let rowTable;

//Aqui se alojan las funcion a ejecutar una vez recarga la pagina
document.addEventListener("DOMContentLoaded", () => {
  fntRegistrosLugar();
  validarCampos();
  fntAgregarLugares();
});

//funcion para mostrar los registros en la tabla
function fntRegistrosLugar() {
  tableLugar = $("#table_lugares").DataTable({
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
      url: Base_URL + "/Lugar/getLugares",
      dataSrc: "",
    },
    columns: [
      { data: "idLugar", className: "text-center" },
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
        const contieneEspeciales = /[!@#$%^*()_+\=\[\]{};':"\\|,.<>\?]+/.test(
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
        const contieneEspeciales = /[!@#$%^*()_+\=\[\]{};':"\\|,.<>\?]+/.test(
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

//funcion para agregar lugares de quejas
function fntAgregarLugares() {
  const btnLugar = document.getElementById("btnLugar");
  const btn = document.getElementById("btn");
  btnLugar.addEventListener("click", () => {
    $("#modalLugar").modal("show");

    document.getElementById("formLugar").reset();
    const formLugar = document.getElementById("formLugar");
    formLugar.onsubmit = (e) => {
      e.preventDefault();

      //Creamos variable y capturamos el id de los inputs
      const strNombre = document.querySelector("#txtNombre");
      const strDescripcion = document.querySelector("#txtDescripcion");
      const intStatus = document.querySelector("#listStatus");

      //Validamos que los campos no vayan vacios
      if (strNombre == "" || strDescripcion == "" || intStatus == "") {
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
      //Cremos el fetch
      fetch(Base_URL + "/Lugar/setLugar", {
        method: "POST",
        body: new FormData(formLugar),
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

            $("#modalLugar").modal("hide");
            formLugar.reset();
            Swal.fire({
              title: "Place of opportunity",
              text: data.msg,
              icon: "success",
              confirmButtonText: "Accept",
            });
            tableLugar.ajax.reload();
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

//funcion para editar informacion de lugares de queja
function btnUpdateLugar(element, idLugar) {
  rowTable = element.parentNode.parentNode.parentNode;
  $("#modalUpdateLugar").modal("show");
  fetch(Base_URL + "/Lugar/getLugar/" + idLugar, {
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
        document.querySelector("#idLugar").value = data.data.idLugar;
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
        confirmButtonText: "Aceptar",
      });
    });

  //creamos una variable y capturamos el id del formulario
  const formLugarUpdate = document.querySelector("#formLugarUpdate");
  const btn = document.getElementById("btn");
  formLugarUpdate.onsubmit = (e) => {
    e.preventDefault();
    //Creamos variables y capturamos el id de los inputs
    const strNombre = document.querySelector("#txtNombreUpdate").value;
    const strDescripcion = document.querySelector(
      "#txtDescripcionUpdate",
    ).value;
    const intStatus = document.querySelector("#listStatusUpdate").value;

    //Creamos una validacion para comprobar que los campos no vayan vacios
    if (strNombre == "" || strDescripcion == "" || intStatus == "") {
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
    fetch(Base_URL + "/Lugar/updateLugares/" + idLugar, {
      method: "POST",
      body: new FormData(formLugarUpdate),
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
            tableLugar.ajax.reload();
          } else {
            htmlStatus =
              intStatus == 1
                ? '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>'
                : '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';

            rowTable.cells[1].textContent = strNombre;
            rowTable.cells[2].textContent = strDescripcion;
            rowTable.cells[3].innerHTML = htmlStatus;
          }
          $("#modalUpdateLugar").modal("hide");
          formLugarUpdate.reset();
          Swal.fire({
            title: "Place of opportunity",
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

//Funcion para eliminar lugares de queja
function btnDeletedLugar(idLugar) {
  Swal.fire({
    title: "Delete place of opportunity",
    text: "Do you really want to eliminate place of opportunity?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete",
    cancelButtonText: "No, cancel",
    reverseButtons: true,
    confirmButtonColor: "#800000",
    iconColor: "#800000",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(Base_URL + "/Lugar/deleteLugar/" + idLugar, {
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
            tableLugar.ajax.reload();
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
