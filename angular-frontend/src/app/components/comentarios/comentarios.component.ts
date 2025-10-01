import { Component, OnInit, OnDestroy, Input } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ComentarioService } from '../../services/comentario.service';
import { AuthService } from '../../services/auth.service';
import { Comentario } from '../../interfaces/comentario.interface';

@Component({
  selector: 'app-comentarios',
  templateUrl: './comentarios.component.html',
  styleUrls: ['./comentarios.component.css']
})
export class ComentariosComponent implements OnInit, OnDestroy {
  @Input() idReceta!: number;
  
  comentarioForm: FormGroup;
  usuarioActual: any;

  constructor(
    private fb: FormBuilder,
    public comentarioService: ComentarioService,
    public authService: AuthService
  ) {
    this.comentarioForm = this.fb.group({
      comentario: ['', [Validators.required, Validators.maxLength(1000)]],
      valoracion: [5, [Validators.required, Validators.min(1), Validators.max(5)]]
    });
  }

  ngOnInit(): void {
    this.cargarComentarios();
  }

  ngOnDestroy(): void {
    this.comentarioService.limpiarEstado();
  }

  async cargarComentarios(): Promise<void> {
    await this.comentarioService.cargarComentarios(this.idReceta);
  }

  async enviarComentario(): Promise<void> {
    if (this.comentarioForm.valid) {
      const comentarioData = {
        ...this.comentarioForm.value,
        idRec: this.idReceta
      };

      if (this.comentarioService.comentarioEditando) {
        await this.comentarioService.actualizarComentario(
          this.comentarioService.comentarioEditando.idCom,
          comentarioData
        );
      } else {
        await this.comentarioService.crearComentario(comentarioData);
      }

      this.comentarioForm.reset({ valoracion: 5 });
    }
  }

  editarComentario(comentario: Comentario): void {
    this.comentarioService.editarComentario(comentario);
    this.comentarioForm.patchValue({
      comentario: comentario.comentario,
      valoracion: comentario.valoracion
    });
  }

  cancelarEdicion(): void {
    this.comentarioService.cancelarEdicion();
    this.comentarioForm.reset({ valoracion: 5 });
  }

  async eliminarComentario(idComentario: number): Promise<void> {
    await this.comentarioService.eliminarComentario(idComentario, this.idReceta);
  }

  esComentarioPropio(comentario: Comentario): boolean {
    return this.comentarioService.esComentarioPropio(comentario);
  }
} 