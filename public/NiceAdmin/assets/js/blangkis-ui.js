(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".needs-validation").forEach(function (form) {
      form.addEventListener("submit", function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      });
    });

    document.querySelectorAll(".alert").forEach(function (alert) {
      if (!alert.classList.contains("alert-dismissible")) {
        return;
      }

      window.setTimeout(function () {
        if (window.bootstrap && bootstrap.Alert) {
          var instance = bootstrap.Alert.getOrCreateInstance(alert);
          instance.close();
        }
      }, 5500);
    });
  });
})();
