import { Component } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { DatosAcceso } from '../../interfaces/datos-acceso.interface';

@Component({
  selector: 'app-acceso',
  templateUrl: './acceso.component.html',
  styleUrls: ['./acceso.component.css']
})
export class AccesoComponent {
  datosAcceso: DatosAcceso = {
    email: '',
    password: ''
  };
  loading = false;
  error = '';

  constructor(private authService: AuthService) {}

  async onSubmit(): Promise<void> {
    this.loading = true;
    this.error = '';

    try {
      await this.authService.procesarAcceso(this.datosAcceso);
    } catch (error) {
      this.error = 'Credenciales incorrectas';
    } finally {
      this.loading = false;
    }
  }
} 