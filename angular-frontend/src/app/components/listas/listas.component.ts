import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ListaService } from '../../services/lista.service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-listas',
  templateUrl: './listas.component.html',
  styleUrls: ['./listas.component.css']
})
export class ListasComponent implements OnInit {
  listaForm: FormGroup;
  success: string = '';

  constructor(
    public listaService: ListaService,
    private router: Router,
    private fb: FormBuilder
  ) {
    this.listaForm = this.fb.group({
      nombre_lista: ['', [Validators.required, Validators.minLength(3)]]
    });
  }

  ngOnInit(): void {
    this.listaService.cargarListas();
  }

  crearLista(): void {
    if (this.listaForm.valid) {
      const nombre_lista = this.listaForm.get('nombre_lista')?.value;
      this.listaService.crearLista(nombre_lista).then(() => {
        this.success = 'Lista creada correctamente';
        this.listaForm.reset();
      });
    }
  }

  eliminarLista(id: number): void {
    if (confirm('¿Está seguro de que desea eliminar esta lista? Esta acción no se puede deshacer.')) {
      this.listaService.eliminarLista(id);
    }
  }

  verReceta(idRec: number): void {
    this.router.navigate(['/receta', idRec]);
  }

  get listas() {
    return this.listaService.listas;
  }

  get cargando() {
    return this.listaService.cargando;
  }

  get error() {
    return this.listaService.error;
  }
} 