let divLoading = document.querySelector("#divLoading");
let tableGirs;
let rowTable;

document.addEventListener("DOMContentLoaded", () => {
  fntGirsLow();
  fntOpcionesSelect()
  fntLugares()
  fntDepartamentos()
});

function fntGirsLow() {
  tableGirs = $("#table_Low").DataTable({
    procesing: true,
    responsive: true,
    columnDefs: [
      {
        targets: -4,
        responsivePriority: 4,
      },
    ],
    destroy: true,
    lengthMenu: [10, 25, 50],
    pageLength: 10,
    order: [
      [3, "desc"],
      [4, "desc"],
    ],
    ajax: {
      url: Base_URL + "/Registros/getRegistrosLow",
      dataSrc: "",
    },
    columns: [
      { data: "idGir", className: "text-center" },
      { data: "nombreQueja", className: "text-center" },
      { data: "nombreClasificacion", className: "text-center" },
      { data: "fecha", className: "text-center" },
      { data: "horaGir", className: "text-center" },
      { data: "apellidos", className: "text-center" },
      { data: "villa", className: "text-center" },
      { data: "entrada", className: "text-center" },
      { data: "salida", className: "text-center" },
      { data: "estadoGir", className: "text-center" },
      { data: "nivel", className: "text-center" },
      { data: "categoria", className: "text-center" },
      { data: "TipoGir", className: "text-center" },
      { data: "nombreLugar", className: "text-center" },
      { data: "nombreDepartamento", className: "text-center" },
      { data: "compensacion", className: "text-center" },
      { data: "imagen", className: "text-center" },
      { data: "options", className: "text-center", orderable: false },
      { data: "descripcion", visible: false },
      { data: "accionTomada", visible: false },
      { data: "seguimiento", visible: false },
    ],
    rowCallback: function (row, data) {
      //Mapeo de clases a colores
      const priorityColors = {
        "low-priority": "#269D00",
        "medium-priority": "#B9B700",
        "high-priority": "#800000",
        "inStay-priority": "#ea6b00",
        "informative-priority": "#00accb",
        "wowMoment-priority": "#3700c8",
      };
      //Verificamos si la clase existe en el objeto
      if (priorityColors[data.row_class]) {
        $(row).css({
          "background-color": priorityColors[data.row_class],
          color: "white",
        });
        $(row).children("td").css({
          color: "white",
        });
      }
    },
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
          columns: [
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 18, 19, 20,
          ], // Excluir la columna de acciones
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Excel",
        className: "btn btn-success col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 18, 19, 20,
          ], // Excluir la columna de acciones
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "CSV",
        className: "btn btn-light col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 18, 19, 20,
          ], // Excluir la columna de acciones
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

//Funcion para mostrar departamentos, lugar y quejas
function fntOpcionesSelect() {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");

  let ajaxUrl = Base_URL + "/Girs/getSelectQuejas";
  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState === 4 && request.status === 200) {
      // Carga las opciones al select de quejas
      document.querySelector("#listQueja").innerHTML = request.responseText;

      // Referencia a los selects y inputs
      const listQueja = document.querySelector("#listQueja");
      const inputClasificacionId = document.querySelector("#listClasificacion");       // Hidden input para enviar el ID
      const inputClasificacionNombre = document.querySelector("#listClasificacionNombre"); // Visible input para mostrar nombre

      // Función para actualizar los campos de clasificación al cambiar queja
      function actualizarClasificacion() {
        const selectedOption = listQueja.options[listQueja.selectedIndex];
        inputClasificacionId.value = selectedOption.getAttribute("data-clasificacion") || "";
        inputClasificacionNombre.value = selectedOption.getAttribute("data-nombreclas") || "";
      }

      // Inicializar valores al cargar opciones
      actualizarClasificacion();

      // Escuchar cambio en el select de quejas
      listQueja.addEventListener("change", actualizarClasificacion);

      fntLugares()
    }
  };
}

