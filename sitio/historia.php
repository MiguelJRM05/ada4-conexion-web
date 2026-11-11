<?php
require __DIR__ . '/includes/bootstrap.php';
$hitos = []; $errorBD = false;
try {
    $hitos = conexion()->query('SELECT anio_texto, titulo, descripcion FROM hitos_web ORDER BY orden ASC')->fetchAll();
} catch (PDOException $ex) {
    error_log('Fallo al cargar los hitos: ' . $ex->getMessage());
    $errorBD = true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content="Sitio educativo sobre la evolución de la web, sus tecnologías y accesibilidad."><title>Pequeños hitos. Un gran cambio. | Conexión Web</title><link rel="stylesheet" href="css/estilos.css"><script src="js/formulario.js" defer></script></head>
<body><a class="skip" href="#contenido">Saltar al contenido</a><header><div class="brand">CW<span>CONEXIÓN WEB</span></div><nav aria-label="Navegación principal"><a href="index.php">Inicio</a><a href="historia.php" aria-current="page">Línea del tiempo</a><a href="tecnologias.html">Tecnologías</a><a href="actualidad.html">Web actual</a><a href="contacto.php">Participa</a><a href="comunidad.php">Comunidad</a><a href="recursos.php">Recursos</a></nav></header>
<main id="contenido"><div class="intro"><p class="eyebrow">EXPLORA · COMPRENDE · CONECTA</p><h1>Pequeños hitos. Un gran cambio.</h1><p class="lead">Un recorrido visual desde 1989 hasta la web actual.</p></div><section><h2>Línea del tiempo de la web</h2><p>Los puntos y la línea conectan los acontecimientos en orden cronológico. La última entrada describe tendencias, no una nueva versión oficial de la web.</p><?php if ($errorBD): ?>
<div class="notice warning" role="alert">La base de datos aún no está disponible. Se muestra temporalmente la línea del tiempo del sitio original. Importa <code>database/conexion_web_ada4.sql</code> en phpMyAdmin para activar la consulta SQL.</div>
<ol class="timeline"><li><span class="date">1989</span><div><h3>La propuesta inicial</h3><p>Tim Berners-Lee propone en el CERN un sistema de información enlazada.</p></div></li><li><span class="date">1990</span><div><h3>Primer navegador y servidor</h3><p>Se implementan WorldWideWeb y el primer servidor web.</p></div></li><li><span class="date">1991</span><div><h3>La web se comparte</h3><p>El proyecto se anuncia en Internet y amplía su alcance fuera del CERN.</p></div></li><li><span class="date">1993</span><div><h3>Mosaic</h3><p>El navegador gráfico facilita explorar páginas con contenido visual.</p></div></li><li><span class="date">1993</span><div><h3>Una tecnología abierta</h3><p>El CERN libera el software de la web al dominio público el 30 de abril.</p></div></li><li><span class="date">1994</span><div><h3>Nace el W3C</h3><p>Se funda el consorcio para impulsar estándares de la web.</p></div></li><li><span class="date">1995</span><div><h3>HTML 2.0</h3><p>Una especificación organiza las características básicas del lenguaje.</p></div></li><li><span class="date">1997</span><div><h3>HTTP/1.1</h3><p>El protocolo mejora la comunicación entre navegadores y servidores.</p></div></li><li><span class="date">2001</span><div><h3>Wikipedia</h3><p>La enciclopedia colaborativa muestra el potencial de crear contenido entre personas.</p></div></li><li><span class="date">2005</span><div><h3>YouTube</h3><p>El video compartido se convierte en una forma de participar en la web.</p></div></li><li><span class="date">2014</span><div><h3>HTML5</h3><p>La recomendación incorpora elementos semánticos y multimedia.</p></div></li><li><span class="date">2015</span><div><h3>HTTP/2</h3><p>Una nueva versión del protocolo permite transportar datos de manera más eficiente.</p></div></li><li><span class="date">2023</span><div><h3>WCAG 2.2</h3><p>Nuevas pautas amplían los criterios de accesibilidad del contenido web.</p></div></li><li><span class="date">Actualidad</span><div><h3>Una web para más personas</h3><p>Las experiencias móviles, el contenido multimedia y las interfaces con IA refuerzan la necesidad de accesibilidad.</p></div></li></ol>
<?php elseif (!$hitos): ?>
<div class="notice warning">No se encontraron hitos: comprueba que importaste los registros iniciales del archivo SQL.</div>
<?php else: ?>
<p class="notice success">Contenido obtenido de la tabla <code>hitos_web</code> mediante una consulta ejecutada por PHP.</p>
<ol class="timeline">
<?php foreach ($hitos as $hito): ?>
<li><span class="date"><?=e($hito['anio_texto'])?></span><div><h3><?=e($hito['titulo'])?></h3><p><?=e($hito['descripcion'])?></p></div></li>
<?php endforeach ?>
</ol>
<?php endif ?></section><section class="panel"><h2>Fuentes para explorar</h2><ul><li><a href="https://home.cern/science/computing/the-birth-of-the-web">CERN: nacimiento de la web</a></li><li><a href="https://worldwideweb.cern.ch/timeline/">CERN: cronología de tecnologías web</a></li><li><a href="https://www.w3.org/about/history/">W3C: historia del consorcio</a></li><li><a href="https://www.w3.org/WAI/standards-guidelines/wcag/">W3C: evolución de las pautas WCAG</a></li></ul><p>Consulta: 23 de octubre de 2026.</p></section></main>
<footer><p><strong>Miguel Jesús Ruiz May</strong> · Ingeniería de Software · Universidad Autónoma de Yucatán</p><p>Proyecto individual · Evolución de la web · 2026</p></footer></body></html>