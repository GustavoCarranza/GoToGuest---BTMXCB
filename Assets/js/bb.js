function SSE() {
    const source = new EventSource(Base_URL + "/Notificaciones/Controlador");
    source.addEventListener("message", (e) => {
      const objData = JSON.parse(e.data);
      Push.create(objData.title, {
          body: `${objData.name} - ${objData.description} (${objData.NoId}) \n ${objData.fecha} - ${objData.hora}`,
          icon: Media + "/images/banyan.png",
          timeout: 10000,
          onClick: function () {
              window.location.href = Base_URL + '/Girs';
              window.focus();
              this.close();
          }
      });
      //Notificacion push
      console.log("Notificacion recibida: ", objData);
    });
  
    source.addEventListener("open", (e) => {
      // Connection was opened.
      console.log("Conexion abierta")
    });
  
    source.addEventListener("error", (e) => {
      if (e.readyState == EventSource.CLOSED) {
        // Connection was closed.
      }
    });
  }
  
  SSE();
  