export interface Usuario {
    idUsu: number;
    nombre: string;
    apellidos: string;
    email: string;
    foto?: string;
}

export interface Receta {
    idRec: number;
    titulo: string;
    descripcion: string;
    ingredientes: string;
    pasos: string; 
    foto: string | null;
    idUsu: number;
    usuario?: Usuario;
}

export interface RecetaRequest {
    titulo: string;
    descripcion: string;
    ingredientes: string[];
    pasos: string[];
    foto?: File;
    idUsu: number;
}

export interface RecetasResponse {
    status: number;
    mensaje: string;
    recetas: Receta[];
}

export interface RecetaResponse {
    status: number;
    mensaje: string;
    receta: Receta;
} 