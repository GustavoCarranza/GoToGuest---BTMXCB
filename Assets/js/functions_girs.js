let divLoading = document.querySelector("#divLoading");
let tableGirs;
let rowTable;
var intervaloRecarga; // Variable global para almacenar el intervalo
var tiempoInactividad = 45000; // 15 segundos de inactividad

//Tendran almacenadas las funcion a ejecutar en el DOM
document.addEventListener("DOMContentLoaded", () => {
  getDepartamentosFilter();
  getQuejasFilter();
  fntRegistrosGirs();
  initFiltros();
  validarCampos();
  fntOpcionesSelect();
  fntAgregarGirs();
  fntReporte();
  fntReporteFiltro();
  fntReporteAlergias();
});

//Obtener departamentos para el filtro
function getDepartamentosFilter() {
  fetch(Base_URL + "/Girs/getDepartamentosFilter", {
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
        const departamentos = objData.data;
        const select = document.getElementById("filter-department");

        // Añadir la opción predeterminada al principio del select
        const defaultOption = document.createElement("option");
        defaultOption.value = "default"; // O puedes poner un valor que indique 'sin selección', como 'default'
        defaultOption.textContent = "Select Department"; // El texto que quieres que se vea
        select.appendChild(defaultOption);

        departamentos.forEach((departamento) => {
          const option = document.createElement("option");
          option.value = departamento.idDepartamento;
          option.textContent = departamento.nombre;
          select.appendChild(option);
        });
      } else {
        console.log("No se encontraron departamentos");
      }
    })
    .catch((error) => {
      console.error("Error al obtener los deaprtamentos: ", error);
    });
}

