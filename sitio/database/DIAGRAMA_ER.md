# Modelo entidad-relación (ADA 4)

Este modelo representa las cinco tablas del archivo `conexion_web_ada4.sql`. Las relaciones se implementan con claves foráneas y permiten registrar participaciones asociadas a un participante y un tema.

```mermaid
erDiagram
    PARTICIPANTES ||--o{ PARTICIPACIONES : registra
    TEMAS ||--o{ PARTICIPACIONES : clasifica
    PARTICIPANTES {
      INT id PK
      VARCHAR nombre
      VARCHAR correo UK
      TIMESTAMP creado_en
    }
    TEMAS {
      INT id PK
      VARCHAR clave UK
      VARCHAR nombre
    }
    PARTICIPACIONES {
      INT id PK
      INT participante_id FK
      INT tema_id FK
      TINYINT horas_web
      ENUM modalidad
      VARCHAR mensaje
      TIMESTAMP creado_en
    }
    HITOS_WEB {
      INT id PK
      VARCHAR anio_texto
      VARCHAR titulo
      TEXT descripcion
      INT orden UK
    }
    RECURSOS_WEB {
      INT id PK
      VARCHAR titulo
      VARCHAR url
      VARCHAR categoria
      BOOLEAN activo
    }
```

Las tablas `hitos_web` y `recursos_web` son catálogos informativos independientes. `participaciones` depende de `participantes` y `temas`; sus filas se guardan mediante la aplicación PHP. Todas las tablas se crean automáticamente con el script SQL.