//Function para obtener el listado de lugares de quejas
function fntLugares() {
  //cremos un objeto XMLHttpRequest de forma segura esto nos sirve para haver solicitudes HTTP desde un navegador web
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  //Creamos una varaible donde le almacenados el metodo del helper donde esta la ruta raiz del proyecto y le concatenamos el controlador a ocupar y el metodo a crear
  let ajaxUrl = Base_URL + "/Girs/getSelectLugares";
  request.open("GET", ajaxUrl, true);
  request.send();
  //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector("#listLugar").innerHTML = request.responseText;
      document.querySelector("#listLugar").value = 1;
      document.querySelector("#listLugarUpdate").innerHTML =
        request.responseText;
      document.querySelector("#listLugarUpdate").value = 1;
      fntDepartamentos();
    }
  };
}

//Funcion para departamentos
function fntDepartamentos() {
  //cremos un objeto XMLHttpRequest de forma segura esto nos sirve para haver solicitudes HTTP desde un navegador web
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  //Creamos una varaible donde le almacenados el metodo del helper donde esta la ruta raiz del proyecto y le concatenamos el controlador a ocupar y el metodo a crear
  let ajaxUrl = Base_URL + "/Girs/getSelectDepartamentos";
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

// Función para previsualizar la imagen seleccionada
function previsualizarImagen(event) {
  console.log(event.target.files);
  if (event.target.files && event.target.files.length > 0) {
    const archivo = event.target.files[0]; // Obtener el archivo seleccionado por el usuario
    const nombreTemporal = URL.createObjectURL(archivo);
    //AGREGAR

    // Creamos variable donde capturamos el id del src para la imagen
    const imagenPreview = document.getElementById("imagen-preview");
    imagenPreview.src = nombreTemporal;
    imagenPreview.style.display = "block"; // Mostrar la imagen previsualizada
    // Mostrar el icono de eliminar
    const iconoCerrar = document.getElementById("icon-cerrar");
    //le añadimos un evento onclick y mandamos a llamar el evento deleteImg para eliminar la imagen
    iconoCerrar.innerHTML = `<button class="btn mb-2" onclick="deleteImg(event)" style="background:#800000; color:#fff;"> <i class="fas fa-times"></i></button>`;
    //Capturamos el id del icono para agregar imagen se va a ocultar unavez que hayamos seleccionado la imagen
    const icono = document.getElementById("icon-image");
    icono.classList.add("d-none");

    // Para editar

    // Creamos variable donde capturamos el id del src para la imagen
    const imagenPreviewU = document.getElementById("imagen-previewU");
    imagenPreviewU.src = nombreTemporal;
    imagenPreviewU.style.display = "block"; // Mostrar la imagen previsualizada
    //Mostramos el icono eliminar
    const iconoCerrarU = document.getElementById("icon-cerrarU");
    //Al boton le añadimos un evento onclick para eliminar la imagen
    iconoCerrarU.innerHTML = `<button class="btn mb-2" onclick="deleteImgUpdate(event)" style="background:#800000; color:#fff;"> <i class="fas fa-times"></i></button>`;
    //al boton para agregar lo ocultamos una vez que seleccionamos una imagen
    const iconoU = document.getElementById("icon-imageU");
    iconoU.classList.add("d-none");

    // Actualizar el valor del campo oculto para la imagen nueva
    const nombreImagenNueva = archivo.name;
    document.getElementById("foto_nueva").value = nombreImagenNueva;

    // Actualizar el valor de strImagen
    document.getElementById("foto_actual").value = nombreImagenNueva;

    // Resto del código para ocultar y mostrar elementos, y actualizar el nombre del archivo...
  }
}

// Función para eliminar la imagen previsualizada
function deleteImg(event) {
  event.preventDefault();
  //Agregar
  document.getElementById("icon-cerrar").innerHTML = "";
  const icono = document.getElementById("icon-image");
  icono.classList.remove("d-none");
  //Agregar
  const imagenPreview = document.getElementById("imagen-preview");
  imagenPreview.src = ""; // Eliminar la imagen previsualizada
  imagenPreview.style.display = "none"; // Ocultar la imagen previsualizada

  // Obtener el campo de entrada de archivos
  const inputImagen = document.getElementById("imagen");
  // Reiniciar el valor del campo de entrada de archivos
  inputImagen.value = null; // o inputImagen.value = undefined;
}

// Función para eliminar la imagen previsualizada en la modal de edición
function deleteImgUpdate(event) {
  event.preventDefault();
  document.getElementById("icon-cerrarU").innerHTML = "";
  const iconoU = document.getElementById("icon-imageU");
  iconoU.classList.remove("d-none");
  const imagenPreviewU = document.getElementById("imagen-previewU");
  imagenPreviewU.src = ""; // Eliminar la imagen previsualizada
  imagenPreviewU.style.display = "none"; // Ocultar la imagen previsualizada
  document.getElementById("foto_actual").value = "";
  document.getElementById("foto_delete").value = "";

  document.getElementById("imagenUpdate").value = "";
}

//Funcion para visualizar girs
function btnViewGir(idGir) {
  $("#modalViewGir").modal("show");
  fetch(Base_URL + "/Girs/getGir/" + idGir, {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json();
    })
    .then((objData) => {
      if (objData.status) {
        //Creamos una estructura switch para el campo de nivel para verificar la opcion que seleccione el usuario se torne de color correcto
        let optionSpanNivel;
        let intNivel;

        switch (objData.data.nivel) {
          case "Low":
            intNivel = objData.data.nivel;
            optionSpanNivel =
              '<span class="badge" style="background:#800000; color:#FFF; font-weight: bolder; padding: 5px; border-radius: 10px;"> Low </span>';
            break;
          case "Medium":
            intNivel = objData.data.nivel;
            optionSpanNivel =
              '<span class="badge" style="background:#B9B700; color:#fff; font-weight: bold; padding: 5px; border-radius: 10px;"> Medium </span>';
            break;
          case "High":
            intNivel = objData.data.nivel;
            optionSpanNivel =
              '<span class="badge" style="background:#269D00; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> High </span>';
            break;
          case "In stay":
            intNivel = objData.data.nivel;
            optionSpanNivel =
              '<span class="badge" style="background:#DE0B0B; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> In stay </span>';
            break;
          case "Informative":
            intNivel = objData.data.nivel;
            optionSpanNivel =
              '<span class="badge" style="background:#5E0094; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Informative </span>';
            break;
          case "Wow moment":
            intNivel = objData.data.nivel;
            optionSpanNivel =
              '<span class="badge" style="background:#0087B2; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Wow moment </span>';
            break;
        }

        document.querySelector("#cellClasificacion").innerHTML =
          objData.data.nombreClasificacion;
        document.querySelector("#cellFecha").innerHTML = objData.data.fecha;
        document.querySelector("#cellHora").innerHTML = objData.data.hora;
        document.querySelector("#cellApellidos").innerHTML =
          objData.data.apellidos;
        document.querySelector("#cellVilla").innerHTML = objData.data.villa;
        document.querySelector("#cellEntrada").innerHTML = objData.data.entrada;
        document.querySelector("#cellSalida").innerHTML = objData.data.salida;
        document.querySelector("#cellEstado").innerHTML =
          objData.data.estadoGir;
        document.querySelector("#cellNivel").innerHTML = optionSpanNivel;
        document.querySelector("#cellCategoria").innerHTML =
          objData.data.categoria;
        document.querySelector("#cellTipo").innerHTML = objData.data.TipoGir;
        document.querySelector("#cellQueja").innerHTML =
          objData.data.nombreQueja;
        document.querySelector("#cellLugar").innerHTML =
          objData.data.nombreLugar;
        document.querySelector("#cellDepartamento").innerHTML =
          objData.data.nombreDepartamento;
        document.querySelector("#cellDescripcion").innerHTML =
          objData.data.descripcion;
        document.querySelector("#cellAccion").innerHTML =
          objData.data.accionTomada;
        document.querySelector("#cellSeguimiento").innerHTML =
          objData.data.seguimiento;
        document.querySelector("#cellImagen").src =
          Media + "/Imagenes_almacenadas/" + objData.data.imagen;
        document.querySelector("#cellFechaCreacion").innerHTML =
          objData.data.dateCreate;
        document.querySelector("#cellCreador").innerHTML =
          objData.data.userCreate;
        document.querySelector("#cellFechaEdicion").innerHTML =
          objData.data.dateUpdate;
        document.querySelector("#cellEditor").innerHTML =
          objData.data.userUpdate;
        document.querySelector("#cellCompensacion").innerHTML =
          objData.data.compensacion;
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

// Función para editar girs
function btnUpdateGir(idGir) {
  document.getElementById("idGir").value = idGir;
  $("#modalGirsUpdate").modal("show");

  // 1. Primero, carga las opciones de queja (con data-clasificacion/nombre)
  fetch(Base_URL + "/Girs/getSelectQuejas")
    .then(res => res.text())
    .then(html => {
      document.getElementById("listQuejaUpdate").innerHTML = html;

      // 2. Luego, carga el registro completo
      return fetch(Base_URL + "/Girs/getGir/" + idGir);
    })
    .then(res => {
      if (!res.ok) throw new Error("Error fetching Girs");
      return res.json();
    })
    .then(objData => {
      if (!objData.status) throw new Error("Registro no encontrado");

      const data = objData.data;

      // Llenar campos
      document.querySelector("#compensacionUpdate").value = data.compensacion;
      document.querySelector("#txtFechaUpdate").value = data.fechaFinal;
      document.querySelector("#txtApellidosUpdate").value = data.apellidos;
      document.querySelector("#listVillaUpdate").value = data.villa;
      document.querySelector("#txtEntradaUpdate").value = data.fechaEntrada;
      document.querySelector("#txtSalidaUpdate").value = data.fechaSalida;
      document.querySelector("#listEstadoUpdate").value = data.estadoGir;
      document.querySelector("#listNivelUpdate").value = data.nivel;
      document.querySelector("#listCategoriaUpdate").value = data.categoria;
      document.querySelector("#listTipoUpdate").value = data.TipoGir;
      document.querySelector("#listLugarUpdate").value = data.idLugar;
      document.querySelector("#listDepartamentoUpdate").value = data.idDepartamento;
      document.querySelector("#txtDescripcionUpdate").value = data.descripcion;
      document.querySelector("#txtAccionUpdate").value = data.accionTomada;
      document.querySelector("#txtSeguimientoUpdate").value = data.seguimiento;

      // Imagen
      document.querySelector("#imagen-previewU").src = `${Media}/Imagenes_almacenadas/${data.imagen}`;
      document.querySelector("#icon-cerrarU").innerHTML =
        `<button class="btn mb-2" onclick="deleteImgUpdate(event)" style="background:#800000;color:#fff;"><i class="fas fa-times"></i></button>`;
      document.querySelector("#icon-imageU").classList.add("d-none");
      document.querySelector("#foto_actual").value = data.imagen;
      document.querySelector("#foto_delete").value = data.imagen;
      document.querySelector("#foto_nueva").value = data.imagen;

      // 3. Asignar la queja seleccionada y disparar change
      const selQ = document.getElementById("listQuejaUpdate");
      selQ.value = data.idQueja;
      selQ.dispatchEvent(new Event("change"));
    })
    .catch(err => {
      console.error(err);
      Swal.fire({ title: "Error", text: err.message, icon: "error", confirmButtonText: "Aceptar" });
    });

  // 4. Listener para cambios manuales de queja
  document.getElementById("listQuejaUpdate").onchange = function () {
    const opt = this.options[this.selectedIndex];
    const nombre = opt.getAttribute("data-nombreclas") || "";
    const idclas = opt.getAttribute("data-clasificacion") || "";

    document.getElementById("nombreClasificacionUpdate").value = nombre;
    document.getElementById("listClasificacionUpdate").value = idclas;
  };

  // 5. Manejar submit de actualización
  document.getElementById("formGirsUpdate").onsubmit = e => {
    e.preventDefault();
    const hidIdClas = document.getElementById("listClasificacionUpdate").value;
    if (!hidIdClas) {
      return Swal.fire({ title: "Error", text: "Error al obtener clasificación", icon: "error", confirmButtonText: "Aceptar" });
    }
    const formData = new FormData(e.target);
    const archivo = document.querySelector("#imagenUpdate").files[0];
    if (archivo) formData.append("imagenUpdate", archivo.name);

    divLoading.style.display = "flex";
    fetch(Base_URL + "/Girs/updateGirs/" + idGir, { method: "POST", body: formData })
      .then(r => r.json())
      .then(json => {
        divLoading.style.display = "none";
        if (json.status) {
          Swal.fire({ title: "GIRS", text: json.msg, icon: "success", confirmButtonText: "Aceptar" });
          $("#modalGirsUpdate").modal("hide");
          tableGirs.ajax.reload();
        } else {
          Swal.fire({ title: "Error", text: json.msg, icon: "error", confirmButtonText: "Aceptar" });
        }
      })
      .catch(err => {
        divLoading.style.display = "none";
        console.error(err);
        Swal.fire({ title: "Error", text: "Error al procesar solicitud", icon: "error", confirmButtonText: "Aceptar" });
      });

    return false;
  };
}


//Funcion para eliminar girs
function btnDeletedGir(idGir) {
  Swal.fire({
    title: "Delete Gir",
    text: "Do you really wanto to eliminate the Gir?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete",
    cancelButtonText: "No, cancel",
    reverseButtons: true,
    confirmButtonColor: "#800000",
    iconColor: "#800000",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(Base_URL + "/Girs/deleteGir/" + idGir, {
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
            tableGirs.ajax.reload();
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

//Funcion para historial de Gir

function btnHistoryGir(idGir) {
  // Limpiar contenido de los contenedores antes de mostrar el modal
  document.getElementById("historial_description").innerHTML = "";
  document.getElementById("historial_action").innerHTML = "";
  document.getElementById("historial_seguimiento").innerHTML = "";

  $("#historialModal").modal("show");
  fetch(Base_URL + "/Girs/getHistorial/" + idGir, {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((objdata) => {
      if (objdata.status) {
        console.log("respuesta:", objdata.data);
        // Iterar sobre los registros y agregar tarjetas
        objdata.data.forEach((record) => {
          // Crear tarjeta para Descriptions
          const descriptionCard = `
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-1">Description</h5>
                            <p class="mb-1">${record.descripcion_gir}</p>
                            <span class="">User: ${record.user}</span><br>
                            <span class="">Date: ${
                              record.fechaFormateada + " " + record.horaFormateada
                            }</span>
                        </div>
                    </div>
                `;
          document.getElementById("historial_description").innerHTML +=
            descriptionCard;

          // Crear tarjeta para Actions
          const actionCard = `
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-1">Action Taken</h5>
                            <p class="mb-1">${record.accion_gir}</p>
                            <span class="font-weight-bold fs-6">User: ${
                              record.user
                            }</span><br>
                            <span class="font-weight-bold fs-6">Date: ${
                              record.fechaFormateada + " " + record.horaFormateada
                            }</span>
                        </div>
                    </div>
                `;
          document.getElementById("historial_action").innerHTML += actionCard;

          // Crear tarjeta para Follow-Ups
          const followUpCard = `
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-1">Follow-Up</h5>
                            <p class="mb-1">${record.seguimiento_gir}</p>
                            <span class="">User: ${record.user}</span><br>
                            <span class="">Date: ${
                              record.fechaFormateada + " " + record.horaFormateada
                            }</span>
                        </div>
                    </div>
                `;
          document.getElementById("historial_seguimiento").innerHTML +=
            followUpCard;
        });
      } else {
        console.error("Error en la respuesta:", objdata.msg); // Aquí estaba el error
        alert("Error: " + objdata.msg);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Hubo un problema al obtener el historial.");
    });
}
