function SSE() {
    const source = new EventSource(Base_URL + "/Notificaciones/Controlador");
    source.addEventListener("message", (e) => {
      const objData = JSON.parse(e.data);
      Push.create(objData.title, {
          body: `${objData.name} - ${objData.description} (${objData.NoId})`,
          icon: Media + "/images/banyan.png",
          timeout: 10000,
          onClick: function () {
              window.location.href = Base_URL + "/Girs";
              window.focus();
              this.close();
          }
      });
      //Notificacion push
      
    });
  
    source.addEventListener("open", (e) => {
      // Connection was opened.
      
    });
  
    source.addEventListener("error", (e) => {
      if (e.readyState == EventSource.CLOSED) {
        // Connection was closed.
      }
    });
  }
  
  SSE();
  