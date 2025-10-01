import { Component, OnInit, OnDestroy } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { CuentaService } from '../../services/cuenta.service';
import { DatosCuenta } from '../../interfaces/datos-cuenta.interface';
import { Usuario } from '../../interfaces/usuario.interface';
import { SafeUrl } from '@angular/platform-browser';

@Component({
  selector: 'app-cuenta',
  templateUrl: './cuenta.component.html',
  styleUrls: ['./cuenta.component.css']
})
export class CuentaComponent implements OnInit, OnDestroy {
  usuario: Usuario | null = null;
  datosCuenta: DatosCuenta = {
    nombre: '',
    apellidos: '',
    email: '',
    password: ''
  };
  selectedFile: File | null = null;
  fotoUrl: SafeUrl | null = null;
  previewUrl: SafeUrl | null = null;

  constructor(
    private authService: AuthService,
    public cuentaService: CuentaService
  ) {}

  ngOnInit(): void {
    this.cargarDatosUsuario();
  }

  ngOnDestroy(): void {
    this.limpiarUrls();
  }

  private async cargarDatosUsuario(): Promise<void> {
    try {
      const response = await this.cuentaService.obtenerDatosUsuario();
      this.usuario = response.usuario;
      this.datosCuenta = {
        nombre: response.usuario.nombre,
        apellidos: response.usuario.apellidos,
        email: response.usuario.email,
        password: ''
      };
      
      if (response.usuario.foto) {
        await this.cargarFoto();
      }
    } catch (error) {
    }
  }

  private async cargarFoto(): Promise<void> {
    try {
      const blob = await this.cuentaService.obtenerFoto();
      this.cuentaService.limpiarUrl(this.fotoUrl);
      this.fotoUrl = this.cuentaService.crearUrlSegura(blob);
    } catch (error) {
      this.fotoUrl = null;
    }
  }

  onFileSelected(event: any): void {
    const file = event.target.files[0];
    if (file) {
      const validacion = this.cuentaService.validarArchivo(file);
      if (!validacion.esValido) {
        return;
      }
      
      this.cuentaService.limpiarUrl(this.previewUrl);
      this.selectedFile = file;
      this.previewUrl = this.cuentaService.crearUrlSegura(new Blob([file]));
    }
  }

  async onSubmit(): Promise<void> {
    try {
      const response = await this.cuentaService.actualizarDatosUsuario(this.datosCuenta, this.selectedFile || undefined);
      this.usuario = response.usuario;
      this.datosCuenta = {
        nombre: response.usuario.nombre,
        apellidos: response.usuario.apellidos,
        email: response.usuario.email,
        password: ''
      };

      this.cuentaService.limpiarUrl(this.previewUrl);
      this.previewUrl = null;
      this.selectedFile = null;

      if (response.usuario.foto) {
        await this.cargarFoto();
      }
    } catch (error) {
      await this.cargarDatosUsuario();
    }
  }

  async eliminarCuenta(): Promise<void> {
    if (!confirm('¿Está seguro de que desea eliminar su cuenta? Esta acción no se puede deshacer.')) {
      return;
    }

    try {
      const response = await this.cuentaService.eliminarCuenta();
      if (response.status === 200) {
        this.authService.logout();
      }
    } catch (error) {
    }
  }

  private limpiarUrls(): void {
    this.cuentaService.limpiarUrl(this.fotoUrl);
    this.cuentaService.limpiarUrl(this.previewUrl);
    this.fotoUrl = null;
    this.previewUrl = null;
  }
} 