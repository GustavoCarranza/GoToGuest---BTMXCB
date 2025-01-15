document.addEventListener("DOMContentLoaded", () => {
    // Llamar a MostrarNotificaciones al cargar el documento
    MostrarNotificaciones();
    // Escuchar el evento click en el botón de notificación
    const btnNotify = document.getElementById("btn-notificacion");
    btnNotify.addEventListener("click", () => {
        $("#ViewNotificaciones").modal("show"); // Mostrar el modal al hacer clic en el botón
        MostrarNotificaciones(); // Llamar a MostrarNotificaciones al abrir el modal
    });
});
// Función para realizar la solicitud y actualizar las notificaciones
function MostrarNotificaciones() {
    fetch(Base_URL + "/Notificaciones/getNotificaciones", {
        method: "GET",
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error("Error en la respuesta");
        }
        return response.json();
    })
    .then((objData) => {
        if (objData.status && objData.data.length > 0) {
            const fragmento = document.createDocumentFragment();
            objData.data.forEach((notificacion) => {
                const fila = document.createElement("tr");
                const datosCombinados = `
                    <span style="font-size: 1.2em;">
                        ${notificacion.nombreCompleto} 
                        ${notificacion.descripcion} 
                        (#${notificacion.idRegistro})
                    </span> <br>
                    <span style="font-size: 0.8em; font-weight: bold;">
                        ${notificacion.fechaMovimiento} - 
                        ${notificacion.horaMovimiento}
                    </span>`;
                const celda = document.createElement("td");
                celda.innerHTML = datosCombinados; // Usar innerHTML para interpretar HTML
                fila.appendChild(celda);
                fragmento.appendChild(fila); // Agregar fila al fragmento
            });

            // Limpiar tabla antes de agregar nuevos datos
            const tabla = document.getElementById("tablaDatos");
            tabla.innerHTML = "";

            // Agregar el fragmento completo al DOM
            tabla.appendChild(fragmento);
        }else{
            // Si no hay notificaciones, mostrar mensaje
            const tabla = document.getElementById("tablaDatos");
            tabla.innerHTML = '<span style="display: flex; justify-content: center; font-weight: 800; font-size:1rem">No hay notificaciones aún</td></span>';
        }
    })
    .catch((error) => {
        console.error("Error en la solicitud:", error);
        // Manejar errores adecuadamente
    });
}
