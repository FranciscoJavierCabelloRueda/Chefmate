import { Receta } from './receta.interface';

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