import { Component, OnInit } from '@angular/core';
import { CuentaService } from '../../services/cuenta.service';
import { Usuario } from '../../interfaces/usuario.interface';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  usuario: Usuario | null = null;

  constructor(private cuentaService: CuentaService) {}

  ngOnInit(): void {
    this.cargarDatosUsuario();
  }

// Carga los datos del usuario desde el servicio si la respuesta es exitosa.
  private async cargarDatosUsuario(): Promise<void> {
    const response = await this.cuentaService.obtenerDatosUsuario();
    if (response.status === 200) {
      this.usuario = response.usuario;
    }
  }
}