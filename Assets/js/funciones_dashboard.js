var myChartCompensacion = null;
var myChartEstados = null;
var myChartCategoria = null;
var myChartHuesped = null;
var myChartNivel = null;
var intervaloRecarga; // Variable global para almacenar el intervalo
var tiempoInactividad = 10000; // 5 segundos de inactividad

//aqui se agregan las funciones que se ocupan durante este modulo
document.addEventListener("DOMContentLoaded", () => {
  fntCalculoGirs();
  fntCalculoSCG();
  fntCalculoAuditor();
  fntCalculoUsuarios();
  graficaEstados();
  graficaCategoria();
  graficaHuespedes();
  graficaNivel();
  compensaciones();
  cantidadCompensacion();
  FiltroCompensacion();
  calculoMomento();
  calculoAlto();
  calculoAlergia();
});


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
    recargarPagina(10000); // Reiniciar la recarga automática después de un período de inactividad
  }, tiempoInactividad);
}

// Evento para detectar la actividad del usuario
$(document).on('mousemove keydown scroll', function() {
  detenerRecargaAutomatica(); // Detener la recarga automática al detectar actividad del usuario
  clearTimeout(intervaloRecarga); // Limpiar el temporizador de reinicio
  reiniciarRecargaAutomaticaDespuesDeInactividad(); // Reiniciar la recarga automática después de un período de inactividad
});

// Llamar a la función para recargar la página cada 10 segundos
recargarPagina(10000);

