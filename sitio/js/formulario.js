"use strict";
// Validación en el navegador (UX). La validación definitiva ocurre en contacto.php.
const formulario = document.getElementById('formulario');
if (formulario) {
 const claves = ['nombre','correo','horas','tema','modalidad','mensaje','acepto'];
 const resultado = document.getElementById('resultado');
 function controles(clave){ return clave==='modalidad' ? [...formulario.querySelectorAll('[name="modalidad"]')] : [document.getElementById(clave)]; }
 function error(clave,texto) {
   const elemento=document.getElementById('error-'+clave);
   if(elemento) elemento.textContent=texto;
   controles(clave).forEach(el=>el.setAttribute('aria-invalid',texto ? 'true':'false'));
 }
 formulario.addEventListener('submit',e=>{
   const datos=new FormData(formulario); const valor=(key)=>String(datos.get(key)||'').trim();
   const fallos={};
   if(valor('nombre').length<2||valor('nombre').length>80)fallos.nombre='Usa entre 2 y 80 caracteres.';
   if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor('correo')))fallos.correo='Escribe un correo válido.';
   const horas=Number(valor('horas'));
   if(valor('horas')===''||!Number.isInteger(horas)||horas<0||horas>24)fallos.horas='Ingresa un entero de 0 a 24.';
   if(!['historia','html','javascript','accesibilidad'].includes(valor('tema'))) fallos.tema='Selecciona un tema.';
   if(!['lectura','practica'].includes(valor('modalidad'))) fallos.modalidad='Selecciona una modalidad.';
   if(valor('mensaje').length<20||valor('mensaje').length>500) fallos.mensaje='Escribe de 20 a 500 caracteres.';
   if(!datos.has('acepto'))fallos.acepto='Confirma la condición.';
   claves.forEach(key=>error(key,fallos[key]||''));
   if(Object.keys(fallos).length){ e.preventDefault(); resultado.textContent='Revisa los campos marcados.'; controles(Object.keys(fallos)[0])[0].focus(); }
   else resultado.textContent='Enviando información al servidor local…';
 });
 formulario.addEventListener('reset',()=>{claves.forEach(key=>error(key,''));resultado.textContent='';});
}
