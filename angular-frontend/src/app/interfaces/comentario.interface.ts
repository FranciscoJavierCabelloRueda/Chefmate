export interface Comentario {
  idCom: number;
  idUsu: number;
  comentario: string;
  valoracion: number;
  fecha_creacion: string;
  fecha_actualizacion: string;
  usuarios?: Usuario;
}

export interface Usuario {
  idUsu: number;
  nombre: string;
  apellidos: string;
}

export interface ComentarioData {
  comentario: string;
  valoracion: number;
  idRec: number;
}

export interface RespuestaComentario {
  status: number;
  mensaje?: string;
  comentario?: Comentario;
  comentarios?: Comentario[];
} 