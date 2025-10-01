# 🍽️ Chefmate - Despliegue

El despliegue esta formado por un conjunto de plantillas CloudFormation (YAML) que definen la infraestructura para una aplicación web desplegada en Amazon Web Services (AWS). La arquitectura se basa en una distribución de roles por servidor (frontend, backend, base de datos, balanceadores de carga, zona DNS, etc.), diseñada para lograr alta disponibilidad, seguridad y escalabilidad.

---

## 🌐 Descripción General de la Arquitectura

El sistema está compuesto por:

- **Zona DNS gestionada con Route 53**
- **Instancia de landing page (EC2)**
- **Balanceador de carga externo** que enruta tráfico a:
  - **Instancias frontend (EC2 con Angular en Docker)**
- **Balanceador de carga interno** que enruta a:
  - **Instancias backend (EC2 con Laravel API en Docker)**
- **Servidor de base de datos (EC2 con MySQL en Docker)**
- **Grupos de seguridad personalizados**

---

## 📦 Despliegue

Es necesario seguir el siguiente orden a la hora de desplegar:

1. `securitygroups.yaml`  
   🔐 Crea los grupos de seguridad para los diferentes puertos (443, 80, 22, etc.)

2. `hostedzone.yaml`  
   🌍 Define la zona hospedada en Route 53 y configura los registros DNS.

3. `database.yaml`  
   🛢️ Lanza la instancia EC2 para la base de datos con MySQL dentro de un contenedor Docker.

4. `backend-1.yaml` y `backend-2.yaml`  
   🧠 Crea las dos instancias del backend Laravel dentro de contenedores Docker generados por [Dockerfile](/laravel-backend/Dockerfile).

5. `internal-load-balancer.yaml`  
   🔁 Configura un Internal Load Balancer para distribuir el tráfico entre las instancias backend.

6. `frontend-1.yaml` y `frontend-2.yaml`  
   🎨 Crea las instancias Angular para el frontend dentro de contenedores Docker generados por [Dockerfile](/angular-frontend/Dockerfile) junto con una configuración para [Nginx](/angular-frontend/nginx/nginx.conf).

7. `external-load-balancer.yaml`  
   🌐 Configura el External Load Balancer que distribuye tráfico entre las instancias frontend.

8. `landing.yaml`  
   🍽️ Despliega la instancia con la página de aterrizaje que redirige al login.

Una vez creados los servidores deberemos de hacer lo siguiente:

1. **Crear tres entradas DNS públicas usando [DuckDNS](https://www.duckdns.org/) o cualquier otro distribuidor de DNS's:**

   Asignaremos las IP públicas de los balanceadores y la landing page a los siguientes subdominios:

   - `chefmate-landing.duckdns.org` → IP pública de la instancia `landing`
   - `chefmate.duckdns.org` → IP pública del `external-load-balancer`
   - `chefmate-internal.duckdns.org` → IP pública del `internal-load-balancer`

2. **Acceder por SSH a cada uno de los siguientes servidores:**

   - Instancia `landing`
   - Instancias del `external load balancer` 
   - Instancias del `internal load balancer` 

3. **Instalar Certbot para habilitar HTTPS:**

   En cada servidor:

   ```bash

   sudo snap install --classic certbot
   sudo ln -s /snap/bin/certbot /usr/bin/certbot
   sudo certbot --apache

   ```
---

## 🧩 Descripción de Cada Servidor

### `landing.yaml`
- EC2 que sirve la página de aterrizaje.
- Contiene lógica para redirigir al frontend.

### `frontend-1.yaml` y `frontend-2.yaml`
- EC2 con aplicación Angular con Docker y Nginx.
- El frontend consume la API REST del backend a través del balanceador interno.

### `backend-1.yaml` y `backend-2.yaml`
- EC2 con Laravel con Docker y Apache.
- Configura archivo .env
- Monta las tablas de la base de datos y la puebla con información.
- Se comunican con la base de datos y responden a peticiones del frontend.

### `database.yaml`
- EC2 con contenedor Docker que corre MySQL.
- Solo accesible desde los servidores backend.

### `internal-load-balancer.yaml`
- Redirige tráfico al backend.

### `external-load-balancer.yaml`
- Redirige el tráfico al frontend.

### `hostedzone.yaml`
- Configura una zona en Route 53.
- Asocia subdominios a los distintos componentes (landing, frontend...).

### `securitygroups.yaml`
- Define las reglas de acceso de red entre los distintos servidores.
- Segmenta tráfico por puertos.
