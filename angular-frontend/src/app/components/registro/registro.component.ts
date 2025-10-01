import { Component } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { DatosRegistro } from '../../interfaces/datos-registro.interface';

@Component({
  selector: 'app-registro',
  templateUrl: './registro.component.html',
  styleUrls: ['./registro.component.css']
})
export class RegistroComponent {
  datosRegistro: DatosRegistro = {
    nombre: '',
    apellidos: '',
    email: '',
    password: '',
    password_confirmation: '',
  };
  loading = false;
  error = '';

  constructor(private authService: AuthService) {}

  onFileSelected(event: any): void {
    const file = event.target.files[0];
    if (file && this.authService.validarImagenPerfil(file)) {
      this.datosRegistro.foto = file;
    }
  }

  async onSubmit(): Promise<void> {
    if (this.datosRegistro.password !== this.datosRegistro.password_confirmation) {
      this.error = 'Las contraseñas no coinciden';
      return;
    }

    this.loading = true;
    this.error = '';

    try {
      await this.authService.procesarRegistro(this.datosRegistro);
    } catch (error) {
      this.error = 'Error al registrar el usuario';
    } finally {
      this.loading = false;
    }
  }
} 