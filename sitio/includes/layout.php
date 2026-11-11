<?php
/** Plantilla común de navegación para páginas PHP nuevas. */
function cabecera(string $titulo, string $actual): void {
    $menu = [
       'index.php'=>'Inicio','historia.php'=>'Línea del tiempo',
       'tecnologias.html'=>'Tecnologías','actualidad.html'=>'Web actual',
       'contacto.php'=>'Participa','comunidad.php'=>'Comunidad','recursos.php'=>'Recursos'
    ];
    ?>
<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Conexión Web: historia, tecnologías y participación desde PHP y MySQL.">
<title><?=e($titulo)?> | Conexión Web</title>
<link rel="stylesheet" href="css/estilos.css"><script src="js/formulario.js" defer></script></head>
<body><a class="skip" href="#contenido">Saltar al contenido</a>
<header><div class="brand">CW<span>CONEXIÓN WEB</span></div><nav aria-label="Navegación principal">
<?php foreach($menu as $url => $etiqueta): ?>
<a href="<?=e($url)?>" <?= $url === $actual ? 'aria-current="page"' : '' ?>><?=e($etiqueta)?></a>
<?php endforeach ?></nav></header>
<?php
}
function pie(): void { ?>
<footer><p><strong>Miguel Jesús Ruiz May</strong> · Ingeniería de Software · Universidad Autónoma de Yucatán</p>
<p>Proyecto individual · Evolución de la web · <?=date('Y')?></p></footer></body></html>
<?php }
