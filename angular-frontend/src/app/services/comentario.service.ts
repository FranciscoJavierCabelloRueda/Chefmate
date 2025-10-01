import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { AuthService } from './auth.service';
import { Comentario, RespuestaComentario, ComentarioData } from '../interfaces/comentario.interface';

@Injectable({
  providedIn: 'root'
})
export class ComentarioService {
  readonly apiUrl = environment.apiUrl;
  comentarios: Comentario[] = [];
  comentarioEditando: Comentario | null = null;
  loading = false;
  error: string | null = null;

  constructor(
    private http: HttpClient,
    private authService: AuthService
  ) { }

  // Carga los comentarios de una receta específica desde el servidor
  async cargarComentarios(idReceta: number): Promise<void> {
    this.loading = true;
    this.error = null;

    try {
      const response = await this.http.get<RespuestaComentario>(
        `${this.apiUrl}/comentarios/receta/${idReceta}`,
        { headers: this.authService.getAuthHeaders() }
      ).toPromise();

      if (response?.status === 200) {
        this.comentarios = response.comentarios || [];
      } else if (response?.status === 404) {
        this.comentarios = [];
      } else {
        this.error = response?.mensaje || 'Error al cargar los comentarios';
      }
    } catch (error: any) {
      this.comentarios = [];
      this.error = error.error?.mensaje || 'Error al cargar los comentarios';
    } finally {
      this.loading = false;
    }
  }

  // Crea un nuevo comentario para una receta
  async crearComentario(comentarioData: ComentarioData): Promise<void> {
    this.loading = true;
    this.error = null;

    try {
      const response = await this.http.post<RespuestaComentario>(
        `${this.apiUrl}/comentarios`,
        comentarioData,
        { headers: this.authService.getAuthHeaders() }
      ).toPromise();

      if (response?.status === 201) {
        await this.cargarComentarios(comentarioData.idRec);
      } else {
        this.error = response?.mensaje || 'Error al crear el comentario';
      }
    } catch (error: any) {
      this.error = error.error?.mensaje || 'Error al crear el comentario';
    } finally {
      this.loading = false;
    }
  }

  // Actualiza un comentario existente
  async actualizarComentario(idComentario: number, comentarioData: ComentarioData): Promise<void> {
    this.loading = true;
    this.error = null;

    try {
      const response = await this.http.put<RespuestaComentario>(
        `${this.apiUrl}/comentarios/${idComentario}`,
        comentarioData,
        { headers: this.authService.getAuthHeaders() }
      ).toPromise();

      if (response?.status === 200) {
        await this.cargarComentarios(comentarioData.idRec);
        this.comentarioEditando = null;
      } else {
        this.error = response?.mensaje || 'Error al actualizar el comentario';
      }
    } catch (error: any) {
      this.error = error.error?.mensaje || 'Error al actualizar el comentario';
    } finally {
      this.loading = false;
    }
  }

  // Elimina un comentario específico
  async eliminarComentario(idComentario: number, idReceta: number): Promise<void> {
    if (!confirm('¿Estás seguro de que deseas eliminar este comentario?')) {
      return;
    }

    this.loading = true;
    this.error = null;

    try {
      const response = await this.http.delete<RespuestaComentario>(
        `${this.apiUrl}/comentarios/${idComentario}`,
        { headers: this.authService.getAuthHeaders() }
      ).toPromise();

      if (response?.status === 200) {
        await this.cargarComentarios(idReceta);
      } else {
        this.error = response?.mensaje || 'Error al eliminar el comentario';
      }
    } catch (error: any) {
      this.error = error.error?.mensaje || 'Error al eliminar el comentario';
    } finally {
      this.loading = false;
    }
  }

  // Establece el comentario que se va a editar
  editarComentario(comentario: Comentario): void {
    this.comentarioEditando = comentario;
  }

  // Cancela la edición del comentario actual
  cancelarEdicion(): void {
    this.comentarioEditando = null;
    this.error = null;
  }

  // Verifica si un comentario pertenece al usuario actual
  esComentarioPropio(comentario: Comentario): boolean {
    const usuarioActual = this.authService.getUsuarioActual();
    if (!usuarioActual || !comentario) {
      return false;
    }
    return usuarioActual.idUsu === comentario.idUsu;
  }

  // Limpia el estado del servicio
  limpiarEstado(): void {
    this.comentarios = [];
    this.comentarioEditando = null;
    this.error = null;
    this.loading = false;
  }
}