# 🚀 PW_pe2

Esta es la **Práctica II de la asignatura PW**, una aplicación web para gestionar **usuarios** y **actividades**, desarrollada con PHP, MySQL y JavaScript.

---

## 🗂 Estructura y conceptos principales

- ✅ Uso de **ActiveRecord** (`/models/ActiveRecord.php`) para centralizar operaciones CRUD.
- Cada tabla de la base de datos tiene su **clase correspondiente** que extiende `ActiveRecord`.
- Tablas principales:  
  - `usuario` → gestión de usuarios y roles.  
  - `actividades` → gestión de actividades y categorías.

---

## 🛠 Funcionalidades

### 👤 Gestión de usuarios
- Registro de usuarios con **hash de contraseñas**.
- Inicio de sesión y logout.
- Diferenciación entre **usuario normal** y **administrador**.

### 🏢 Administración de actividades
- Crear, modificar y eliminar actividades.
- **Paginación dinámica** de actividades.
- Filtrado por **deporte** o **modalidad**.
- Acceso exclusivo para **administradores**.

### 🖥 Interfaz y validación
- Validación de formularios con **JavaScript**.
- Carrusel dinámico de actividades con **navegación circular**.
- Plantillas (`templates`) para alertas y control de acceso.

---

## 💻 Tecnologías utilizadas

- PHP (MVC y ActiveRecord)  
- MySQL  
- JavaScript (validaciones y carrusel)  
- HTML / CSS / SCSS  

---

## 🎓 Cosas que he aprendido

- Simplificar operaciones de base de datos usando **ActiveRecord**.  
- Gestión de **sesiones** y roles de usuario.  
- Validación de formularios con **JavaScript**.  
- Creación de interfaces dinámicas con **carrusel y filtros**.  
- Paginación de datos y control de acceso de **administrador**.  
