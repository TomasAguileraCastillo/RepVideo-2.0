# RepVideo-2.0

Sistema web para la gestión y reproducción de videos educativos.

## Tabla de Contenidos

- [Descripción](#descripción)
- [Características](#características)
- [Instalación](#instalación)
- [Uso](#uso)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Lenguajes y Tecnologias](#Lenguajes-y-Tecnologías)
- [Contribuciones](#contribuciones)
- [Licencia](#licencia)

## Descripción

RepVideo-2.0 es una plataforma desarrollada en PHP que permite administrar, subir y reproducir videos para cursos y usuarios registrados.

## Características

- Gestión de usuarios y autenticación.
- Subida y administración de videos.
- Reproductor de video integrado.
- Panel de administración para cursos y videos.
- Interfaz responsiva y moderna.

## Instalación

1. Clona el repositorio:
   ```
   git clone https://github.com/TomasAguileraCastillo/RepVideo-2.0.git
   ```
2. Coloca la carpeta en tu servidor local (ejemplo: XAMPP en `htdocs`).
3. Configura la base de datos en el archivo `/config/` (si aplica).
4. Accede desde tu navegador a `http://localhost/RepVideo-2.0/public/index.php`.

## Uso

- Inicia sesión con tu usuario.
- Sube videos desde el panel de administración.
- Visualiza y gestiona los videos y usuarios.

## Estructura del Proyecto

```
/public/           # Archivos públicos (index.php, CSS, JS, imágenes)
/src/              # Código fuente PHP (controladores, modelos, vistas)
/config/           # Configuración
/tests/            # Pruebas
/logs/             # Logs
/README.md
/composer.json
```

## Lenguajes y Tecnologías

- PHP 8.x
- HTML5, CSS3, JavaScript
- Bootstrap 5
- MySQL

## Contribuciones

¡Las contribuciones son bienvenidas! Por favor, abre un issue o pull request para sugerencias o mejoras.

## Licencia

[MIT](LICENSE).
