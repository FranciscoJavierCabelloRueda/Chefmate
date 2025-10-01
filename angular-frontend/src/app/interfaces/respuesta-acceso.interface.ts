import { Usuario } from './usuario.interface';

export interface RespuestaAcceso {
    token: string;
    usuario: Usuario;
    message?: string;
}

export interface RespuestaRegistro {
    status: number;
    usuario: Usuario;
    message?: string;
} 