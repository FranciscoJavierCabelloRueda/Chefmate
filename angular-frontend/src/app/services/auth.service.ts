import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, BehaviorSubject } from 'rxjs';
import { Router } from '@angular/router';
import { RespuestaAcceso, RespuestaRegistro } from '../interfaces/respuesta-acceso.interface';
import { Usuario } from '../interfaces/usuario.interface';
import { DatosRegistro } from '../interfaces/datos-registro.interface';
import { DatosAcceso } from '../interfaces/datos-acceso.interface';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private apiUrl = environment.apiUrl;
  private tokenKey = 'auth_token';
  private usuarioKey = 'usuario';

  private loadingSubject = new BehaviorSubject<boolean>(false);
  private errorMessageSubject = new BehaviorSubject<string>('');

  loading$ = this.loadingSubject.asObservable();
  errorMessage$ = this.errorMessageSubject.asObservable();

  constructor(
    private http: HttpClient,
    private router: Router
  ) {}

  // Obtiene el token almacenado
  getToken(): string | null {
    return localStorage.getItem(this.tokenKey);
  }

  // Guarda el token en el almacenamiento local
  saveToken(token: string): void {
    localStorage.setItem(this.tokenKey, token);
  }

  // Elimina el token del almacenamiento local
  removeToken(): void {
    localStorage.removeItem(this.tokenKey);
  }

  // Verifica si hay un token almacenado
  isLoggedIn(): boolean {
    return !!this.getToken();
  }

  // Obtiene las cabeceras de autenticación
  getAuthHeaders(): HttpHeaders {
    const token = this.getToken();
    return new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  }

  // Procesa el inicio de sesión
  async procesarAcceso(datosAcceso: DatosAcceso): Promise<void> {
    this.loadingSubject.next(true);
    this.errorMessageSubject.next('');

    try {
      const response = await this.http.post<RespuestaAcceso>(`${this.apiUrl}/login`, datosAcceso).toPromise();
      if (response && response.token) {
        this.saveToken(response.token);
        this.saveUsuario(response.usuario);
        this.router.navigate(['/home']);
      } else {
        throw new Error('No se recibió el token del servidor');
      }
    } catch (error: any) {
      this.errorMessageSubject.next('Credenciales incorrectas');
      throw error;
    } finally {
      this.loadingSubject.next(false);
    }
  }

  // Procesa el registro de usuario
  async procesarRegistro(datosRegistro: DatosRegistro): Promise<void> {
    if (datosRegistro.password !== datosRegistro.password_confirmation) {
      this.errorMessageSubject.next('Las contraseñas no coinciden');
      return;
    }

    this.loadingSubject.next(true);
    this.errorMessageSubject.next('');

    const formData = new FormData();
    formData.append('nombre', datosRegistro.nombre);
    formData.append('apellidos', datosRegistro.apellidos);
    formData.append('email', datosRegistro.email);
    formData.append('password', datosRegistro.password);
    formData.append('password_confirmation', datosRegistro.password_confirmation);

    if (datosRegistro.foto) {
      formData.append('foto', datosRegistro.foto);
    }

    try {
      const response = await this.http.post<RespuestaRegistro>(`${this.apiUrl}/usuarios`, formData).toPromise();
      if (response && response.status === 201 && response.usuario) {
        this.saveUsuario(response.usuario);
        this.router.navigate(['/acceso']);
      } else {
        throw new Error('Error en el registro');
      }
    } catch (error: any) {
      this.errorMessageSubject.next('Error al registrar el usuario');
      throw error;
    } finally {
      this.loadingSubject.next(false);
    }
  }

  // Valida un archivo de imagen
  validarImagenPerfil(file: File): boolean {
    if (!file.type.startsWith('image/')) {
      this.errorMessageSubject.next('Por favor, seleccione un archivo de imagen válido');
      return false;
    }
    return true;
  }

  // Guarda el usuario en el almacenamiento local
  saveUsuario(usuario: Usuario): void {
    localStorage.setItem(this.usuarioKey, JSON.stringify(usuario));
  }

  // Obtiene el usuario actual
  getUsuarioActual(): Usuario | null {
    const usuario = localStorage.getItem(this.usuarioKey);
    return usuario ? JSON.parse(usuario) : null;
  }

  // Cierra la sesión del usuario
  logout(): void {
    this.removeToken();
    localStorage.removeItem(this.usuarioKey);
    this.router.navigate(['/acceso']);
  }

  // Limpia los mensajes de error
  clearError(): void {
    this.errorMessageSubject.next('');
  }
}