# ADA 4. Servidor web local y desarrollo del lado del servidor

**Autor:** Miguel Jesús Ruiz May  
**Licenciatura:** Ingeniería de Software · Universidad Autónoma de Yucatán  
**Actividad:** ADA 4 · individual · 10 de noviembre de 2026

## ¿Qué contiene este ZIP?

Este proyecto parte del sitio **Conexión Web** de la actividad individual previa (cinco páginas, colores gris y cyan, línea del tiempo, recursos informativos, formulario HTML/JS). El sitio conserva su estilo, contenido y navegación y añade **PHP + MySQL**.

- `sitio/` – versión PHP para ejecutar con Apache y MySQL en **XAMPP** (localhost).
- `sitio/database/conexion_web_ada4.sql` – script para crear **5 tablas** y cargar datos de prueba sin personas reales.
- `docs/` – versión pública **estática** del FrontEnd preparada para GitHub Pages (sin ejecutar PHP).
- `GUIA_ENTREGA.md` – pasos para instalar, probar, publicar y entregar.
- `GUION_VIDEO.md` – narración para una demostración de **3 a 5 minutos**.
- `GUIA_VIDEO_PASO_A_PASO.md` – qué abrir y cómo grabar con OBS, minuto por minuto.
- `INSTALAR_EN_XAMPP.bat` – copia asistida al `htdocs` de XAMPP instalado en `C:\xampp`.
- `EMPEZAR_AQUI.txt` – lista breve de pasos para la entrega.
- `sitio/database/CONSULTAS_DE_VERIFICACION.sql` – consultas opcionales para comprobar las tablas.
- `APORTACION_FORO.md` – aporte para foro con los tres enlaces por completar.
- `COMENTARIOS_FORO.md` – dos comentarios editables para después de revisar a dos compañeros.
- `CHECKLIST.md` – comprobación contra el PDF de la actividad.

## Requisitos

Windows + [XAMPP](https://www.apachefriends.org/es/index.html) con Apache, PHP 8+ y MySQL/MariaDB; navegador y [GitHub](https://github.com/) para alojar código y FrontEnd. Este ZIP no instala Apache ni MySQL en tu equipo.

## Uso en 5 pasos

1. Extrae el ZIP. Copia la carpeta **`sitio` completa** a `C:\xampp\htdocs\conexion-web-ada4` (puedes renombrarla).
2. Abre el **XAMPP Control Panel**, pulsa **Start** en **Apache** y **MySQL**.
3. Abre `http://localhost/phpmyadmin`, pestaña **Importar**; selecciona `conexion_web_ada4.sql`. El SQL crea la base `conexion_web_ada4` y sus datos iniciales.
4. Abre `http://localhost/conexion-web-ada4/`. Comprueba inicio, línea del tiempo y recursos. En **Participa** escribe **datos ficticios** y guarda. En **Comunidad** verifica que el contador subió.
5. Revisa la guía adjunta para GitHub Pages, el video y los comentarios del foro.

Por defecto, la conexión PHP usa `DB_HOST=127.0.0.1`, `DB_PORT=3306`, `DB_NAME=conexion_web_ada4`, `DB_USER=root`, `DB_PASS=` (vacío); configuración típica de XAMPP para *desarrollo local*, no producción. Si tu instalación tiene otras credenciales, configúralas como variables de entorno de Apache o edita `includes/bootstrap.php` exclusivamente para tu entorno (no subas contraseñas a GitHub).

## Rutas y operaciones BackEnd

| Archivo | Operación real |
| --- | --- |
| `index.php` | PHP genera fecha y contenido HTML en el servidor |
| `historia.php` | `SELECT` de los 14 eventos desde `hitos_web` |
| `contacto.php` | Validación del lado del servidor, protección CSRF, transacción e `INSERT` con PDO |
| `comunidad.php` | Consultas SQL agregadas, evita exponer datos personales |
| `recursos.php` | `SELECT` de los recursos activos desde MySQL |
| `tecnologias.html`, `actualidad.html` | Se conservan como páginas del FrontEnd original |

Las 5 tablas son `temas`, `participantes`, `participaciones`, `hitos_web` y `recursos_web`. Las tres primeras están relacionadas por claves foráneas. Para el video, muestra estructura de las cinco tablas en phpMyAdmin y usa un registro ficticio para demostrar `INSERT`.

## Seguridad y honestidad académica

- Solo se usa MySQL **local**; no se expone el BackEnd a Internet al publicar GitHub Pages.
- Escapes HTML (`htmlspecialchars`), sentencias SQL preparadas (PDO), comprobación CSRF, validación del servidor y transacción para guardar datos.
- Para demonstración usa valores ficticios; no muestres correos o mensajes reales durante el video.
- No se han generado enlaces públicos, grabado video, configurado XAMPP en tu computadora ni publicado comentarios. Esas acciones requieren tu cuenta/equipo.
