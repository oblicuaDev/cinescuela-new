document.addEventListener("DOMContentLoaded", () => {
  const notificationsButton = document.getElementById("notifications-button");
  const notificationsPanel = document.getElementById("notifications-panel");
  // Simulación de notificaciones
  const notifications = [
    {
      id: 1,
      message: "<p>INDUCCION DE USO DE LA PLATAFORMA CINESCUELA JUN 14</p>",
    },
    {
      id: 2,
      message: "<p>TALLERES PARA HACER CINEFOROS JUN 2</p>",
    },
  ];
  // Actualiza el contador y muestra las notificaciones
  function updateNotifications() {
    const notificationsCount = notifications.length;
    document.getElementById("notifications-count").innerText =
      notificationsCount;

    // Muestra las notificaciones
    const notificationsList = document.createElement("ul");
    notifications.forEach((notification) => {
      const li = document.createElement("li");
      li.innerHTML = notification.message;
      notificationsList.appendChild(li);
    });

    // Vacía el panel de notificaciones antes de agregar las nuevas notificaciones
    while (notificationsPanel.firstChild) {
      notificationsPanel.removeChild(notificationsPanel.firstChild);
    }

    notificationsPanel.appendChild(notificationsList);
  }
  if (notificationsButton) {
    // Evento click del botón de notificaciones
    notificationsButton.addEventListener("click", function (event) {
      event.stopPropagation();
      notificationsPanel.classList.toggle("open");
      updateNotifications();
    });
    // Evento click fuera del panel de notificaciones para cerrarlo
    document.addEventListener("click", function (event) {
      const isClickInside =
        notificationsButton.contains(event.target) ||
        notificationsPanel.contains(event.target);
      if (!isClickInside) {
        notificationsPanel.classList.remove("open");
      }
    });
  }
});
