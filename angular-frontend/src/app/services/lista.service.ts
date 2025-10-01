import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Lista, ListaResponse } from '../interfaces/lista.interface';
import { AuthService } from './auth.service';
import { firstValueFrom } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ListaService {
  private readonly apiUrl = `${environment.apiUrl}/listas`;
  listas: Lista[] = [];
  cargando = false;
  error = '';

  constructor(
    private http: HttpClient,
    private authService: AuthService
  ) { }

  // Obtiene todas las listas del usuario desde el servidor
  cargarListas(): void {
    this.cargando = true;
    this.error = '';

    this.http.get<ListaResponse>(this.apiUrl, {
      headers: this.authService.getAuthHeaders()
    }).subscribe({
      next: (response) => {
        this.listas = response.listas || [];
        this.cargando = false;
      },
      error: (error) => {
        this.error = 'Error al cargar las listas';
        this.cargando = false;
      }
    });
  }

  // Crea una nueva lista con el nombre especificado
  async crearLista(nombre_lista: string): Promise<void> {
    this.error = '';
    
    try {
      const response = await firstValueFrom(
        this.http.post<ListaResponse>(this.apiUrl, { nombre_lista }, {
          headers: this.authService.getAuthHeaders()
        })
      );

      if (response.lista) {
        this.listas = [...this.listas, response.lista];
      }
    } catch (error) {
      this.error = 'Error al crear la lista';
      throw error;
    }
  }

  // Elimina una lista por su ID
  eliminarLista(id: number): void {
    this.error = '';
    
    this.http.delete<ListaResponse>(`${this.apiUrl}/${id}`, {
      headers: this.authService.getAuthHeaders()
    }).subscribe({
      next: () => {
        this.listas = this.listas.filter(lista => lista.idLis !== id);
      },
      error: (error) => {
        this.error = 'Error al eliminar la lista';
      }
    });
  }
} 