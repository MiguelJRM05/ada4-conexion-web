"use strict";
// Las páginas comparten el script; solo se activa donde existe el formulario.
const formulario = document.getElementById("formulario");
if (formulario) {
  const resultado = document.getElementById("resultado");
  const claves = ["nombre", "correo", "horas", "tema", "modalidad", "mensaje", "acepto"];
  function controles(clave) {
    return clave === "modalidad" ? [...formulario.querySelectorAll('[name="modalidad"]')] : [document.getElementById(clave)];
  }
  function mostrarError(clave, texto) {
    document.getElementById("error-" + clave).textContent = texto;
    controles(clave).forEach(control => control.setAttribute("aria-invalid", texto ? "true" : "false"));
  }
  formulario.addEventListener("submit", function (evento) {
    evento.preventDefault(); // Demostración: no hay envío a un servidor.
    const datos = new FormData(formulario);
    const valor = clave => String(datos.get(clave) || "").trim();
    const errores = {};
    if (valor("nombre").length < 2 || valor("nombre").length > 80) errores.nombre = "Escribe un nombre de 2 a 80 caracteres.";
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor("correo"))) errores.correo = "Escribe un correo válido, por ejemplo: ejemplo@correo.com.";
    const horas = Number(valor("horas"));
    if (valor("horas") === "" || !Number.isInteger(horas) || horas < 0 || horas > 24) errores.horas = "Escribe un número entero entre 0 y 24.";
    if (!["historia", "html", "javascript", "accesibilidad"].includes(valor("tema"))) errores.tema = "Selecciona un tema de interés.";
    if (!["lectura", "practica"].includes(valor("modalidad"))) errores.modalidad = "Elige una forma de aprender.";
    if (valor("mensaje").length < 20 || valor("mensaje").length > 500) errores.mensaje = "Escribe de 20 a 500 caracteres.";
    if (!datos.has("acepto")) errores.acepto = "Marca la casilla para confirmar que entiendes la demostración.";
    claves.forEach(clave => mostrarError(clave, errores[clave] || ""));
    const fallos = Object.keys(errores);
    if (fallos.length) {
      resultado.textContent = "Revisa los " + fallos.length + " campos indicados.";
      controles(fallos[0])[0].focus();
      return;
    }
    // textContent impide interpretar las entradas como código HTML.
    resultado.textContent = "¡Gracias, " + valor("nombre") + "! Los datos son válidos. Demostración completada: no se enviaron ni guardaron datos.";
  });
  formulario.addEventListener("reset", function () {
    claves.forEach(clave => mostrarError(clave, ""));
    resultado.textContent = "";
  });
}
