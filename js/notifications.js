document.addEventListener("DOMContentLoaded", () => {
  const notificationsButton = document.getElementById("notifications-button");
  const notificationsPanel = document.getElementById("notifications-panel");

  const lang = "es"; // Define el idioma según tu necesidad
  let notifications = [];

  async function updateNotifications() {
    const cachedData = JSON.parse(localStorage.getItem("notifications"));
    const cachedTime = localStorage.getItem("notifications-time");
    const now = new Date();

    if (cachedData && cachedTime) {
      const cachedDate = new Date(cachedTime);
      const differenceInHours = (now - cachedDate) / 36e5;

      if (differenceInHours < 24) {
        notifications = cachedData;
        renderNotifications();
        return;
      }
    }

    const response = await fetch(`/app/${lang}/g/getEventos/`);
    const eventos = await response.json();
    notifications = eventos.response;

    localStorage.setItem("notifications", JSON.stringify(notifications));
    localStorage.setItem("notifications-time", now.toISOString());
    if (document.querySelector("#notifications-count")) {
      renderNotifications();
    }
  }

  function formatEventDate(dateStr) {
    const date = new Date(dateStr);
    const day = date.getDate();
    const month = date.toLocaleString("default", { month: "short" });
    return { day, month };
  }

  function renderNotifications() {
    const notificationsCount = notifications.length;
    if (document.getElementById("notifications-count")) {
      document.getElementById("notifications-count").innerText =
        notificationsCount;
    }

    const notificationsList = document.createElement("ul");

    notifications.forEach((notification) => {
      const formattedDate = formatEventDate(notification.acf.fecha_del_evento);
      const li = document.createElement("li");
      li.innerHTML = `<div class="date-container"><div class="date">${formattedDate.day}</div><div class="month">${formattedDate.month}</div></div><p>${notification.title.rendered}</p>`;
      notificationsList.appendChild(li);
    });
    if (notificationsPanel) {
      while (notificationsPanel.firstChild) {
        notificationsPanel.removeChild(notificationsPanel.firstChild);
      }
      notificationsPanel.appendChild(notificationsList);
    }
  }

  if (notificationsButton) {
    // Evento click del botón de notificaciones
    notificationsButton.addEventListener("click", function (event) {
      event.stopPropagation();
      notificationsPanel.classList.toggle("open");
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
  updateNotifications();
});
