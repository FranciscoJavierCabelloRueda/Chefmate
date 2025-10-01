import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Receta } from '../interfaces/receta.interface';
import { AuthService } from './auth.service';
import { RecetasResponse, RecetaResponse } from '../interfaces/receta-response.interface';

@Injectable({
  providedIn: 'root'
})
export class RecetasService {
  private readonly apiUrl = environment.apiUrl;
  recetas: Receta[] = [];
  recetaActual: Receta | null = null;
  error: string | null = null;

  constructor(
    private http: HttpClient,
    private authService: AuthService
  ) { }

  // Obtiene y guarda la lista de recetas desde la API. Maneja estado de carga y errores.
  async listarRecetas(): Promise<void> {
    this.error = null;

    try {
      const response = await this.http.get<RecetasResponse>(`${this.apiUrl}/recetas`, {
        headers: this.authService.getAuthHeaders()
      }).toPromise();

      if (response?.status === 200) {
        this.recetas = response.recetas;
      } else {
        this.error = response?.mensaje || 'Error al cargar las recetas';
      }
    } catch (error: any) {
      this.recetas = [];
      this.error = error.error?.mensaje || 'Error al cargar las recetas';
    } finally {
    }
  }

  // Obtiene y guarda una receta específica por ID desde la API.
  async obtenerReceta(id: number): Promise<void> {
    if (!id) {
      this.error = 'ID de receta no válido';
      return;
    }

    this.error = null;

    try {
      const response = await this.http.get<RecetaResponse>(`${this.apiUrl}/recetas/${id}`, {
        headers: this.authService.getAuthHeaders()
      }).toPromise();

      if (response?.status === 200) {
        this.recetaActual = response.receta;
      } else {
        this.error = response?.mensaje || 'Error al obtener la receta';
        this.recetaActual = null;
      }
    } catch (error: any) {
      this.error = error.error?.mensaje || 'Error al obtener la receta';
      this.recetaActual = null;
    } finally {
    }
  }

  // Filtra las recetas para distribuirlas en una columna según su índice.
  getColumnRecipes(recetas: Receta[], columnIndex: number): Receta[] {
    return recetas.filter((_, index) => index % 3 === columnIndex);
  }

  // Limpia el estado de recetas, errores y carga.
  limpiarEstado(): void {
    this.recetas = [];
    this.recetaActual = null;
    this.error = null;
  }
}