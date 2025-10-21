# Pagina de musica

## Desarrolladores:

- Nombre: Martín Lorenzi
- Email: alorenzi@alumnos.exa.unicen.com

**El objetivo de este proyecto es desarrollar una aplicación de musica donde el usuario pueda:**

1. **Visualizar una lista de Artistas (categorias) y sus canciones asociadas (items)**
2. **Visualizar una lista de canciones (items) y sus detalles asociados**
3. **Registrarse en el sitio y loguarse como usuario**

#### diagrama de relacion entre tablas:

![diagrama de relacion](TP1/diagramaBD.png)

**Por lo tanto para el desarrollo de esta propuesta se considera que:**

**El usuario será capaz de visualizar un conjunto de **canciones** (ítems), cada una perteneciente a un determinado **artista\*\* (categoría).

## Acceso al sitio web desde el servidor local

### Requisitos:

1. Un servidor web instalado por ej. XAMPP
   - [XAMPP](https://www.apachefriends.org/es/index.html)

2. Clonar el repositorio publico del sitio web dentro de una carpeta con el nombre que se desee.
   - [Repositorio en GitHub](https://github.com/07martin12/web-2-tp-2)

3. Coloque la carpeta recientemente creada con la información del repositorio descargado dentro de la carpeta "hdocs" que se encuentra en la carpeta XPAMM del directorio de su pc.
   - Ruta de ayuda: este equipo/sistema(C:)/xampp/htdocs/

4. Ejecute la aplicación XAMPP y active las funcionalidades de Apache y MYSQL haciendo click en el boton star en el panel principal. Posteriormente en su navegador web acceda al siguiente link:
   - [http://localhost/webII2025/TP2/soundSnack/]
     (http://localhost/webII2025/TP2/soundSnack/)

5. La base de datos y sus tablas seran descargadas automaticamente en caso de que no existan.

## Rutas principales

### Rutas públicas (Home)

- home → Página principal
- home/login → Página de login
- home/register → Página de registro

### Rutas de administración (Admin)

Estas rutas son solo para administradores y permiten gestionar usuarios, artistas y canciones en la base de datos.

### Acceso a la sección administrativa del sitio

- **Usuario**: webadmin
- **Contraseña**: admin

## Visualización de errores y logs

La aplicación utiliza "error_log()" para registrar errores, como por ejemplo:

error_log("Archivo SQL no encontrado: $sqlFile");

Para ver los errores en XAMPP:

1. Abrir el panel de control de XAMPP.
2. Hacer clic en el botón **Logs** al lado de **Config**.
3. Seleccionar **Apache (error.log)**.
4. Posteriormente se abrirá un bloc de notas con información sobre los últimos errores de la aplicación.
