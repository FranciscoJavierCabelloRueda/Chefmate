# 🍽️ ChefMate - Frontend 

Este es el frontend de la aplicación ChefMate, desarrollado con Angular 16. La aplicación proporciona una interfaz de usuario moderna para interactuar con el backend de Laravel.

## 🛠️ Tecnologías Principales

- **Angular 16**: Framework principal de desarrollo
- **Angular Router**: Para la navegación entre componentes
- **HttpClient**: Para realizar peticiones HTTP a la API
- **Angular Forms**: Para la gestión de formularios reactivos

## 🏗️ Arquitectura

### Módulos Principales
- `AppModule`: Módulo raíz de la aplicación
- `AppRoutingModule`: Gestión de rutas y navegación
- `HttpClientModule`: Para comunicación con la API
- `FormsModule` y `ReactiveFormsModule`: Para manejo de formularios

### Componentes
- `HomeComponent`: Página principal
- `AccesoComponent`: Login de usuarios
- `RegistroComponent`: Registro de nuevos usuarios
- `CuentaComponent`: Gestión del perfil
- `RecetasComponent`: Listado de recetas
- `RecetaDetalleComponent`: Vista detallada de receta
- `ComentariosComponent`: Sistema de comentarios
- `ListasComponent`: Gestión de listas personalizadas
- `NavbarComponent`: Barra de navegación
- `FooterComponent`: Pie de página

### Servicios
- `AuthService`: Gestión de autenticación y tokens
- `RecetasService`: Operaciones con recetas
- `Receta-detalleService`: Operaciones con una receta específica
- `ListasService`: Gestión de listas personalizadas
- `ComentariosService`: Manejo de comentarios
- `CuentaService`: Manejo de de datos de Usuario

## 🔐 Seguridad y Autenticación

- Implementación de `AuthGuard` para proteger rutas privadas
- Almacenamiento seguro de tokens en localStorage
- Manejo de sesiones con Laravel Sanctum

## 📡 Comunicación con el Backend

- Uso de `HttpClient` para peticiones REST
- Manejo de respuestas asíncronas con Observables
- Interceptores para manejo global de errores
- Endpoints configurados según el ambiente (development/production)


## 📡 Comunicación entre Componentes

La aplicación utiliza diferentes métodos de comunicación entre componentes para mantener un flujo de datos coherente:

### 1. @Input/@Output
Usado para la comunicación padre-hijo, principalmente en:

```typescript
// Ejemplo en ComentariosComponent
@Component({
  selector: 'app-comentarios'
})
export class ComentariosComponent {
  @Input() idReceta!: number; // Recibe ID de RecetaDetalleComponent
}
```

### 2. Servicios Compartidos
Los principales servicios que gestionan la comunicación son:

- **AuthService**: Gestiona el estado de autenticación
```typescript
@Injectable({
  providedIn: 'root'
})
export class AuthService {
  getUsuarioActual(): Usuario | null {
    return JSON.parse(localStorage.getItem('usuario') || 'null');
  }
}
```

- **RecetaService**: Comparte datos de recetas entre componentes
```typescript
@Injectable({
  providedIn: 'root'
})
export class RecetaService {
  receta: Receta | null = null;
}
```

### 3. Estado Global
Almacenamiento y gestión del estado mediante localStorage:

```typescript
// Guardar usuario
localStorage.setItem('usuario', JSON.stringify(usuario));

// Recuperar usuario
const usuario = JSON.parse(localStorage.getItem('usuario') || 'null');
```

### 4. Observables
Utilizados para manejar datos asíncronos y eventos:

```typescript
export class ListaService {
  private apiUrl = environment.apiUrl + '/listas';
  listas$ = new BehaviorSubject<Lista[]>([]);

  cargarListas(): void {
    this.http.get<ListaResponse>(this.apiUrl).subscribe(
      response => this.listas$.next(response.listas)
    );
  }
}
```

### 5. Navegación y Parámetros
Comunicación entre componentes mediante el router:

```typescript
// Enviar parámetros
this.router.navigate(['/receta', idReceta]);

// Recibir parámetros
this.route.params.subscribe(params => {
  const id = params['id'];
});
```