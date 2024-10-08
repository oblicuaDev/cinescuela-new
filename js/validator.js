class FormValidator {
  constructor(form, fields, handleResponse) {
    this.form = form;
    this.fields = fields;
    this.handleResponse = handleResponse;
  }

  initialize() {
    this.validateOnEntry();
    this.validateOnSubmit();
  }

  validateOnSubmit() {
    let self = this;

    this.form.addEventListener("submit", (e) => {
      e.preventDefault();
      let isValid = true;
      self.fields.forEach((field) => {
        const input = document.querySelector(`#${field}`);
        if (!self.validateFields(input)) {
          isValid = false;
        }
      });

      if (isValid) {
        // If all fields are valid, submit the form via AJAX
        self.ajaxSubmit();
      }
    });
  }

  ajaxSubmit() {
    // Serialize form data
    const formData = new FormData(this.form);

    if (document.querySelector(`#login button[type="submit"]`)) {
      document.querySelector(`#login button[type="submit"]`).innerHTML =
        findUiWord(23, lang);
    } else {
      this.form.querySelector(
        `button[type="submit"]`
      ).innerHTML = `Enviando...`;
    }

    // Make AJAX request
    fetch(this.form.action, {
      method: this.form.method,
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        this.handleResponse(data); // Handle response data using the provided function
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }

  validateOnEntry() {
    let self = this;
    this.fields.forEach((field) => {
      const input = document.querySelector(`#${field}`);

      input.addEventListener("input", (event) => {
        self.validateFields(input);
      });
    });
  }

  validateFields(field) {
    // Check presence of values
    if (field.value.trim() === "") {
      this.setStatus(
        field,
        `${
          field.previousElementSibling
            ? field.previousElementSibling.innerText
            : field.placeholder
        } es obligatorio`,
        "error"
      );
      return false;
    } else {
      this.setStatus(field, null, "success");
    }

    // check for a valid email address
    if (field.type === "email") {
      const re = /\S+@\S+\.\S+/;
      if (re.test(field.value)) {
        this.setStatus(field, null, "success");
      } else {
        this.setStatus(
          field,
          "Por favor ingresa un correo electrónico válido",
          "error"
        );
        return false;
      }
    }

    // Password confirmation edge case
    if (field.id === "password_confirmation") {
      const passwordField = this.form.querySelector("#password");

      if (field.value.trim() == "") {
        this.setStatus(
          field,
          "Se requiere confirmación de contraseña",
          "error"
        );
        return false;
      } else if (field.value != passwordField.value) {
        this.setStatus(field, "La contraseña no coincide", "error");
        return false;
      } else {
        this.setStatus(field, null, "success");
      }
    }

    return true;
  }

  setStatus(field, message, status) {
    const errorMessage = field.parentElement.querySelector(".error-message");

    if (status === "success") {
      if (errorMessage) {
        errorMessage.innerText = "";
      }
      field.classList.remove("input-error");
    }

    if (status === "error") {
      field.parentElement.querySelector(".error-message").innerText = message;
      field.classList.add("input-error");
    }
  }
}

const loginForm = document.querySelector("#login");
if (loginForm) {
  const LoginFormFields = ["username", "password"];
  // Función de manejo de respuesta dinámica Login
  function handleResponse(data) {
    if (data == "2") {
      document.querySelector(`#login button[type="submit"]`).innerHTML =
        findUiWord(18, lang);
      document.querySelector('.error-message').innerHTML = findUiWord(100, lang);
    } else if (data == "0") {
      document.querySelector(`#login button[type="submit"]`).innerHTML =
        findUiWord(18, lang);
      document.querySelector('.error-message').innerHTML = findUiWord(20, lang);
    } else {
      fadeIn(preloader);
      location.href = lang + "/inicio";
    }
  }
  const validator = new FormValidator(
    loginForm,
    LoginFormFields,
    handleResponse
  );

  validator.initialize();
}
const contactForm = document.querySelector("#contact");
if (contactForm) {
  const fieldsContactForm = [
    "name",
    "institucion",
    "email",
    "city",
    "politics",
  ];
  // Función de manejo de respuesta dinámica Login
  function handleResponse(data) {
    if (data.response) {
      fadeOut(document.querySelector("#contact"));
      document.querySelector(".thanks").style.display = "flex";
    }
  }
  const validator = new FormValidator(
    contactForm,
    fieldsContactForm,
    handleResponse
  );

  validator.initialize();
}
const buzonForm = document.querySelector("#buzon");
if (buzonForm) {
  const fieldsBuzonForm = ["content"];
  // Función de manejo de respuesta dinámica Login
  function handleResponse(data) {
    fadeOut(document.querySelector("#buzon"));
    closeModalBuzon();
    document.querySelector(".thanks").style.display = "flex";
  }
  const validator = new FormValidator(
    buzonForm,
    fieldsBuzonForm,
    handleResponse
  );

  validator.initialize();
}
const sugerenciaForm = document.querySelector("#sugerencia");
if (sugerenciaForm) {
  const fieldssugerenciaForm = ["contentSug"];
  // Función de manejo de respuesta dinámica Login
  function handleResponse(data) {
    fadeOut(document.querySelector("#sugerencia"));
    document.querySelector(".thanks").style.display = "flex";
    closeModalSugerencia();
  }
  const validator = new FormValidator(
    sugerenciaForm,
    fieldssugerenciaForm,
    handleResponse
  );

  validator.initialize();
}
