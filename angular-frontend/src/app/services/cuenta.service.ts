import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { AuthService } from './auth.service';
import { environment } from '../../environments/environment';
import { Usuario } from '../interfaces/usuario.interface';
import { DatosCuenta } from '../interfaces/datos-cuenta.interface';
import { DomSanitizer, SafeUrl } from '@angular/platform-browser';

@Injectable({
  providedIn: 'root'
})
export class CuentaService {
  private readonly apiUrl = environment.apiUrl;
  private readonly maxImageSize = 2 * 1024 * 1024;
  loading = false;
  error = '';
  success = '';

  constructor(
    private http: HttpClient,
    private authService: AuthService,
    private sanitizer: DomSanitizer
  ) {}

  // Obtiene los datos del usuario actual desde el servidor
  async obtenerDatosUsuario(): Promise<{status: number, usuario: Usuario, mensaje?: string}> {
    this.loading = true;
    this.error = '';

    try {
      const response = await this.http.get<any>(`${this.apiUrl}/usuario`, {
        headers: this.authService.getAuthHeaders()
      }).toPromise();

      if (response?.status === 200 && response.usuario) {
        localStorage.setItem('usuario', JSON.stringify(response.usuario));
        this.loading = false;
        return response;
      }
      throw new Error('Error al cargar los datos del usuario');
    } catch (error: any) {
      this.error = error.error?.mensaje || 'Error al cargar los datos del usuario';
      this.loading = false;
      throw error;
    }
  }

  // Obtiene la foto de perfil del usuario
  async obtenerFoto(): Promise<Blob> {
    try {
      const response = await this.http.get(`${this.apiUrl}/usuario/foto`, {
        headers: this.authService.getAuthHeaders(),
        responseType: 'blob'
      }).toPromise();
      
      if (!response) {
        throw new Error('No se pudo obtener la foto');
      }
      
      return response;
    } catch (error) {
      console.error('Error al cargar la foto:', error);
      throw error;
    }
  }

  // Valida el tamaño y formato de un archivo de imagen
  validarArchivo(archivo: File): { esValido: boolean; mensaje?: string } {
    if (archivo.size > this.maxImageSize) {
      this.error = 'La imagen no debe superar los 2MB';
      return { esValido: false, mensaje: this.error };
    }

    const tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
    if (!tiposPermitidos.includes(archivo.type)) {
      this.error = 'Solo se permiten imágenes en formato JPG, PNG o WEBP';
      return { esValido: false, mensaje: this.error };
    }

    return { esValido: true };
  }

  // Actualiza los datos del usuario en el servidor
  async actualizarDatosUsuario(datos: DatosCuenta, archivo?: File): Promise<{status: number, usuario: Usuario, mensaje: string}> {
    this.loading = true;
    this.error = '';
    this.success = '';

    const formData = new FormData();
    if (datos.nombre?.trim()) formData.append('nombre', datos.nombre.trim());
    if (datos.apellidos?.trim()) formData.append('apellidos', datos.apellidos.trim());
    if (datos.email?.trim()) formData.append('email', datos.email.trim());
    if (datos.password?.trim()) formData.append('password', datos.password.trim());
    if (archivo) formData.append('foto', archivo);

    try {
      const response = await this.http.put<any>(`${this.apiUrl}/usuario`, formData, {
        headers: this.authService.getAuthHeaders()
      }).toPromise();

      if (response?.status === 200) {
        localStorage.setItem('usuario', JSON.stringify(response.usuario));
        this.success = response.mensaje;
        this.loading = false;
        return response;
      }
      throw new Error(response?.mensaje || 'Error al actualizar los datos');
    } catch (error: any) {
      this.error = error.error?.mensaje || 'Error al actualizar los datos';
      this.loading = false;
      throw error;
    }
  }

  // Elimina la cuenta del usuario actual
  async eliminarCuenta(): Promise<{status: number, mensaje: string}> {
    this.loading = true;
    this.error = '';

    try {
      const response = await this.http.delete<any>(`${this.apiUrl}/usuario`, {
        headers: this.authService.getAuthHeaders()
      }).toPromise();

      if (response?.status === 200) {
        this.loading = false;
        return response;
      }
      throw new Error(response?.mensaje || 'Error al eliminar la cuenta');
    } catch (error: any) {
      this.error = error.error?.mensaje || 'Error al eliminar la cuenta';
      this.loading = false;
      throw error;
    }
  }

  // Crea una URL segura para mostrar imágenes
  crearUrlSegura(blob: Blob): SafeUrl {
    const objectUrl = URL.createObjectURL(blob);
    return this.sanitizer.bypassSecurityTrustUrl(objectUrl);
  }

  // Limpia una URL segura y libera sus recursos
  limpiarUrl(url: SafeUrl | null): void {
    if (url) {
      const urlString = this.sanitizer.sanitize(4, url);
      if (urlString) {
        URL.revokeObjectURL(urlString);
      }
    }
  }
} 