//funcion para calculoar el numero de girs por dia
function fntCalculoGirs() {
  //Capturamos el id del div donde se va a mostrar el calculo
  const girs = document.getElementById("girs");
  //Creamos un fetch
  fetch(Base_URL + "/Dashboard/getContadorGirs", {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json();
    })
    .then((data) => {
      if (data.status && data.data.length > 0) {
        const contador = data.data[0].contadorGirs;
        girs.textContent = contador;
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

//Funcion para calcular el total de girs por dia que sean = "SCG"
function fntCalculoSCG() {
  //Capturamos el id del div donde se va a mostrar el calculo
  const girs = document.getElementById("scg");
  //Creamos un fetch
  fetch(Base_URL + "/Dashboard/getContadorSCG", {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json();
    })
    .then((data) => {
      if (data.status && data.data.length > 0) {
        const contador = data.data[0].contadorSCG;
        girs.textContent = contador;
      }
    })
    .catch(() => {
      Swal.fire({
        title: "¡Atención!",
        text: "Algo ocurrio durante el proceso, verficar código",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });
}

//Funcion para calcular el total de girs por dia que sean = "Possible auditor"
function fntCalculoAuditor() {
  //Capturamos el id del div donde se va a mostrar el calculo
  const girs = document.getElementById("posibleAuditor");
  //Creamos un fetch
  fetch(Base_URL + "/Dashboard/getContadorPA", {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json();
    })
    .then((data) => {
      if (data.status && data.data.length > 0) {
        const contador = data.data[0].contadorAuditor;
        girs.textContent = contador;
      }
    })
    .catch(() => {
      Swal.fire({
        title: "¡Atención!",
        text: "Algo ocurrio durante el proceso, verficar código",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });
}

//Funcion para calcular el total de usuarios
function fntCalculoUsuarios() {
  //Capturamos el id del div donde se va a mostrar el calculo
  const girs = document.getElementById("usuarios");
  //Creamos un fetch
  fetch(Base_URL + "/Dashboard/getContadorUsuarios", {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json();
    })
    .then((data) => {
      if (data.status && data.data.length > 0) {
        const contador = data.data[0].contadorUsuarios;
        girs.textContent = contador;
      }
    })
    .catch(() => {
      Swal.fire({
        title: "¡Atención!",
        text: "Algo ocurrio durante el proceso, verficar código",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });
}

//Funcion para calcular el numero de estados de girs
function graficaNivel() {
  if (myChartNivel) {
    myChartNivel.destroy();
  }
  const ctx = document.getElementById("Nivel"); // Obtiene el contexto del canvas
  myChartNivel = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "bar", // Tipo de gráfico: barras
    data: {
      labels: ["Low", "Medium", "High", "In stay", "Informative", "Wow moment"], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Total", // Etiqueta de la barra
          backgroundColor: [
            // Colores de las barras
            "rgba(33, 42, 62, 0.4)",
            "rgba(57, 72, 103, 0.4)",
            "rgba(60, 91, 111, 0.4)",
            "rgba(0, 81, 133, 0.4)",
            "rgba(103, 149, 179, 0.4)",
            "rgba(0, 122, 196, 0.4)",
          ],
          borderColor: [
            "rgb(33, 42, 62)",
            "rgb(57, 72, 103)",
            "rgb(60, 91, 111)",
            "rgb(0, 81, 133)",
            "rgb(103, 149, 179)",
            "rgb(0,122,196)",
          ],
          hoverOffset: 4,
          borderWidth: 1, // Ancho del borde de las barras
          data: [], // Aquí se almacenarán los datos de las reservas por restaurante
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true, // Comienza en cero en el eje Y
        },
      },
    },
  });

  //Creamos un fetch para mandar solicitud http al servidor web
  fetch(Base_URL + "/Dashboard/getNivel")
    //la solicitud nos dara una respuesta en formato json
    .then((response) => response.json()) // Convierte la respuesta a JSON
    //Si la respuesta es verdadera ejecutara el codigo
    .then((data) => {
      const dataIndex = {
        Low: 0,
        Medium: 1,
        High: 2,
        "In stay": 3,
        Informative: 4,
        "Wow moment": 5,
      };

      //de la respuesta obtenida, creamos un forEach y colocamos un nombre
      data.forEach((nivel) => {
        //mandamos a traer la variable que tiene la grafica, accedemos a la respuesta del fetch y a los labels para las etiquetas y con el nombre del forEach iteramos a cada elemento que tengas en la consulta
        // Concatenamos el nombre del departamento y la queja para mostrarlos juntos en el gráfico
        myChartNivel.data.datasets[0].data[dataIndex[nivel.nivel]] =
          nivel.total;
      });
      // Actualiza la gráfica con los nuevos datos
      myChartNivel.update();
    })
    //En caso contrario que haya un error en la solicitud nos botara a un catch de error
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Calculo en porcentaje de vaya momento semanalmente
function calculoMomento() {
  const numero = document.getElementById("momento");

  //Creamos un fetch
  fetch(Base_URL + "/Dashboard/getContadorMomento", {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json();
    })
    .then((data) => {
      if (data.status && data.data.length > 0) {
        const porcentajeWoowMoment = parseFloat(
          data.data[0].porcentaje_woow_moment
        ).toFixed(0); // Convertir a número y redondear a 2 decimales

        // Mostrar el porcentaje de "Woow moment" en el elemento HTML
        numero.textContent = porcentajeWoowMoment + "%";
      }
    })
    .catch(() => {
      Swal.fire({
        title: "¡Atención!",
        text: "Hubo un problema en el proceso, verifica el código",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });
}

//Calculo de porcentaje de Low semanalmente
function calculoAlto() {
  //Creamos una variable y capturamos el id del elemento html
  const numero = document.getElementById("Alto");
  //Creamos un fetch para enviar una peticion de tipo Get al servidor web
  fetch(Base_URL + "/Dashboard/getContadorAlto", {
    method: "GET",
  })
    //La peticion nos devolvera una respuesta y la validamos por si hay algun error y la convertimos a formato JsON para poder manipular
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json();
    })
    .then((data) => {
      if (data.status && data.data.length > 0) {
        const porcentajeAlto = parseFloat(data.data[0].porcentaje_Alto).toFixed(
          0
        ); // Convertir a número y redondear a 2 decimales

        // Mostrar el porcentaje de "Woow moment" en el elemento HTML
        numero.textContent = porcentajeAlto + "%";
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

//Calculo de porcentaje de Alergia semanalmente
function calculoAlergia() {
  //Creamos una variable donde capturamos el id del elemento HTML
  const numero = document.getElementById("Alergias");
  //Creamos un fetch para enviar la peticion al servidor web para que nos devuelva una respues
  fetch(Base_URL + "/Dashboard/getContadorAlergias", {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json();
    })
    .then((data) => {
      if (data.status && data.data.length > 0) {
        const porcentajeAlergia = parseFloat(
          data.data[0].porcentaje_Alergia
        ).toFixed(0); //Esto nos sirve para declarar cuentas decimales queremos despues del punto, en este caso ningun que sea entero

        //Mostrar el porcentaje
        numero.textContent = porcentajeAlergia + "%";
      }
    })
    //Creamos un catch para identificar errores si es que existen
    .catch(() => {
      Swal.fire({
        title: "¡Attention!",
        text: "Somethin happened in the process, check code",
        icon: "error",
        confirmButtonText: "Accept",
      });
    });
}

//Funcion para calcular el numero de estados de girs
function graficaEstados() {
  if (myChartEstados) {
    myChartEstados.destroy();
  }
  const ctx = document.getElementById("Estados"); // Obtiene el contexto del canvas
  myChartEstados = new Chart(ctx, {
    type: "pie", // Tipo de gráfico: pie
    data: {
      labels: ["Closed", "Open"], // Etiquetas de los estados
      datasets: [
        {
          label: "Total", // Etiqueta de la barra
          backgroundColor: [
            // Colores de las barras
            "rgba(102, 0, 0, 0.4)",
            "rgba(1, 96, 34, 0.4)",
          ],
          borderColor: ["rgb(102, 0, 0)", "rgb(1, 96, 34)"],
          hoverOffset: 4,
          data: [], // Aquí se almacenarán los datos de las reservas por restaurante
        },
      ],
    },
  });
  fetch(Base_URL + "/Dashboard/getEstados")
    //la solicitud nos dara una respuesta en formato json
    .then((response) => response.json()) // Convierte la respuesta a JSON
    //Si la respuesta es verdadera ejecutara el codigo
    .then((data) => {
      const dataIndex = {
        Closed: 0,
        Open: 1,
      };

      //de la respuesta obtenida, creamos un forEach y colocamos un nombre
      data.forEach((estado) => {
        //mandamos a traer la variable que tiene la grafica, accedemos a la respuesta del fetch y a los labels para las etiquetas y con el nombre del forEach iteramos a cada elemento que tengas en la consulta
        // Concatenamos el nombre del departamento y la queja para mostrarlos juntos en el gráfico
        myChartEstados.data.datasets[0].data[dataIndex[estado.estado]] =
          estado.total;
      });

      myChartEstados.update();
    })
    //En caso contrario que haya un error en la solicitud nos botara a un catch de error
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Funcion para calcular el numero de registros por categoria
function graficaCategoria() {
  if (myChartCategoria) {
    myChartCategoria.destroy();
  }
  const ctx = document.getElementById("Categoria"); // Obtiene el contexto del canvas
  myChartCategoria = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "doughnut", // Tipo de gráfico: barras
    data: {
      labels: ["Service", "Product", "Informative"], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Total", // Etiqueta de la barra
          backgroundColor: [
            // Colores de las barras
            "rgba(0, 81, 133, 0.4)",
            "rgba(103, 149, 179, 0.4)",
            "rgba(0, 122, 196, 0.4)",
          ],
          borderColor: [
            "rgb(0, 81, 133)",
            "rgb(103, 149, 179)",
            "rgb(0, 122, 196)",
          ],
          hoverOffset: 4,
          data: [], // Aquí se almacenarán los datos de las reservas por restaurante
        },
      ],
    },
  });

  //Creamos un fetch para mandar solicitud http al servidor web
  fetch(Base_URL + "/Dashboard/getCategoria")
    //la solicitud nos dara una respuesta en formato json
    .then((response) => response.json()) // Convierte la respuesta a JSON
    //Si la respuesta es verdadera ejecutara el codigo
    .then((data) => {
      const dataIndex = {
        Service: 0,
        Product: 1,
        Informative: 2,
      };

      //de la respuesta obtenida, creamos un forEach y colocamos un nombre
      data.forEach((categoria) => {
        //mandamos a traer la variable que tiene la grafica, accedemos a la respuesta del fetch y a los labels para las etiquetas y con el nombre del forEach iteramos a cada elemento que tengas en la consulta
        // Concatenamos el nombre del departamento y la queja para mostrarlos juntos en el gráfico
        myChartCategoria.data.datasets[0].data[dataIndex[categoria.categoria]] =
          categoria.total;
      });

      myChartCategoria.update();
    })
    //En caso contrario que haya un error en la solicitud nos botara a un catch de error
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Function para calcular el numeor de registros de huespedes in house y due out
function graficaHuespedes() {
  if (myChartHuesped) {
    myChartHuesped.destroy();
  }
  const ctx = document.getElementById("Huesped"); // Obtiene el contexto del canvas
  myChartHuesped = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "polarArea", // Tipo de gráfico: barras
    data: {
      labels: ["In house", "Due Out"], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Total", // Etiqueta de la barra
          backgroundColor: [
            // Colores de las barras
            "rgba(1, 96, 34, 0.4)",
            "rgba(102, 0, 0, 0.4)",
          ],
          borderColor: ["rgb(1, 96, 34)", "rgb(102, 0, 0)"],
          hoverOffset: 4,
          data: [], // Aquí se almacenarán los datos de las reservas por restaurante
        },
      ],
    },
  });

  //Creamos un fetch para mandar solicitud http al servidor web
  fetch(Base_URL + "/Dashboard/getHuesped")
    //la solicitud nos dara una respuesta en formato json
    .then((response) => response.json()) // Convierte la respuesta a JSON
    //Si la respuesta es verdadera ejecutara el codigo
    .then((data) => {
      const dataIndex = {
        "In house": 0,
        "Due Out": 1,
      };

      //de la respuesta obtenida, creamos un forEach y colocamos un nombre
      data.forEach((huesped) => {
        //mandamos a traer la variable que tiene la grafica, accedemos a la respuesta del fetch y a los labels para las etiquetas y con el nombre del forEach iteramos a cada elemento que tengas en la consulta
        // Concatenamos el nombre del departamento y la queja para mostrarlos juntos en el gráfico
        myChartHuesped.data.datasets[0].data[dataIndex[huesped.TipoGir]] =
          huesped.total;
      });

      myChartHuesped.update();
    })
    //En caso contrario que haya un error en la solicitud nos botara a un catch de error
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Funcion de compensaciones
function compensaciones() {
  tableGirs = $("#table_Compensacion").DataTable({
    procesing: true,
    responsive: true,
    columnDefs: [
      {
        targets: -3,
        responsiveriority: 3,
      },
    ],
    destroy: true,
    lengthMenu: [2, 10, 25, 50],
    pageLength: 2,
    ajax: {
      url: Base_URL + "/Dashboard/getCompensacion",
      dataSrc: "",
    },
    columns: [
      { data: "fecha", className: "text-center" },
      { data: "nombreDepartamento", className: "text-center" },
      { data: "sumaCompensacion", className: "text-center" },
    ],
    dom:
      "<'row'<'col-12 mb-3'B>>" + // Botones de exportación
      "<'row'<'col-12 mb-2'<<'col-12 mb-2'l> <<'col-12'f>>>>" + // Selector de longitud y cuadro de búsqueda
      "<'row'<'col-12 mb-4'tr>>" + // Tabla
      "<'row'<'col-12'p>>", // Paginación
    buttons: [
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Excel",
        className: "btn btn-success col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2], // Excluir la columna de acciones
        },
      },
    ],
  });
}

//Grafica de compensacion
function cantidadCompensacion(startDate, endDate) {
  if (myChartCompensacion) {
    myChartCompensacion.destroy();
  }
  const ctx = document.getElementById("CalculoCompensacion");
  myChartCompensacion = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [],
      datasets: [
        {
          label: "Total",
          backgroundColor: [
            "rgba(33, 42, 62, 0.4)",
            "rgba(57, 72, 103, 0.4)",
            "rgba(60, 91, 111, 0.4)",
            "rgba(0, 81, 133, 0.4)",
            "rgba(103, 149, 179, 0.4)",
            "rgba(0, 122, 196, 0.4)",
          ],
          borderColor: [
            "rgb(33, 42, 62)",
            "rgb(57, 72, 103)",
            "rgb(60, 91, 111)",
            "rgb(0, 81, 133)",
            "rgb(103, 149, 179)",
            "rgb(0,122,196)",
          ],
          hoverOffset: 4,
          borderWidth: 1,
          data: [],
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });

  fetch(
    `${Base_URL}/Dashboard/getCalculoCompensacion?startDate1=${startDate}&endDate1=${endDate}`
  )
    .then((response) => response.json())
    .then((data) => {
      // Limpiar datos antes de actualizar el gráfico
      myChartCompensacion.data.labels = [];
      myChartCompensacion.data.datasets[0].data = [];

      data.forEach((calculo) => {
        myChartCompensacion.data.labels.push(calculo.nombre);
        myChartCompensacion.data.datasets[0].data.push(calculo.totalCalculo);
      });
      myChartCompensacion.update(); // Actualizar el gráfico después de limpiar y agregar datos
    })
    .catch((error) => console.error(error));
}

function FiltroCompensacion() {
  let startDate = document.getElementById("startDate1").value;
  let endDate = document.getElementById("endDate1").value;

  if (!startDate && !endDate) {
    let today = new Date();
    let currentDay = today.getDay(); // Día actual de la semana (0: Domingo, 1: Lunes, ..., 6: Sábado)
    let diffFromMonday = currentDay === 0 ? 6 : currentDay - 1; // Diferencia de días desde el lunes
    let monday = new Date(today); // Clonar la fecha actual
    monday.setDate(today.getDate() - diffFromMonday); // Establecer la fecha al lunes de la semana actual
    let sunday = new Date(monday); // Clonar la fecha del lunes
    sunday.setDate(monday.getDate() + 6); // Establecer la fecha al domingo de la semana actual

    // Formatear las fechas al formato YYYY-MM-DD
    let format = (date) => {
      let dd = String(date.getDate()).padStart(2, "0");
      let mm = String(date.getMonth() + 1).padStart(2, "0");
      let yyyy = date.getFullYear();
      return `${yyyy}-${mm}-${dd}`;
    };

    startDate = format(monday);
    endDate = format(sunday);
  }

  cantidadCompensacion(startDate, endDate);
}
