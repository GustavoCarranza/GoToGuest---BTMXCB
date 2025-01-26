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
