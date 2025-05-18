# 🌐 Ambiente de Aprendizaje

**Ambiente de Aprendizaje** es una plataforma educativa piloto diseñada para facilitar el proceso de enseñanza-aprendizaje entre profesores y alumnos. Funciona como una herramienta centralizada donde se pueden cargar temas, asociar objetos didácticos (archivos de apoyo) y promover la interacción mediante foros, grupos y mensajería interna.

> ⚠️ Este proyecto es una versión inicial con funcionalidades limitadas. Se encuentra en fase de desarrollo y mejora constante.

---

## 🚀 Características Principales

- **Gestión de temas y subtemas:** Permite cargar contenidos educativos y adjuntar objetos didácticos como archivos PDF, presentaciones, imágenes, etc.
- **Sistema de foros:** Los administradores pueden crear foros de discusión, y todos los usuarios pueden participar comentando.
- **Registro de usuarios:** Alumnos y profesores tienen que ser registrados en la plataforma por un administrador o profesor.
- **Grupos de usuarios:** Es posible agrupar usuarios y asociarlos con temas específicos.
- **Mensajería interna:** Los usuarios pueden enviarse mensajes para facilitar la comunicación.
- **Control de accesos:** El sistema diferencia los permisos según el rol (alumno, profesor o administrador).

---

## 👤 Usuarios de Prueba

Puedes iniciar sesión con los siguientes usuarios de prueba:

| Rol         | Usuario       | Contraseña   |
|-------------|---------------|--------------|
| Administrador | `administrador` | `administrador` |
| Alumno      | `alumno`      | `alumno`     |
| Alumno      | `alumno3`     | `alumno3`    |

---

## ⚙️ Proceso de Instalación

### Requisitos

- Servidor web con **Apache**
- **PHP 5.x**
- **MySQL 5.x**
- Navegador moderno

### Pasos

1. **Clonar o descargar el repositorio** en el directorio raíz de tu servidor web (por ejemplo, `/var/www/html`):

   ```bash
   git clone https://github.com/aldomontero/ambiente_aprendizaje.git

2. **Crear la base de datos** MySQL (por ejemplo, aldom_com_ambiente).

3. **Importar el archivo .sql incluido** (aldom_com_ambiente.sql) con la estructura y datos iniciales:

   `
  mysql -u root -p  aldom_com_ambiente < aldom_com_ambiente.sql
   `

4. **Verificar permisos de carpetas** si es necesario para lectura/escritura.

5. **Acceder a la aplicación desde el navegador**, ejemplo http://localhost/tu_repositorio/:

---

## 📦 Capuras de pantalla
- Inicio
  ![inicio.png](_Screenshots%2Finicio.png)
- Inicio de sesión
  ![inicio_sesion.png](_Screenshots%2Finicio_sesion.png)
- Material
![agregar_material.png](_Screenshots%2Fagregar_material.png)
- Asignar temas a grupos
![asignar_temas_a_grupos.png](_Screenshots%2Fasignar_temas_a_grupos.png)
- Asignar usuarios a grupos
![asignar_usuario_a_grupo.png](_Screenshots%2Fasignar_usuario_a_grupo.png)
- Foros
![foros.png](_Screenshots%2Fforos.png)
- Grupos
![grupos.png](_Screenshots%2Fgrupos.png)
- Mensajes
![mensajes.png](_Screenshots%2Fmensajes.png)
- Temas
![temas.png](_Screenshots%2Ftemas.png)
- Temas y subtemas
![temas_y_subtemas.png](_Screenshots%2Ftemas_y_subtemas.png)
- Usuarios
![usuarios.png](_Screenshots%2Fusuarios.png)

---
