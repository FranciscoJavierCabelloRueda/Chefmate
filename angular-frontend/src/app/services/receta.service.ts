import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Receta } from '../interfaces/receta.interface';
import { RecetaResponse } from '../interfaces/receta-response.interface';
import { AuthService } from './auth.service';

@Injectable({
  providedIn: 'root'
})
export class RecetaService {
  private readonly apiUrl = `${environment.apiUrl}/recetas`;
  receta: Receta | null = null;
  loading = false;
  error: string | null = null;

  constructor(
    private http: HttpClient,
    private authService: AuthService
  ) { }

  // Obtiene una receta específica por su ID desde el servidor
  async getReceta(id: number): Promise<void> {
    if (!id) {
      this.error = 'ID de receta no válido';
      this.loading = false;
      return;
    }

    this.loading = true;
    this.error = null;

    try {
      const response = await this.http.get<RecetaResponse>(`${this.apiUrl}/${id}`, {
        headers: this.authService.getAuthHeaders()
      }).toPromise();

      if (response?.status === 200 && response.receta) {
        this.receta = response.receta;
      } else {
        this.error = response?.mensaje || 'Error al cargar la receta';
        this.receta = null;
      }
    } catch (error: any) {
      this.error = error.error?.mensaje || 'Error al cargar la receta';
      this.receta = null;
    } finally {
      this.loading = false;
    }
  }

  // Convierte un texto con saltos de línea en un array de strings
  convertirALista(texto: string): string[] {
    if (!texto) return [];
    return texto.split('\n').filter(item => item.trim().length > 0);
  }

  // Limpia el estado del servicio
  limpiarEstado(): void {
    this.receta = null;
    this.error = null;
    this.loading = false;
  }
} 