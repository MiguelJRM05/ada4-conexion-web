-- ADA 4 / Conexión Web / Miguel Jesús Ruiz May
-- Importar con phpMyAdmin > Importar > seleccionar este archivo.
-- Eliminar la BD existente antes de reimportar solo si no necesitas guardar aportaciones.
CREATE DATABASE IF NOT EXISTS conexion_web_ada4 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE conexion_web_ada4;

CREATE TABLE IF NOT EXISTS temas (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 clave VARCHAR(35) NOT NULL UNIQUE,
 nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS participantes (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR(80) NOT NULL,
 correo VARCHAR(190) NOT NULL UNIQUE,
 creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS participaciones (
 id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 participante_id INT UNSIGNED NOT NULL,
 tema_id INT UNSIGNED NOT NULL,
 horas_web TINYINT UNSIGNED NOT NULL,
 modalidad ENUM('lectura','practica') NOT NULL,
 mensaje VARCHAR(500) NOT NULL,
 creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 INDEX ix_participaciones_tema (tema_id),
 INDEX ix_participaciones_fecha (creado_en),
 CONSTRAINT fk_participacion_participante FOREIGN KEY (participante_id) REFERENCES participantes(id),
 CONSTRAINT fk_participacion_tema FOREIGN KEY (tema_id) REFERENCES temas(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS hitos_web (
 id INT UNSIGNED NOT NULL PRIMARY KEY,
 anio_texto VARCHAR(30) NOT NULL,
 titulo VARCHAR(120) NOT NULL,
 descripcion TEXT NOT NULL,
 orden INT NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS recursos_web (
 id INT UNSIGNED NOT NULL PRIMARY KEY,
 titulo VARCHAR(150) NOT NULL,
 url VARCHAR(600) NOT NULL,
 categoria VARCHAR(80) NOT NULL,
 activo BOOLEAN NOT NULL DEFAULT TRUE
) ENGINE=InnoDB;

INSERT INTO temas (clave, nombre) VALUES
('historia','Historia de la web'),('html','HTML y CSS'),('javascript','JavaScript'),('accesibilidad','Accesibilidad')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

INSERT INTO hitos_web (id,anio_texto,titulo,descripcion,orden) VALUES
(1, '1989', 'La propuesta inicial', 'Tim Berners-Lee propone en el CERN un sistema de información enlazada.', 1),
(2, '1990', 'Primer navegador y servidor', 'Se implementan WorldWideWeb y el primer servidor web.', 2),
(3, '1991', 'La web se comparte', 'El proyecto se anuncia en Internet y amplía su alcance fuera del CERN.', 3),
(4, '1993', 'Mosaic', 'El navegador gráfico facilita explorar páginas con contenido visual.', 4),
(5, '1993', 'Una tecnología abierta', 'El CERN libera el software de la web al dominio público el 30 de abril.', 5),
(6, '1994', 'Nace el W3C', 'Se funda el consorcio para impulsar estándares de la web.', 6),
(7, '1995', 'HTML 2.0', 'Una especificación organiza las características básicas del lenguaje.', 7),
(8, '1997', 'HTTP/1.1', 'El protocolo mejora la comunicación entre navegadores y servidores.', 8),
(9, '2001', 'Wikipedia', 'La enciclopedia colaborativa muestra el potencial de crear contenido entre personas.', 9),
(10, '2005', 'YouTube', 'El video compartido se convierte en una forma de participar en la web.', 10),
(11, '2014', 'HTML5', 'La recomendación incorpora elementos semánticos y multimedia.', 11),
(12, '2015', 'HTTP/2', 'Una nueva versión del protocolo permite transportar datos de manera más eficiente.', 12),
(13, '2023', 'WCAG 2.2', 'Nuevas pautas amplían los criterios de accesibilidad del contenido web.', 13),
(14, 'Actualidad', 'Una web para más personas', 'Las experiencias móviles, el contenido multimedia y las interfaces con IA refuerzan la necesidad de accesibilidad.', 14)
ON DUPLICATE KEY UPDATE anio_texto=VALUES(anio_texto),titulo=VALUES(titulo),descripcion=VALUES(descripcion),orden=VALUES(orden);

INSERT INTO recursos_web (id,titulo,url,categoria,activo) VALUES
(1,'CERN: nacimiento de la web','https://home.cern/science/computing/the-birth-of-the-web','Historia',1),
(2,'CERN: cronología de la web','https://worldwideweb.cern.ch/timeline/','Historia',1),
(3,'MDN: fundamentos del desarrollo web','https://developer.mozilla.org/es/docs/Learn_web_development','Aprendizaje',1),
(4,'W3C: pautas de accesibilidad WCAG','https://www.w3.org/WAI/standards-guidelines/wcag/','Accesibilidad',1),
(5,'PHP: manual oficial','https://www.php.net/manual/es/','BackEnd',1)
ON DUPLICATE KEY UPDATE titulo=VALUES(titulo),url=VALUES(url),categoria=VALUES(categoria),activo=VALUES(activo);
