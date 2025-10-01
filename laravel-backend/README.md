# 🍽️ Chefmate - Backend

## 🚀 Descripción General
El backend de **ChefMate** está desarrollado con **Laravel 12** y proporciona toda la lógica de negocio y la infraestructura necesaria para la gestión de usuarios, recetas, listas personalizadas y comentarios dentro de la plataforma. 

Incluye un sistema completo de autenticación, una API RESTful documentada con Swagger, validaciones robustas, protección de rutas y una interfaz administrativa construida con Blade.

---

## 🔐 Autenticación
- Implementada mediante **Laravel Sanctum** para la API REST.
- Registro, login y logout con token.
- Sistema de roles (usuario y administrador).
- Acceso restringido a rutas protegidas mediante middlewares (`auth:sanctum`, `admin`, etc.).

---

## 🔢 Validación de Datos
- Validaciones robustas en controladores usando el sistema de reglas de Laravel (`$request->validate()`).
- Mensajes de error mostrados correctamente en vistas Blade.

---

## 🔄 Migraciones, Seeders y Factories
- Estructura de base de datos generada completamente con **migraciones**.
- Datos de prueba generados usando **seeders** y **factories**.

---

## ⛓️ Protección de Rutas
- Uso de middlewares de Laravel para proteger zonas según tipo de usuario.
- Rutas de administración protegidas con middleware `admin`.
- API segmentada con middleware `auth:sanctum`.

---

## 🔍 Agrupación y Nombrado de Rutas
- Rutas agrupadas por funcionalidad y accesibilidad.

---

## 🌈 Vistas y Plantillas Blade
- Toda la parte de administración implementada con **Blade**:
  - Layouts reutilizables con `@extends`
  - Componentes (`@component`) 

---

## 🌍 Internacionalización
- Implementada en **español** e **inglés**.
- Archivos de traducción localizados en `resources/lang/{es,en}`.
- Uso de `__('clave')` en todas las vistas.

---

## 📂 Almacenamiento de Archivos
- Sistema de ficheros de Laravel:
  - Disco `public` para recetas 
  - Disco `private` para fotos de perfil

---

## 📊 API RESTful
- Desarrollada con **Laravel Sanctum** y controladores 
- Protección con `auth:sanctum`

### Ejemplos de Endpoints:
- `GET /api/usuarios` → Listado de usuarios
- `POST /api/usuarios` → Crear usuario
- `GET /api/usuarios/{id}` → Mostrar usuario
- `PUT /api/usuarios/{id}` → Actualizar usuario
- `DELETE /api/usuarios/{id}` → Eliminar usuario

---

## 📑 Documentación de la API (Swagger)
- Integrado con **L5-Swagger**
- Anotaciones `@OA` en todos los controladores API
- Accesible desde:
  - [`/api/documentation`](https://chefmate-internal.duckdns.org/api/documentation)
- Define esquemas, rutas, respuestas, autenticación y ejemplos
