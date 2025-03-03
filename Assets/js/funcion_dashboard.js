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
  fntLow();
  fntMedium();
  fntHigh()
  fntInStay()
  fntInformative()
  fntWowMoment()
  fntInHouse()
  fntSpecialGuest()
  fntDueOut()
  fntPossibleAuditor()
  fntCalculoGirsMont()
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

//Funcion para calcular el total de Registros Low
function fntLow(){
    //Creamos una variable donde mandaremos a llamar al ID
    const Low = document.getElementById('Low')
    //Creamos el fetch
    fetch(Base_URL + "/Dashboard/getLow", {
        method: "GET",
    })
    .then((response) => {
        if(!response.ok){
            throw new Error("Error en la solicitud")
        }
        return response.json()
    })
    .then((data) => {
        if(data.status && data.data.length > 0){
            const contador = data.data[0].contadorLow
            Low.textContent = contador
        }else{
            Low.textContent = "0"
        }
    })
    .catch((error) => {
        console.error(error)
    })
}

//Funcion para calcular el total de registros Medium 
function fntMedium(){
    //Capturamos el ID del elemento 
    const Medium = document.getElementById('Medium')
    //Creamos el fetch
    fetch(Base_URL + '/Dashboard/getMedium', {
        method: "GET",
    })
    .then((response) => {
        if(!response.ok){
            throw new Error('Error en la solicitud')
        }
        return response.json()
    })
    .then((data) => {
        if(data.status && data.data.length > 0){
            const contador = data.data[0].contadorMedium
            Medium.textContent = contador
        }else{
            Medium.textContent = "0"
        }
    })
    .catch((error) => {
        console.error(error)
    })
}

//Funcion para calcular el total de registros High
function fntHigh(){
    //Capturamos el ID del elemento 
    const High = document.getElementById('High')
    //Creamos el fetch
    fetch(Base_URL + '/Dashboard/getHigh', {
        method: "GET",
    })
    .then((response) => {
        if(!response.ok){
            throw new Error('Error en la solicitud')
        }
        return response.json()
    })
    .then((data) => {
        if(data.status && data.data.length > 0){
            const contador = data.data[0].contadorHigh
            High.textContent = contador
        }else{
            High.textContent = "0"
        }
    })
    .catch((error) => {
        console.error(error)
    })
}

//Funcion para calcular el total de registros InStay
function fntInStay(){
    //Capturamos el ID del elemento 
    const InStay = document.getElementById('InStay')
    //Creamos el fetch
    fetch(Base_URL + '/Dashboard/getInStay', {
        method: "GET",
    })
    .then((response) => {
        if(!response.ok){
            throw new Error('Error en la solicitud')
        }
        return response.json()
    })
    .then((data) => {
        if(data.status && data.data.length > 0){
            const contador = data.data[0].contadorInStay
            InStay.textContent = contador
        }else{
            InStay.textContent = "0"
        }
    })
    .catch((error) => {
        console.error(error)
    })
}

//Funcion para calcular el total de registros Informative
function fntInformative(){
    //Capturamos el ID del elemento 
    const Informative = document.getElementById('Informative')
    //Creamos el fetch
    fetch(Base_URL + '/Dashboard/getInformative', {
        method: "GET",
    })
    .then((response) => {
        if(!response.ok){
            throw new Error('Error en la solicitud')
        }
        return response.json()
    })
    .then((data) => {
        if(data.status && data.data.length > 0){
            const contador = data.data[0].contadorInformative
            Informative.textContent = contador
        }else{
            Informative.textContent = "0"
        }
    })
    .catch((error) => {
        console.error(error)
    })
}

//Funcion para calcular el total de registros Wow Moment
function fntWowMoment(){
    //Capturamos el ID del elemento 
    const WowMoment = document.getElementById('WowMoment')
    //Creamos el fetch
    fetch(Base_URL + '/Dashboard/getWowMoment', {
        method: "GET",
    })
    .then((response) => {
        if(!response.ok){
            throw new Error('Error en la solicitud')
        }
        return response.json()
    })
    .then((data) => {
        if(data.status && data.data.length > 0){
            const contador = data.data[0].contadorWowMoment
            WowMoment.textContent = contador
        }else{
            WowMoment.textContent = "0"
        }
    })
    .catch((error) => {
        console.error(error)
    })
}

//Funcion para calcular el total de registros In house
function fntInHouse(){
  //Creamos una variable y alojamos el ID del elemento html
  const InHouse = document.getElementById('InHouse')
  //Creeamos el fecth para comunicar al controlador
  fetch(Base_URL + '/Dashboard/getInHouse', {
    method: 'GET',
  })
  .then((response) => {
    if(!response.ok){
      throw new Error('Error en la solicitud')
    }
    return response.json()
  })
  .then((data) => {
    if(data.status && data.data.length > 0){
      const contador = data.data[0].contadorInHouse
      InHouse.textContent = contador
    }else{
      InHouse.textContent = "0"
    }
  })
  .catch((error) => {
    console.error(error)
  })
}

