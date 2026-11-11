<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/layout.php';
$valores = ['nombre'=>'','correo'=>'','horas'=>'','tema'=>'','modalidad'=>'','mensaje'=>''];
$errores = []; $mensajeGeneral = '';
$temas = [
    ['clave'=>'historia','nombre'=>'Historia de la web'],
    ['clave'=>'html','nombre'=>'HTML y CSS'],
    ['clave'=>'javascript','nombre'=>'JavaScript'],
    ['clave'=>'accesibilidad','nombre'=>'Accesibilidad']
];
try { $temas = conexion()->query('SELECT clave, nombre FROM temas ORDER BY id')->fetchAll(); }
catch (PDOException $ex) { error_log('No se cargaron temas: '.$ex->getMessage()); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($valores as $clave => $_) $valores[$clave] = trim((string)($_POST[$clave] ?? ''));
    if (!csrf_valido((string)($_POST['csrf'] ?? ''))) $errores['csrf']='La sesión expiró. Recarga la página e intenta de nuevo.';
    if (longitud($valores['nombre']) < 2 || longitud($valores['nombre']) > 80) $errores['nombre']='Usa entre 2 y 80 caracteres.';
    if (longitud($valores['correo']) > 190 || !filter_var($valores['correo'], FILTER_VALIDATE_EMAIL)) $errores['correo']='Escribe un correo electrónico válido.';
    if (!preg_match('/^(?:[0-9]|1[0-9]|2[0-4])$/D', $valores['horas'])) $errores['horas']='Indica horas enteras de 0 a 24.';
    $clavesValidas = array_column($temas, 'clave');
    if (!in_array($valores['tema'], $clavesValidas, true)) $errores['tema']='Selecciona un tema válido.';
    if (!in_array($valores['modalidad'], ['lectura','practica'], true)) $errores['modalidad']='Selecciona lectura o práctica.';
    if (longitud($valores['mensaje']) < 20 || longitud($valores['mensaje']) > 500) $errores['mensaje']='Escribe entre 20 y 500 caracteres.';
    if (!isset($_POST['acepto'])) $errores['acepto']='Confirma que usarás datos de prueba.';
    // Campo trampa contra bots sencillos; nunca mostrar datos enviados.
    if (trim((string)($_POST['web_empresa'] ?? '')) !== '') $errores['general']='Solicitud no admitida.';
    if (!$errores) {
        try {
            $db = conexion();
            $db->beginTransaction();
            // Consulta preparada evita concatenar los datos al SQL.
            $consulta = $db->prepare('INSERT INTO participantes (nombre,correo) VALUES (:nombre,:correo) ON DUPLICATE KEY UPDATE nombre=VALUES(nombre), id=LAST_INSERT_ID(id)');
            $consulta->execute([':nombre'=>$valores['nombre'], ':correo'=>$valores['correo']]);
            $idParticipante = (int)$db->lastInsertId();
            $tema = $db->prepare('SELECT id FROM temas WHERE clave=:clave LIMIT 1');
            $tema->execute([':clave'=>$valores['tema']]);
            $idTema = $tema->fetchColumn();
            if (!$idTema) throw new RuntimeException('Tema no encontrado');
            $guardar = $db->prepare('INSERT INTO participaciones (participante_id, tema_id, horas_web, modalidad, mensaje) VALUES (:participante,:tema,:horas,:modalidad,:mensaje)');
            $guardar->execute([':participante'=>$idParticipante,':tema'=>(int)$idTema,':horas'=>(int)$valores['horas'],':modalidad'=>$valores['modalidad'],':mensaje'=>$valores['mensaje']]);
            $db->commit();
            header('Location: contacto.php?enviado=1', true, 303);
            exit;
        } catch (Throwable $ex) {
            if (isset($db) && $db->inTransaction()) $db->rollBack();
            error_log('Error al guardar participación: '.$ex->getMessage());
            $mensajeGeneral='No se pudo guardar la información. Verifica que Apache y MySQL estén iniciados y que importaste el archivo SQL.';
        }
    }
}
cabecera('Tu siguiente idea empieza aquí','contacto.php');
?>