//Obtener quejas para el filtro
function getQuejasFilter() {
  fetch(Base_URL + "/Girs/getQuejasFilter", {
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
        const quejas = objData.data;
        const select = document.getElementById("filter-oportunity");

        const defaultOption = document.createElement("option");
        defaultOption.value = "default";
        defaultOption.textContent = "Select Opportunity";
        select.appendChild(defaultOption);

        quejas.forEach((queja) => {
          const option = document.createElement("option");
          option.value = queja.idQueja;
          option.textContent = queja.nombre;
          select.appendChild(option);
        });
      } else {
        console.log("No se encontraron quejas");
      }
    })
    .catch((error) => {
      console.error("Error al obtener las quejas: ", error);
    });
}
// Función para mostrar los registros en la tabla
function fntRegistrosGirs() {
  tableGirs = $("#table_girs").DataTable({
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
      url: Base_URL + "/Girs/getGirs",
      data: function (d) {
        d.tipoHuesped =
          document.getElementById("filter-type").value === "default" ||
          document.getElementById("filter-type").value === ""
            ? ""
            : document.getElementById("filter-type").value;

        d.categoria =
          document.getElementById("filter-category").value === "default" ||
          document.getElementById("filter-category").value === ""
            ? ""
            : document.getElementById("filter-category").value;

        d.villa =
          document.getElementById("filter-villa").value === "default" ||
          document.getElementById("filter-villa").value === ""
            ? ""
            : document.getElementById("filter-villa").value;

        d.prioridad =
          document.getElementById("filter-priority").value === "default" ||
          document.getElementById("filter-priority").value === ""
            ? ""
            : document.getElementById("filter-priority").value;

        d.departamentos =
          document.getElementById("filter-department").value === "default" ||
          document.getElementById("filter-department").value === ""
            ? ""
            : document.getElementById("filter-department").value;

        d.oportunidad =
          document.getElementById("filter-oportunity").value === "default" ||
          document.getElementById("filter-oportunity").value === ""
            ? ""
            : document.getElementById("filter-oportunity").value;

        d.creacion_start =
          document.getElementById("filter-creation-start").value === "default" ||
          document.getElementById("filter-creation-start").value === ""
            ? ""
            : document.getElementById("filter-creation-start").value;

        d.creacion_end = 
            document.getElementById("filter-creation-end").value === "defaukt" ||
            document.getElementById("filter-creation-end").value === ""
            ? ""
            : document.getElementById("filter-creation-end").value;

        d.entrada =
          document.getElementById("filter-entrada").value === "default" ||
          document.getElementById("filter-entrada").value === ""
            ? ""
            : document.getElementById("filter-entrada").value;

        d.salida =
          document.getElementById("filter-salida").value === "default" ||
          document.getElementById("filter-salida").value === ""
            ? ""
            : document.getElementById("filter-salida").value;
      },
      dataSrc: "",
    },
    columns: [
      { data: "idGir", className: "text-center" },
      { data: "nombreQueja", className: "text-center" },
      { data: "clasificacion", className: "text-center" },
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

//Escuchar los cambios en los filtros
function initFiltros() {
  const filters = [
    "filter-type",
    "filter-category",
    "filter-villa",
    "filter-priority",
    "filter-department",
    "filter-oportunity",
    "filter-creation-start",
    "filter-creation-end",
    "filter-entrada",
    "filter-salida",
  ];
  filters.forEach((id) => {
    document.getElementById(id).addEventListener("change", () => {
      fntRegistrosGirs();
    });
  });
}

// Función para recargar la página en un determinado tiempo
function recargarPagina(tiempo) {
  intervaloRecarga = setInterval(() => {
    location.reload();
  }, tiempo);
}

// Función para detener el intervalo de recarga de la página
function detenerRecargaAutomatica() {
  clearInterval(intervaloRecarga); // Detener el intervalo de recarga
}

// Función para reiniciar el intervalo de recarga de la página después de un período de inactividad
function reiniciarRecargaAutomaticaDespuesDeInactividad() {
  detenerRecargaAutomatica(); // Detener la recarga automática
  intervaloRecarga = setTimeout(() => {
    recargarPagina(45000); // Reiniciar la recarga automática después de un período de inactividad
  }, tiempoInactividad);
}

// Evento para detectar la actividad del usuario
$(document).on("mousemove keydown scroll", function () {
  detenerRecargaAutomatica(); // Detener la recarga automática al detectar actividad del usuario
  clearTimeout(intervaloRecarga); // Limpiar el temporizador de reinicio
  reiniciarRecargaAutomaticaDespuesDeInactividad(); // Reiniciar la recarga automática después de un período de inactividad
});

// Llamar a la función para recargar la página cada 15 segundos
recargarPagina(45000);

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
  //cremos un objeto XMLHttpRequest de forma segura esto nos sirve para haver solicitudes HTTP desde un navegador web
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  //Creamos una varaible donde le almacenados el metodo del helper donde esta la ruta raiz del proyecto y le concatenamos el controlador a ocupar y el metodo a crear
  let ajaxUrl = Base_URL + "/Girs/getSelectQuejas";
  request.open("GET", ajaxUrl, true);
  request.send();
  //con la variable request agregamos un evento para monitorear el progreso de la solicitud XMLHttpRequest y manejar la respuesta recibida del servidor
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector("#listQueja").innerHTML = request.responseText;
      document.querySelector("#listQueja").value = 1;

      document.querySelector("#listQuejaUpdate").innerHTML =
        request.responseText;
      document.querySelector("#listQuejaUpdate").value = 1;

      fntLugares();
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

//Funcion para agregar girs
function fntAgregarGirs() {
  const btnGirs = document.getElementById("btnGirs");
  btnGirs.addEventListener("click", () => {
    deleteImg(event);
    document.querySelector("#formGirs").reset();
    $("#modalGirs").modal("show");

    const formGirs = document.getElementById("formGirs");
    formGirs.onsubmit = (e) => {
      e.preventDefault();

      //Creamos variables donde le capturamos el id de los inputs
      const strClasiicacion = document.querySelector("#listClasificacion");
      const strCompensacion = document.querySelector("#compensacion");
      const strFecha = document.querySelector("#txtFecha");
      const strApellidos = document.querySelector("#txtApellidos");
      const intVilla = document.querySelector("#listVilla");
      const strEntrada = document.querySelector("#txtEntrada");
      const strSalida = document.querySelector("#txtSalida");
      const intEstado = document.querySelector("#listEstado");
      const intNivel = document.querySelector("#listNivel");
      const intCategoria = document.querySelector("#listCategoria");
      const intTipo = document.querySelector("#listTipo");
      const intQueja = document.querySelector("#listQueja");
      const intLugar = document.querySelector("#listLugar");
      const intDepartamento = document.querySelector("#listDepartamento");
      const strDescripcion = document.querySelector("#txtDescripcion");
      const strAccion = document.querySelector("#txtAccion");
      const strSeguimiento = document.querySelector("#txtSeguimiento");
      const strImagen = document.querySelector("#imagen");
      const archivo = strImagen.files[0];
      let nombreImagen = null;

      // Verificar si se seleccionó una imagen
      if (archivo) {
        nombreImagen = archivo.name;
      }

      //realizamos una validacion para comprobar que los campos no vayan vacios
      if (
        strClasiicacion == "" ||
        strFecha == "" ||
        strApellidos == "" ||
        intVilla == "" ||
        strEntrada == "" ||
        strSalida == "" ||
        intEstado == "" ||
        intNivel == "" ||
        intCategoria == "" ||
        intTipo == "" ||
        intQueja == "" ||
        intLugar == "" ||
        intDepartamento == "" ||
        strDescripcion == "" ||
        strAccion == "" ||
        strSeguimiento == ""
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

      const formData = new FormData(formGirs);
      formData.append("nombreImagen", nombreImagen);

      //Agregar un loading
      divLoading.style.display = "flex";
      //Creamos el fetch
      fetch(Base_URL + "/Girs/setGirs", {
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
            //Creamos una estructura switch para el campo de estado para verificar la opcion que seleccione el usuario se torne de color correcto
            let optionSpan;
            //Creamos una estructura switch para el campo de nivel para verificar la opcion que seleccione el usuario se torne de color correcto
            switch (intNivel) {
              case "Low":
                optionSpan =
                  '<span class="badge" style="background:#800000; color:#FFF; font-weight: bolder; padding: 5px; border-radius: 10px;"> Alto </span>';
                break;
              case "Medium":
                optionSpan =
                  '<span class="badge" style="background:#B9B700; color:#fff; font-weight: bold; padding: 5px; border-radius: 10px;"> Medio </span>';
                break;
              case "High":
                optionSpan =
                  '<span class="badge" style="background:#269D00; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Bajo </span>';
              case "In stay":
                optionSpan =
                  '<span class="badge" style="background:#DE0B0B; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Bajo </span>';
              case "Informative":
                optionSpan =
                  '<span class="badge" style="background:#5E0094; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Bajo </span>';
              case "Wow moment":
                optionSpan =
                  '<span class="badge" style="background:#0087B2; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Bajo </span>';
                break;
            }

            $("#modalGirs").modal("hide");
            formGirs.reset();
            Swal.fire({
              title: "¡Girs!",
              text: objData.msg,
              icon: "success",
              confirmButtonText: "Accept",
            });
            tableGirs.ajax.reload();
          } else {
            Swal.fire({
              title: "¡Error!",
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
      divLoading.style.display = "none";
      return false;
    };
  });
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
          objData.data.clasificacion;
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
  // Rellenar los campos del modal de actualización
  document.getElementById("idGir").value = idGir;
  $("#modalGirsUpdate").modal("show");

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
        // Llenar los campos del formulario con los datos del giro

        document.querySelector("#listClasificacionUpdate").value =
          objData.data.clasificacion;
        document.querySelector("#compensacionUpdate").value =
          objData.data.compensacion;
        document.querySelector("#txtFechaUpdate").value =
          objData.data.fechaFinal;
        document.querySelector("#txtApellidosUpdate").value =
          objData.data.apellidos;
        document.querySelector("#listVillaUpdate").value = objData.data.villa;
        document.querySelector("#txtEntradaUpdate").value =
          objData.data.fechaEntrada;
        document.querySelector("#txtSalidaUpdate").value =
          objData.data.fechaSalida;
        document.querySelector("#listEstadoUpdate").value =
          objData.data.estadoGir;
        document.querySelector("#listNivelUpdate").value = objData.data.nivel;
        document.querySelector("#listCategoriaUpdate").value =
          objData.data.categoria;
        document.querySelector("#listTipoUpdate").value = objData.data.TipoGir;
        document.querySelector("#listQuejaUpdate").value = objData.data.idQueja;
        document.querySelector("#listLugarUpdate").value = objData.data.idLugar;
        document.querySelector("#listDepartamentoUpdate").value =
          objData.data.idDepartamento;
        document.querySelector("#txtDescripcionUpdate").value =
          objData.data.descripcion;
        document.querySelector("#txtAccionUpdate").value =
          objData.data.accionTomada;
        document.querySelector("#txtSeguimientoUpdate").value =
          objData.data.seguimiento;

        // Mostrar la imagen actual y configurar el botón para eliminarla
        document.querySelector("#imagen-previewU").src =
          Media + "/Imagenes_almacenadas/" + objData.data.imagen;
        const iconoCerrar = document.getElementById("icon-cerrarU");
        iconoCerrar.innerHTML = `<button class="btn mb-2" onclick="deleteImgUpdate(event)" style="background:#800000; color:#fff;"> <i class="fas fa-times"></i></button>`;
        document.querySelector("#icon-imageU").classList.add("d-none");

        // Establecer los valores de los campos ocultos para manejar la lógica en el backend
        document.querySelector("#foto_actual").value = objData.data.imagen;
        document.querySelector("#foto_delete").value = objData.data.imagen;
        document.querySelector("#foto_nueva").value = objData.data.imagen;
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

  // Actualizar registro
  const formGirsUpdate = document.getElementById("formGirsUpdate");
  formGirsUpdate.onsubmit = (e) => {
    e.preventDefault();
    // Capturar los valores de los campos del formulario
    const strClasiicacion = document.querySelector(
      "#listClasificacionUpdate"
    ).value;
    const strCompensacion = document.querySelector("#compensacionUpdate").value;
    const strFecha = document.querySelector("#txtFechaUpdate").value;
    const strApellidos = document.querySelector("#txtApellidosUpdate").value;
    const intVilla = document.querySelector("#listVillaUpdate").value;
    const strEntrada = document.querySelector("#txtEntradaUpdate").value;
    const strSalida = document.querySelector("#txtSalidaUpdate").value;
    const intEstado = document.querySelector("#listEstadoUpdate").value;
    const intNivel = document.querySelector("#listNivelUpdate").value;
    const intCategoria = document.querySelector("#listCategoriaUpdate").value;
    const intTipo = document.querySelector("#listTipoUpdate").value;
    const intQueja = document.querySelector("#listQuejaUpdate").value;
    const intLugar = document.querySelector("#listLugarUpdate").value;
    const intDepartamento = document.querySelector(
      "#listDepartamentoUpdate"
    ).value;
    const strDescripcion = document.querySelector(
      "#txtDescripcionUpdate"
    ).value;
    const strAccion = document.querySelector("#txtAccionUpdate").value;
    const strSeguimiento = document.querySelector(
      "#txtSeguimientoUpdate"
    ).value;

    // Capturar la imagen seleccionada
    const strImagen = document.querySelector("#imagenUpdate");
    //const archivo = strImagen.files[0];
    const archivo = strImagen.files.length > 0 ? strImagen.files[0] : null;
    // Obtener el nombre de la imagen actual
    const fotoActual = document.querySelector("#foto_actual").value;

    // Validar que los campos no estén vacíos
    if (
      strClasiicacion == "" ||
      strFecha == "" ||
      strApellidos == "" ||
      intVilla == "" ||
      strEntrada == "" ||
      strSalida == "" ||
      intEstado == "" ||
      intNivel == "" ||
      intCategoria == "" ||
      intTipo == "" ||
      intQueja == "" ||
      intLugar == "" ||
      intDepartamento == "" ||
      strDescripcion == "" ||
      strAccion == "" ||
      strSeguimiento == ""
    ) {
      Swal.fire({
        title: "¡Attention!",
        text: "All fields are required",
        icon: "error",
        confirmButtonText: "Accept",
      });
      return false;
    }

    const formData = new FormData(formGirsUpdate);
    //Verificar si se selecciono una imagen
    if (archivo) {
      const nombreImagen = archivo.name;
      // Crear FormData y agregar los campos del formulario
      formData.append("imagenUpdate", nombreImagen); // Agregar la imagen al FormData
    }
    // Mostrar el icono de carga
    divLoading.style.display = "flex";
    // Enviar la solicitud fetch al backend
    fetch(Base_URL + "/Girs/updateGirs/" + idGir, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status) {
          // Éxito
          Swal.fire({
            title: "Girs",
            text: data.msg,
            icon: "success",
            confirmButtonText: "Aceptar",
          });
          tableGirs.ajax.reload(); // Recargar la tabla
          $("#modalGirsUpdate").modal("hide"); // Cerrar el modal
          //Lo incluimos para que cuando editemos un registro con alguna fecha que no sea la actual se actualice el contador
          // Obtener el nuevo estado del gir después de la edición
          const estadoNuevo = document.querySelector("#listEstadoUpdate").value;
          // Verificar si el estado original era "Open" y el nuevo estado es "Closed"
        } else {
          // Error
          Swal.fire({
            title: "Error",
            text: data.msg,
            icon: "error",
            confirmButtonText: "Aceptar",
          });
        }
      })
      .catch((error) => {
        console.error("Error al procesar la solicitud:", error);
        Swal.fire({
          title: "¡Attention!",
          text: "Something happened in the process, check code",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      });
    // Ocultar el icono de carga
    divLoading.style.display = "none";
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

//Funcion para exportar el reporte diario
function fntReporte() {
  const FormReporte = document.querySelector("#formDQR");
  FormReporte.onsubmit = (e) => {
    e.preventDefault();
    //Nos permite mandar solicitudes HTTP, request al servidor y nos devuelve una respuesta
    fetch(Base_URL + "/Girs/getReporte", {
      method: "POST", // Método HTTP a utilizar en este caso es un tipo POST
      body: new FormData(FormReporte), // Datos del formulario a enviar
    })
      //Cuando la solicitud se completa le invocamos el metodo blob lo que hace es la respuesta nos la convierte en un objeto que representa datos binarios
      .then((response) => response.blob())
      //Y cuando se ha obtenido de manera correcta el blob sin marcar errores se ejecuta en el bloque del codigo
      .then((blob) => {
        //Creamos una variable y almacenamos un URL de objeto para el blob del pdf, estamos utilizando la funcion createObjectURL y le pasamos el blob, esta URL es temporal y se utilizara para crear el enlace de descarga
        const pdfUrl = URL.createObjectURL(blob);
        //Crear una constante y se almacena un nueveo elemento de tipo a en el DOM
        const link = document.createElement("a");
        link.href = pdfUrl;
        link.download = "DQR Report.pdf"; // Nombre del archivo PDF al descargar
        // Agregar el enlace al documento y hacer clic en él para iniciar la descarga, la funcion appendchild lo que hace es agregar un nodo hijo al final de la lista, en este caso lo estamos utilizando para agregar el enlace recien creado al cuerpo del documento HTML
        document.body.appendChild(link);
        //Finalmente se simula un click en el enlace y procede a la descarga
        link.click();
      })
      .catch((error) => {
        // Manejar errores de red u otros errores del servidor
        console.error("Error:", error);
      });
  };
}

//Funcion para exportar el reporte de girs por filtro de fecha
function fntReporteFiltro() {
  const btnReporteFiltro = document.getElementById("btnReporteFiltro");
  btnReporteFiltro.addEventListener("click", () => {
    $("#modalReporte").modal("show");
    document.getElementById("formReporte").reset();

    const formReporte = document.getElementById("formReporte");
    formReporte.onsubmit = (e) => {
      e.preventDefault();
      //Capturamos los id de los inputs
      const strFechaInicial = document.querySelector("#txtFechaInicial");
      const strFechaFinal = document.querySelector("#txtFechaFinal");
      //Creamos una validacion para que los campos no vayan vacios
      if (strFechaInicial == "" || strFechaFinal == "") {
        Swal.fire({
          title: "¡Attention!",
          text: "The fields are required",
          icon: "error",
          confirmButtonText: "Accept",
        });
        return false;
      }

      //Creamos el fetch para el reporte
      fetch(Base_URL + "/Girs/getReporteFiltro", {
        method: "POST",
        body: new FormData(formReporte),
      })
        //Cuando la solicitud se completa le invocamos el metodo blob lo que hace es la respuesta nos la convierte en un objeto que representa datos binarios
        .then((response) => response.blob())
        //Y cuando se ha obtenido de manera correcta el blob sin marcar errores se ejecuta en el bloque del codigo
        .then((blob) => {
          //Creamos una variable y almacenamos un URL de objeto para el blob del pdf, estamos utilizando la funcion createObjectURL y le pasamos el blob, esta URL es temporal y se utilizara para crear el enlace de descarga
          const pdfUrl = URL.createObjectURL(blob);
          //Crear una constante y se almacena un nueveo elemento de tipo a en el DOM
          const link = document.createElement("a");
          link.href = pdfUrl;
          link.download = "Report by date range DQR.pdf"; // Nombre del archivo PDF al descargar
          // Agregar el enlace al documento y hacer clic en él para iniciar la descarga, la funcion appendchild lo que hace es agregar un nodo hijo al final de la lista, en este caso lo estamos utilizando para agregar el enlace recien creado al cuerpo del documento HTML
          document.body.appendChild(link);
          //Finalmente se simula un click en el enlace y procede a la descarga
          link.click();
        })
        .catch((error) => {
          // Manejar errores de red u otros errores del servidor
          console.error("Error:", error);
        });
    };
  });
}

//Funcion para exportar el reporte diario
function fntReporteAlergias() {
  const FormReporte = document.querySelector("#formAlergias");
  FormReporte.onsubmit = (e) => {
    e.preventDefault();
    //Nos permite mandar solicitudes HTTP, request al servidor y nos devuelve una respuesta
    fetch(Base_URL + "/Girs/getReporteAlergias", {
      method: "POST", // Método HTTP a utilizar en este caso es un tipo POST
      body: new FormData(FormReporte), // Datos del formulario a enviar
    })
      //Cuando la solicitud se completa le invocamos el metodo blob lo que hace es la respuesta nos la convierte en un objeto que representa datos binarios
      .then((response) => response.blob())
      //Y cuando se ha obtenido de manera correcta el blob sin marcar errores se ejecuta en el bloque del codigo
      .then((blob) => {
        //Creamos una variable y almacenamos un URL de objeto para el blob del pdf, estamos utilizando la funcion createObjectURL y le pasamos el blob, esta URL es temporal y se utilizara para crear el enlace de descarga
        const pdfUrl = URL.createObjectURL(blob);
        //Crear una constante y se almacena un nueveo elemento de tipo a en el DOM
        const link = document.createElement("a");
        link.href = pdfUrl;
        link.download = "Allergy Report.pdf"; // Nombre del archivo PDF al descargar
        // Agregar el enlace al documento y hacer clic en él para iniciar la descarga, la funcion appendchild lo que hace es agregar un nodo hijo al final de la lista, en este caso lo estamos utilizando para agregar el enlace recien creado al cuerpo del documento HTML
        document.body.appendChild(link);
        //Finalmente se simula un click en el enlace y procede a la descarga
        link.click();
      })
      .catch((error) => {
        // Manejar errores de red u otros errores del servidor
        console.error("Error:", error);
      });
  };
}

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
