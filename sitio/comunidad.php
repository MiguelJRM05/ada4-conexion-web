<?php
require __DIR__ . '/includes/bootstrap.php'; require __DIR__ . '/includes/layout.php';
$totales=['participaciones'=>0,'participantes'=>0]; $temas=[]; $recientes=[]; $errorBD=false;
try {
 $db=conexion();
 $totales['participaciones']=(int)$db->query('SELECT COUNT(*) FROM participaciones')->fetchColumn();
 $totales['participantes']=(int)$db->query('SELECT COUNT(*) FROM participantes')->fetchColumn();
 $temas=$db->query('SELECT t.nombre,COUNT(p.id) AS total FROM temas t LEFT JOIN participaciones p ON p.tema_id=t.id GROUP BY t.id,t.nombre ORDER BY total DESC,t.nombre')->fetchAll();
 $recientes=$db->query('SELECT t.nombre AS tema,p.modalidad,p.creado_en FROM participaciones p JOIN temas t ON t.id=p.tema_id ORDER BY p.id DESC LIMIT 5')->fetchAll();
} catch(PDOException $ex) { $errorBD=true; error_log('Error dashboard: '.$ex->getMessage()); }
cabecera('Comunidad y estadísticas','comunidad.php'); ?>
<main id="contenido"><div class="intro"><p class="eyebrow">CONSULTA PHP · MYSQL</p><h1>La comunidad en datos.</h1><p class="lead">Esta sección consulta las participaciones desde el servidor y muestra estadísticas sin revelar nombres, correos ni mensajes privados.</p></div>
<?php if($errorBD):?><div class="notice warning">No se pudieron consultar las tablas. Inicia MySQL desde XAMPP e importa <code>database/conexion_web_ada4.sql</code>.</div>
<?php else: ?>
<section class="stat-grid"><article class="stat"><span><?=e($totales['participaciones'])?></span><h2>Participaciones guardadas</h2></article><article class="stat"><span><?=e($totales['participantes'])?></span><h2>Participantes distintos</h2></article><article class="stat"><span><?=e(count($temas))?></span><h2>Temas disponibles</h2></article></section>
<section class="panel"><h2>Temas elegidos</h2><div class="table-wrap"><table><thead><tr><th scope="col">Tema</th><th scope="col">Participaciones</th></tr></thead><tbody><?php foreach($temas as $fila):?><tr><td><?=e($fila['nombre'])?></td><td><?=e($fila['total'])?></td></tr><?php endforeach ?></tbody></table></div></section>
<section class="panel"><h2>Últimas actividades (sin datos personales)</h2>
<?php if(!$recientes):?><p>Todavía no hay registros. Envía el formulario para crear el primero.</p><?php else: ?><ul><?php foreach($recientes as $fila): ?><li><strong><?=e($fila['tema'])?></strong> · <?=e($fila['modalidad'])?> · <?=e($fila['creado_en'])?></li><?php endforeach ?></ul><?php endif ?></section>
<?php endif ?><div class="actions"><a class="button" href="contacto.php">Registrar participación</a><a class="button secondary" href="index.php">Volver al inicio</a></div></main>
<?php pie(); ?>
