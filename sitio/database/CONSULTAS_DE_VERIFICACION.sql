-- ADA 4 - Consultas sencillas para mostrar en la demonstracion
-- Una vez importada la base, usar phpMyAdmin > SQL.
USE conexion_web_ada4;
SHOW TABLES;
SELECT COUNT(*) AS total_hitos FROM hitos_web;
SELECT COUNT(*) AS total_recursos FROM recursos_web;
SELECT COUNT(*) AS total_participaciones FROM participaciones;
SELECT id, participante_id, tema_id, horas_web, modalidad, creado_en
FROM participaciones ORDER BY id DESC LIMIT 5;
-- No publicar datos personales o de demostracion fuera del equipo local.
