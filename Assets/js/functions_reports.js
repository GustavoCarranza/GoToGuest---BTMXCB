let myChartSexta = null;
let myChartSeptima = null;
let myChartPrimera = null;
let myChartSegunda = null;
let myChartTercera = null;
let myChartCuarta = null;
let myChartQuinta = null;

//se almancenan las funciones
document.addEventListener("DOMContentLoaded", () => {
  clasificaciones();
  graficaQuejas();
  graficaQuejasxDepartamento();
  graficaDepartamentosQuejas();
  quejasporDepartamento();
  graficaTipoHuesped();
  graficaLugares();
  Filtro();
  calculoExternal();
  calculoSeveral();
});

//Funcion para calcular el numero de clasificaciones
function clasificaciones(startDate, endDate) {
  if (myChartSexta) {
    myChartSexta.destroy();
  }
  const ctx = document.getElementById("Clasificacion"); // Obtiene el contexto del canvas
  myChartSexta = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "bar", // Tipo de gráfico: barras
    data: {
      labels: [
        "Cleanliness & Condition",
        "Courtesy & Manners",
        "Efficiency",
        "Food & Beverage Quality",
        "Graciousness, Thoughtfulness & Sense of Personalized Service",
        "Guest Comfort & Convenience",
        "Sense of Luxury",
        "Staff Appearance",
        "Technical Execution, Skill & Knowledge",
        "Wellness",
        "Accident",
        "Food restriction/preference",
        "illness",
        "Possible Auditor",
      ], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Total", // Etiqueta de la barra
          backgroundColor: [
            // Colores de las barras
            "rgba(33, 62, 62, 0.4)",
            "rgba(131, 180, 255, 0.4)",
            "rgba(26, 33, 48, 0.4)",

            "rgba(137, 22, 82, 0.4)",
            "rgba(36, 10, 52, 0.4)",
            "rgba(234, 190, 108, 0.4)",

            "rgba(10, 104, 71, 0.4)",
            "rgba(160, 147, 125, 0.4)",
            "rgba(37, 67, 54, 0.4)",

            "rgba(118, 88, 39, 0.4)",
            "rgba(137, 129, 33 , 0.4)",
            "rgba(17, 106, 123 , 0.4)",
          ],
          borderColor: [
            "rgb(33, 62, 62)",
            "rgb(131, 180, 255)",
            "rgb(26, 33, 48)",

            "rgb(137, 22, 82)",
            "rgb(36, 10, 52)",
            "rgb(234, 190, 108)",

            "rgb(10, 104, 71)",
            "rgb(160, 147, 125)",
            "rgb(37, 67, 54)",

            "rgb(118, 88, 39)",
            "rgb(137, 129, 33)",
            "rgb(17, 106, 123)",
          ],
          borderWidth: 3, // Ancho del borde de las barras
          data: [], // Aquí se almacenarán los datos de las reservas por restaurante
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

  //Creamos un fetch para mandar solicitud http al servidor web
  fetch(
    `${Base_URL}/Reportes/getClasificaciones?startDate=${startDate}&endDate=${endDate}`
  )
    //la solicitud nos dara una respuesta en formato json
    .then((response) => response.json()) // Convierte la respuesta a JSON
    //Si la respuesta es verdadera ejecutara el codigo
    .then((data) => {
      const dataIndex = {
        "Cleanliness & Condition": 0,
        "Courtesy & Manners": 1,
        Efficiency: 2,
        "Food & Beverage Quality": 3,
        "Graciousness, Thoughtfulness & Sense of Personalized Service": 4,
        "Guest Comfort & Convenience": 5,
        "Sense of Luxury": 6,
        "Staff Appearance": 7,
        "Technical Execution, Skill & Knowledge": 8,
        Wellness: 9,
        Accident: 10,
        "Food restriction/preference": 11,
        "illness": 12,
        "Possible Auditor": 13,
      };

      //de la respuesta obtenida, creamos un forEach y colocamos un nombre
      data.forEach((clasificacion) => {
        //mandamos a traer la variable que tiene la grafica, accedemos a la respuesta del fetch y a los labels para las etiquetas y con el nombre del forEach iteramos a cada elemento que tengas en la consulta
        // Concatenamos el nombre del departamento y la queja para mostrarlos juntos en el gráfico
        myChartSexta.data.datasets[0].data[dataIndex[clasificacion.nombre]] =
          clasificacion.total;
      });
      // Actualiza la gráfica con los nuevos datos
      myChartSexta.update();
    })
    //En caso contrario que haya un error en la solicitud nos botara a un catch de error
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Funcion para las quejas mas concurrentes
function graficaQuejas(startDate, endDate) {
  // Destruye el gráfico existente si ya está creado
  if (myChartPrimera) {
    myChartPrimera.destroy();
  }
  const ctx = document.getElementById("QuejasDiarias");
  myChartPrimera = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [],
      datasets: [
        {
          label: "Total",
          backgroundColor: [
            "rgba(137, 22, 82, 0.4)",
            "rgba(36, 10, 52, 0.4)",
            "rgba(234, 190, 108, 0.4)",
            "rgba(10, 104, 71, 0.4)",
            "rgba(160, 147, 125, 0.4)",
          ],
          borderColor: [
            "rgb(137, 22, 82)",
            "rgb(36, 10, 52)",
            "rgb(234, 190, 108)",
            "rgb(10, 104, 71)",
            "rgb(160, 147, 125)",
          ],
          borderWidth: 3,
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
    `${Base_URL}/Reportes/getQuejasDiarias?startDate=${startDate}&endDate=${endDate}`
  )
    .then((response) => response.json())
    .then((data) => {
      data.forEach((quejas) => {
        myChartPrimera.data.labels.push(quejas.nombre);
        myChartPrimera.data.datasets[0].data.push(quejas.total_registros);
      });
      myChartPrimera.update();
    })
    .catch((error) => console.error(error));
}

//Funcion para calcular las 5 quejas mas concurrentes por departamento
function graficaQuejasxDepartamento(startDate, endDate) {
  if (myChartSegunda) {
    myChartSegunda.destroy();
  }
  const ctx = document.getElementById("QuejasxDepartamento"); // Obtiene el contexto del canvas
  myChartSegunda = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "bar", // Tipo de gráfico: barras
    data: {
      labels: [], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Total", // Etiqueta de la barra
          backgroundColor: [
            // Colores de las barras
            "rgba(10, 104, 71, 0.4)",
            "rgba(160, 147, 125, 0.4)",
            "rgba(37, 67, 54, 0.4)",
            "rgba(118, 88, 39, 0.4)",
            "rgba(137, 129, 33, 0.4)",
          ],
          borderColor: [
            "rgb(10, 104, 71)",
            "rgb(160, 147, 125)",
            "rgb(37, 67, 54)",
            "rgb(118, 88, 39)",
            "rgb(137, 129, 33)",
          ],
          borderWidth: 3, // Ancho del borde de las barras
          data: [], // Aquí se almacenarán los datos de las reservas por restaurante
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

  //Creamos un fetch para mandar solicitud http al servidor web
  fetch(
    `${Base_URL}/Reportes/getQuejasDepartamento?startDate=${startDate}&endDate=${endDate}`
  )
    //la solicitud nos dara una respuesta en formato json
    .then((response) => response.json()) // Convierte la respuesta a JSON
    //Si la respuesta es verdadera ejecutara el codigo
    .then((data) => {
      //de la respuesta obtenida, creamos un forEach y colocamos un nombre
      data.forEach((quejas) => {
        //mandamos a traer la variable que tiene la grafica, accedemos a la respuesta del fetch y a los labels para las etiquetas y con el nombre del forEach iteramos a cada elemento que tengas en la consulta
        // Concatenamos el nombre del departamento y la queja para mostrarlos juntos en el gráfico
        const label = quejas.departamento + ": " + quejas.queja;
        myChartSegunda.data.labels.push(label);
        // Agrega la cantidad de reservas del restaurante a los datos de la gráfica
        myChartSegunda.data.datasets[0].data.push(quejas.total_quejas);
      });
      // Actualiza la gráfica con los nuevos datos
      myChartSegunda.update();
    })
    //En caso contrario que haya un error en la solicitud nos botara a un catch de error
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Funcion para calcular los 5 departamentos con mas quejas
function graficaDepartamentosQuejas(startDate, endDate) {
  if (myChartTercera) {
    myChartTercera.destroy();
  }
  const ctx = document.getElementById("DepartamentosQuejas"); // Obtiene el contexto del canvas
  myChartTercera = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "bar", // Tipo de gráfico: barras
    data: {
      labels: [], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Total", // Etiqueta de la barra
          backgroundColor: [
            // Colores de las barras
            "rgba(36, 10, 52, 0.4)",
            "rgba(234, 190, 108, 0.4)",
            "rgba(10, 104, 71, 0.4)",
            "rgba(160, 147, 125, 0.4)",
            "rgba(54, 162, 235, 0.4)",
          ],
          borderColor: [
            "rgb(36, 10, 52)",
            "rgb(234, 190, 108)",
            "rgb(10, 104, 71)",
            "rgb(160, 147, 125)",
            "rgb(54, 162, 235)",
          ],
          borderWidth: 3, // Ancho del borde de las barras
          data: [], // Aquí se almacenarán los datos de las reservas por restaurante
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

  //Creamos un fetch para mandar solicitud http al servidor web
  fetch(
    `${Base_URL}/Reportes/getDepartamentosQuejas?startDate=${startDate}&endDate=${endDate}`
  )
    //la solicitud nos dara una respuesta en formato json
    .then((response) => response.json()) // Convierte la respuesta a JSON
    //Si la respuesta es verdadera ejecutara el codigo
    .then((data) => {
      //de la respuesta obtenida, creamos un forEach y colocamos un nombre
      data.forEach((quejas) => {
        //mandamos a traer la variable que tiene la grafica, accedemos a la respuesta del fetch y a los labels para las etiquetas y con el nombre del forEach iteramos a cada elemento que tengas en la consulta
        myChartTercera.data.labels.push(quejas.nombre);
        // Agrega la cantidad de reservas del restaurante a los datos de la gráfica
        myChartTercera.data.datasets[0].data.push(quejas.total_registros);
      });
      // Actualiza la gráfica con los nuevos datos
      myChartTercera.update();
    })
    //En caso contrario que haya un error en la solicitud nos botara a un catch de error
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Funcion para calcular el tipo de huesped
function graficaTipoHuesped(startDate, endDate) {
  if (myChartCuarta) {
    myChartCuarta.destroy();
  }
  const ctx = document.getElementById("TipoHuesped"); // Obtiene el contexto del canvas
  myChartCuarta = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "doughnut", // Tipo de gráfico: barras
    data: {
      labels: ["Due Out", "In house", "Special Care Guest", "Possible auditor"], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Total", // Etiqueta de la barra
          backgroundColor: [
            // Colores de las barras
            "rgba(255, 195, 0, 0.4)",
            "rgba(1, 124, 111, 0.4)",
            "rgba(88, 24, 69, 0.4)",
            "rgba(0, 99, 10, 0.4)",
          ],
          borderColor: [
            "rgb(255, 195, 0)",
            "rgb(1, 124, 111)",
            "rgb(88, 24, 69)",
            "rgb(0, 99, 10)",
          ],
          hoverOffset: 4,
          data: [],
        },
      ],
    },
  });

  //Creamos un fetch para mandar solicitud http al servidor web
  fetch(
    `${Base_URL}/Reportes/getTipoHuesped?startDate=${startDate}&endDate=${endDate}`
  )
    //la solicitud nos dara una respuesta en formato json
    .then((response) => response.json()) // Convierte la respuesta a JSON
    //Si la respuesta es verdadera ejecutara el codigo
    .then((data) => {
      const dataIndex = {
        "Due Out": 0,
        "In house": 1,
        "Special Care Guest": 2,
        "Possible auditor": 3,
      };

      //de la respuesta obtenida, creamos un forEach y colocamos un nombre
      data.forEach((huesped) => {
        //mandamos a traer la variable que tiene la grafica, accedemos a la respuesta del fetch y a los labels para las etiquetas y con el nombre del forEach iteramos a cada elemento que tengas en la consulta
        // Concatenamos el nombre del departamento y la queja para mostrarlos juntos en el gráfico
        myChartCuarta.data.datasets[0].data[dataIndex[huesped.categoria]] =
          huesped.total;
      });

      myChartCuarta.update();
    })
    //En caso contrario que haya un error en la solicitud nos botara a un catch de error
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Funcion para calcular el numero de quejas por departamento
function quejasporDepartamento(startDate, endDate) {
  if (myChartQuinta) {
    myChartQuinta.destroy();
  }
  const ctx = document.getElementById("QuejasporDepartamento"); // Obtiene el contexto del canvas
  myChartQuinta = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "bar", // Tipo de gráfico: barras
    data: {
      labels: [], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Total", // Etiqueta de la barra
          backgroundColor: [
            // Colores de las barras
            "rgba(118, 88, 39, 0.4)",
            "rgba(137, 129, 33, 0.4)",
            "rgba(17, 106, 123, 0.4)",
            "rgba(255, 205, 86, 0.4)",
            "rgba(201, 203, 207, 0.4)",
          ],
          borderColor: [
            "rgb(118, 88, 39)",
            "rgb(137, 129, 33)",
            "rgb(17, 106, 123)",
            "rgb(255, 205, 86)",
            "rgb(201, 203, 207)",
          ],
          borderWidth: 3, // Ancho del borde de las barras
          data: [], // Aquí se almacenarán los datos de las reservas por restaurante
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

  //Creamos un fetch para mandar solicitud http al servidor web
  fetch(
    `${Base_URL}/Reportes/getQuejasporDepartamento?startDate=${startDate}&endDate=${endDate}`
  )
    //la solicitud nos dara una respuesta en formato json
    .then((response) => response.json()) // Convierte la respuesta a JSON
    //Si la respuesta es verdadera ejecutara el codigo
    .then((data) => {
      //de la respuesta obtenida, creamos un forEach y colocamos un nombre
      data.forEach((quejas) => {
        //mandamos a traer la variable que tiene la grafica, accedemos a la respuesta del fetch y a los labels para las etiquetas y con el nombre del forEach iteramos a cada elemento que tengas en la consulta
        myChartQuinta.data.labels.push(quejas.nombre);
        // Agrega la cantidad de reservas del restaurante a los datos de la gráfica
        myChartQuinta.data.datasets[0].data.push(quejas.total_registros);
      });
      // Actualiza la gráfica con los nuevos datos
      myChartQuinta.update();
    })
    //En caso contrario que haya un error en la solicitud nos botara a un catch de error
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Funcion para calcular los 5 departamentos con mas quejas
function graficaLugares(startDate, endDate) {
  if (myChartSeptima) {
    myChartSeptima.destroy();
  }
  const ctx = document.getElementById("Lugares"); // Obtiene el contexto del canvas
  myChartSeptima = new Chart(ctx, {
    // Crea una instancia de Chart.js
    type: "bar", // Tipo de gráfico: barras
    data: {
      labels: [], // Etiquetas de los restaurantes
      datasets: [
        {
          label: "Total", // Etiqueta de la barra
          backgroundColor: [
            // Colores de las barras
            "rgba(131, 180, 255, 0.4)",
            "rgba(26, 33, 48, 0.4)",
            "rgba(137, 22, 82, 0.4)",
            "rgba(36, 10, 52, 0.4)",
            "rgba(234, 190, 108, 0.4)",
          ],
          borderColor: [
            "rgb(131, 180, 255)",
            "rgb(26, 33, 48)",
            "rgb(137, 22, 82)",
            "rgb(36, 10, 52)",
            "rgb(234, 190, 108)",
          ],
          borderWidth: 3, // Ancho del borde de las barras
          data: [], // Aquí se almacenarán los datos de las reservas por restaurante
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

  //Creamos un fetch para mandar solicitud http al servidor web
  fetch(
    `${Base_URL}/Reportes/getLugares?startDate=${startDate}&endDate=${endDate}`
  )
    //la solicitud nos dara una respuesta en formato json
    .then((response) => response.json()) // Convierte la respuesta a JSON
    //Si la respuesta es verdadera ejecutara el codigo
    .then((data) => {
      //de la respuesta obtenida, creamos un forEach y colocamos un nombre
      data.forEach((Lugares) => {
        //mandamos a traer la variable que tiene la grafica, accedemos a la respuesta del fetch y a los labels para las etiquetas y con el nombre del forEach iteramos a cada elemento que tengas en la consulta
        myChartSeptima.data.labels.push(Lugares.nombre);
        // Agrega la cantidad de reservas del restaurante a los datos de la gráfica
        myChartSeptima.data.datasets[0].data.push(Lugares.total_registros);
      });
      // Actualiza la gráfica con los nuevos datos
      myChartSeptima.update();
    })
    //En caso contrario que haya un error en la solicitud nos botara a un catch de error
    .catch((error) => console.error(error)); // Maneja cualquier error que pueda ocurrir
}

//Funcion para funcionar el filtro de fecha
function Filtro() {
  // Obtener los valores de las fechas seleccionadas por el usuario
  let startDate = document.getElementById("startDate").value;
  let endDate = document.getElementById("endDate").value;

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
  // Llamar a las funciones con las fechas seleccionadas
  try {
    clasificaciones(startDate, endDate);
    graficaQuejas(startDate, endDate);
    graficaQuejasxDepartamento(startDate, endDate);
    graficaDepartamentosQuejas(startDate, endDate);
    graficaTipoHuesped(startDate, endDate);
    quejasporDepartamento(startDate, endDate);
    graficaLugares(startDate, endDate);
  } catch (error) {
    console.error("Error calling functions:", error);
  }
}

//Funcion para calcular el porcentaje de villas external
function calculoExternal() {
  //Creamos una variable donde almacenamos el id
  const numero = document.getElementById("External");
  //Creamos un fetch para enviar la peticion al servidor y nos devuelva una respuesta
  fetch(Base_URL + "/Reportes/getContadorExternal", {
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
        const porcentajeExternal = parseFloat(
          data.data[0].porcentaje_External
        ).toFixed(0);
        numero.textContent = porcentajeExternal + "%";
      }
    })
    //Creamos un catch para el manejo de algun error
    .catch(() => {
      Swal.fire({
        title: "¡Attention!",
        text: "Somethin happened in the process, check code",
        icon: "error",
        confirmButtonText: "Accept",
      });
    });
}

//Funcion para calcular el porcentaje de villas external
function calculoSeveral() {
  //Creamos una variable donde almacenamos el id
  const numero = document.getElementById("Several");
  //Creamos un fetch para enviar la peticion al servidor y nos devuelva una respuesta
  fetch(Base_URL + "/Reportes/getContadorSeveral", {
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
        const porcentajeSeveral = parseFloat(
          data.data[0].porcentaje_Several
        ).toFixed(0);
        numero.textContent = porcentajeSeveral + "%";
      }
    })
    //Creamos un catch para el manejo de algun error
    .catch(() => {
      Swal.fire({
        title: "¡Attention!",
        text: "Somethin happened in the process, check code",
        icon: "error",
        confirmButtonText: "Accept",
      });
    });
}