<main id="contenido">
<div class="intro"><p class="eyebrow">FORMULARIO · PHP + MYSQL</p><h1>Tu siguiente idea empieza aquí.</h1>
<p class="lead">El formulario conserva los siete tipos de controles del sitio anterior; ahora PHP valida y registra los datos en la base de datos local.</p></div>
<section class="form-panel"><h2>Comparte tu interés</h2>
<p class="note">Actividad educativa: utiliza un nombre y correo ficticios para la demostración. Los datos se almacenan únicamente en tu MySQL local.</p>
<?php if (($_GET['enviado'] ?? '') === '1'): ?><p class="notice success" role="status">¡Participación guardada correctamente en MySQL! Visita la sección Comunidad para comprobar el nuevo registro agregado.</p><?php endif ?>
<?php if ($mensajeGeneral || $errores): ?><p class="notice warning" role="alert"><?=e($mensajeGeneral ?: 'Revisa los campos indicados antes de enviar.')?></p><?php endif ?>
<form id="formulario" method="post" action="contacto.php" novalidate>
<input type="hidden" name="csrf" value="<?=e(csrf_token())?>">
<div class="honeypot" aria-hidden="true"><label>Empresa <input type="text" name="web_empresa" tabindex="-1" autocomplete="off"></label></div>
<div class="field"><label for="nombre">Nombre (2 a 80 caracteres)</label><input id="nombre" name="nombre" type="text" minlength="2" maxlength="80" required autocomplete="off" value="<?=e($valores['nombre'])?>" aria-describedby="error-nombre"><small id="error-nombre" class="error"><?=e($errores['nombre']??'')?></small></div>
<div class="field"><label for="correo">Correo electrónico (de prueba)</label><input id="correo" name="correo" type="email" maxlength="190" required autocomplete="off" value="<?=e($valores['correo'])?>" aria-describedby="error-correo"><small id="error-correo" class="error"><?=e($errores['correo']??'')?></small></div>
<div class="field"><label for="horas">Horas al día (0 a 24)</label><input id="horas" name="horas" type="number" min="0" max="24" step="1" required value="<?=e($valores['horas'])?>" aria-describedby="error-horas"><small id="error-horas" class="error"><?=e($errores['horas']??'')?></small></div>
<div class="field"><label for="tema">Tema de interés</label><select id="tema" name="tema" required aria-describedby="error-tema"><option value="">Selecciona una opción</option><?php foreach($temas as $op): ?><option value="<?=e($op['clave'])?>" <?=$valores['tema']===$op['clave']?'selected':''?>><?=e($op['nombre'])?></option><?php endforeach ?></select><small id="error-tema" class="error"><?=e($errores['tema']??'')?></small></div>
<fieldset><legend>¿Cómo prefieres aprender?</legend><label class="choice"><input type="radio" name="modalidad" value="lectura" <?=$valores['modalidad']==='lectura'?'checked':''?> required> Lectura</label><label class="choice"><input type="radio" name="modalidad" value="practica" <?=$valores['modalidad']==='practica'?'checked':''?>> Práctica</label><small id="error-modalidad" class="error"><?=e($errores['modalidad']??'')?></small></fieldset>
<div class="field"><label for="mensaje">¿Qué te gustaría crear en la web? (20 a 500 caracteres)</label><textarea id="mensaje" name="mensaje" rows="5" required minlength="20" maxlength="500" aria-describedby="error-mensaje"><?=e($valores['mensaje'])?></textarea><small id="error-mensaje" class="error"><?=e($errores['mensaje']??'')?></small></div>
<div class="field"><label class="choice"><input id="acepto" name="acepto" type="checkbox" value="1" required <?=(isset($_POST['acepto'])?'checked':'')?>> Entiendo que esta práctica debe hacerse con datos ficticios y que los datos se guardan en una base local.</label><small id="error-acepto" class="error"><?=e($errores['acepto']??'')?></small></div>
<div class="actions"><button type="submit">Guardar en MySQL</button><button type="reset" class="secondary">Limpiar</button></div>
<p id="resultado" aria-live="polite" role="status"></p>
</form></section></main>
<?php pie(); ?>
