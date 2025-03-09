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
function fntCalculoGirsMont() { 
    const ctx = document.getElementById('totalGirs');

    fetch(Base_URL + '/Dashboard/getTotalGir', {
        method: 'GET',
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la solicitud');
        }
        return response.json();
    })
    .then(objData => {
        if (objData.status && objData.data.length > 0) {

            let etiquetas = []
            let valoresGirs = []
            let valoresLow = []
            let valoresMedium = []
            let valoresHigh = []
            let valoresInStay = []
            let valoresInformative = []
            let valoresWoowMoment = []

            const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']

            // Obtener la fecha actual para filtrar últimos 12 meses
            let fechaActual = new Date()
            let anioActual = fechaActual.getFullYear()
            let mesActual = fechaActual.getMonth() + 1

            let datosFiltrados = objData.data.filter(item => {
                let diferenciaMeses = (anioActual - item.fecha_gir) * 12 + (mesActual - item.mes_gir)
                return diferenciaMeses >= 0 && diferenciaMeses < 12
            });

            // Ordenar datos por año y mes
            datosFiltrados.sort((a, b) => (a.fecha_gir - b.fecha_gir) || (a.mes_gir - b.mes_gir))

            // Generar etiquetas y valores
            datosFiltrados.forEach(item => {
                etiquetas.push(`${meses[item.mes_gir - 1]} - ${item.fecha_gir}`)
                valoresGirs.push(item.total)
                valoresLow.push(item.total_low)
                valoresMedium.push(item.total_Medium)
                valoresHigh.push(item.total_High)
                valoresInStay.push(item.total_inStay)
                valoresInformative.push(item.total_Informative)
                valoresWoowMoment.push(item.total_WoowMoment)
            });

            // Crear gráfico con dos líneas
            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: etiquetas,
                    datasets: [
                        {
                            label: "Total de Girs",
                            data: valoresGirs,
                            fill: false, 
                            borderColor: 'rgb(0, 0, 0)',
                            tension: 0.1,  
                        },
                        {
                            label: "Low",
                            data: valoresLow,
                            fill: false, 
                            borderColor: 'rgb(38, 157, 0)',
                            tension: 0.1,  
                        },
                        {
                            label: "Medium",
                            data: valoresMedium,
                            fill: false, 
                            borderColor: 'rgb(185, 183, 0)', 
                            tension: 0.1,  
                        },
                        {
                            label: "High",
                            data: valoresHigh,
                            fill: false, 
                            borderColor: 'rgb(128, 0, 0)',
                            tension: 0.1,  
                        },
                        {
                            label: "In Stay",
                            data: valoresInStay,
                            fill: false, 
                            borderColor: 'rgb(234, 107, 0)',
                            tension: 0.1,  
                        },
                        {
                            label: "Informative",
                            data: valoresInformative,
                            fill: false, 
                            borderColor: 'rgb(0, 172, 203)',
                            tension: 0.1,  
                        },
                        {
                            label: "Wow Moment",
                            data: valoresWoowMoment,
                            fill: false,
                            borderColor: 'rgb(55, 0, 200)',
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
