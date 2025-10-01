# ETAPA 1: COMPILAR LA APLICACIÓN

# Usa una imagen ligera de Node 18 con Alpine
FROM node:18-alpine as dev-deps

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copia los archivos necesarios para instalar dependencias
COPY package.json package.json

# Instala las dependencias del proyecto
RUN npm install

# Copia todo el código fuente del proyecto al contenedor
COPY . .

# Compila la aplicación Angular para producción
RUN npm run build

# ETAPA 2: SERVIR LA APLICACIÓN CON NGINX

# Usa una imagen oficial de NGINX para servir archivos estáticos
FROM nginx:1.23.3 as prod

# Expone el puerto 80 para acceso HTTP desde fuera del contenedor
EXPOSE 80

# Copia el resultado del build (archivos compilados Angular) al directorio público de NGINX
COPY --from=dev-deps /app/dist/angular-frontend /usr/share/nginx/html

# Elimina la configuración por defecto de NGINX
RUN rm /etc/nginx/conf.d/default.conf

# Copia una configuración personalizada de NGINX
COPY nginx/nginx.conf /etc/nginx/conf.d/default.conf

# Comando para mantener NGINX en ejecución en primer plano 
CMD ["nginx", "-g", "daemon off;"]