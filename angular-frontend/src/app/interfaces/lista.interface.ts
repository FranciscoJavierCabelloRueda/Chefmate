import { Receta } from './receta.interface';

export interface Lista {
    idLis: number;
    nombre_lista: string;
    idUsu: number;
    recetas?: Receta[];
}

export interface ListaResponse {
    status: number;
    mensaje: string;
    lista?: Lista;
    listas?: Lista[];
} 