//Funcion para calcular el total de registros Special Care Guest
function fntSpecialGuest(){
    //Capturamos el Id en una variable 
    const SpecialGuest = document.getElementById('specialGuest')
    //Creamos el fecth
    fetch(Base_URL + '/Dashboard/getSpecialGuest', {
        method: 'GET'
    })
    .then((response) => {
        if(!response.ok){
            throw new Error('Error en la solicitud')
        }
        return response.json()
    })
    .then((data) => {
        if(data.status && data.data.length > 0){
            const contador = data.data[0].contadorSpecialGuest
            SpecialGuest.textContent = contador
        }else{
            SpecialGuest.textContent = "0"
        }
    })
    .catch((error) => {
        console.error(error)
    })
}

//Funcion para calcular el total de registros Due Out
function fntDueOut(){
    //Capturamso el ID en una variable
    const dueOut = document.getElementById('dueOut')
    //Creamos el fetch
    fetch(Base_URL + '/Dashboard/getDueOut', {
        method: 'GET'
    })
    .then((response) => {
        if(!response.ok){
            throw new Error('Error en la solicitud')
        }
        return response.json()
    })
    .then((data) => {
        if(data.status && data.data.length > 0){
            const contador = data.data[0].contadorDueOut
            dueOut.textContent = contador
        }else{
            dueOut.textContent = "0"
        }
    })
    .catch((error) => {
        console.error(error)
    })
}

//Funcion para calcular el total de registros Possible Auditor
function fntPossibleAuditor(){
    //Capturamos el ID enuna variable 
    const possibleAuditor = document.getElementById('PossibleAuditor')
    //Creamos fetch
    fetch(Base_URL + '/Dashboard/getPossibleAuditor', {
        method: 'GET'
    })
    .then((response) => {
        if(!response.ok){
            throw new Error('Error en la solicitud')
        }
        return response.json()
    })
    .then((data) => {
        if(data.status && data.data.length > 0){
            const contador = data.data[0].contadorPossibleAuditor
            possibleAuditor.textContent = contador
        }else{
            possibleAuditor.textContent = "0"
        }
    })
    .catch((error) => {
        console.error(error)
    })
}

// Función para calcular los Girs mensuales con niveles adicionales
function fntCalculoGirsMont(){
    // Datos para la gráfica
    const labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']; // Etiquetas de los meses

    const data = {
        labels: labels,  // Etiquetas de los ejes X (meses)
        datasets: [{
            label: 'Total de Girs',  // Título del dataset
            data: [65, 59, 80, 81, 56, 55, 40, 43, 50, 73, 32, 54],  // Datos de ventas para cada mes
            fill: false,  // No rellenar el área bajo la línea
            borderColor: 'rgb(75, 192, 192)',  // Color de la línea
            tension: 0.1,  // Curvatura de la línea
        },
        {
            label: 'Low',  // Nivel Bajo
            data: [30, 25, 40, 35, 20, 30, 25, 20, 20, 25, 10, 20],  // Datos para "Low"
            fill: false,
            borderColor: 'rgb(255, 99, 132)',  // Color para el nivel bajo
            borderDash: [5, 5],  // Línea discontinua
            tension: 0.1
        },
        {
            label: 'Medium',  // Nivel Medio
            data: [50, 45, 60, 55, 45, 40, 30, 35, 45, 50, 40, 45],  // Datos para "Medium"
            fill: false,
            borderColor: 'rgb(255, 159, 64)',  // Color para el nivel medio
            borderDash: [5, 5],  // Línea discontinua
            tension: 0.1
        },
        {
            label: 'High',  // Nivel Alto
            data: [70, 65, 90, 85, 70, 65, 60, 65, 75, 85, 60, 70],  // Datos para "High"
            fill: false,
            borderColor: 'rgb(54, 162, 235)',  // Color para el nivel alto
            borderDash: [5, 5],  // Línea discontinua
            tension: 0.1
        },
        {
            label: 'In Stay',  // Nivel In Stay
            data: [60, 55, 70, 75, 65, 60, 50, 55, 60, 70, 50, 60],  // Datos para "In Stay"
            fill: false,
            borderColor: 'rgb(153, 102, 255)',  // Color para "In Stay"
            borderDash: [5, 5],  // Línea discontinua
            tension: 0.1
        },
        {
            label: 'Informative',  // Nivel Informative
            data: [55, 50, 75, 70, 60, 50, 45, 50, 60, 65, 55, 60],  // Datos para "Informative"
            fill: false,
            borderColor: 'rgb(255, 159, 64)',  // Color para "Informative"
            borderDash: [5, 5],  // Línea discontinua
            tension: 0.1
        },
        {
            label: 'WoW Moment',  // Nivel WoW Moment
            data: [80, 70, 100, 90, 85, 80, 75, 85, 90, 100, 75, 85],  // Datos para "WoW Moment"
            fill: false,
            borderColor: 'rgb(75, 192, 192)',  // Color para "WoW Moment"
            borderDash: [5, 5],  // Línea discontinua
            tension: 0.1
        }]
    };

    // Configuración de la gráfica
    const config = {
        type: 'line',  // Tipo de gráfica: línea
        data: data,    // Datos a graficar
        options: {
            responsive: true,  // La gráfica será responsiva
            scales: {
                y: {
                    beginAtZero: true  // El eje Y comenzará desde 0
                }
            }
        }
    };

    // Crear la gráfica
    const myChart = new Chart(
        document.getElementById('myChart'),  // El elemento canvas donde se dibujará la gráfica
        config  // La configuración de la gráfica
    );
}
