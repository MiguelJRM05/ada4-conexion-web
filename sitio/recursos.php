<?php
require __DIR__.'/includes/bootstrap.php'; require __DIR__.'/includes/layout.php';
$recursos=[]; $errorBD=false;
try { $recursos=conexion()->query('SELECT titulo,url,categoria FROM recursos_web WHERE activo=1 ORDER BY categoria,titulo')->fetchAll(); }
catch(PDOException $ex){$errorBD=true;error_log('Error recursos: '.$ex->getMessage());}
cabecera('Recursos de aprendizaje','recursos.php'); ?>
<main id="contenido"><div class="intro"><p class="eyebrow">CATÁLOGO DESDE MYSQL</p><h1>Recursos para seguir aprendiendo.</h1><p class="lead">Los enlaces de esta sección se leen directamente de la tabla <code>recursos_web</code>.</p></div>
<?php if($errorBD):?><div class="notice warning">Activa MySQL e importa la base de datos para consultar recursos.</div>
<?php elseif(!$recursos):?><div class="notice">No hay recursos activos en la tabla.</div>
<?php else: ?><section class="grid resource-grid"><?php foreach($recursos as $r): ?>
<article><p class="number"><?=e($r['categoria'])?></p><h2><?=e($r['titulo'])?></h2><p><a href="<?=e($r['url'])?>" target="_blank" rel="noopener noreferrer">Abrir recurso externo ↗</a></p></article>
<?php endforeach ?></section><?php endif ?></main><?php pie(); ?>
