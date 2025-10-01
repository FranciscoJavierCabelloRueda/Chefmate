import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { RecetaService } from '../../services/receta.service';
import { Location } from '@angular/common';

@Component({
  selector: 'app-receta-detalle',
  templateUrl: './receta-detalle.component.html',
  styleUrls: ['./receta-detalle.component.css']
})
export class RecetaDetalleComponent implements OnInit {
  constructor(
    private route: ActivatedRoute,
    private router: Router,
    public recetaService: RecetaService,
    private location: Location
  ) { }

  ngOnInit(): void {
    this.cargarReceta();
  }

  async cargarReceta(): Promise<void> {
    try {
      const idRec = Number(this.route.snapshot.paramMap.get('id'));
      await this.recetaService.getReceta(idRec);
      
      if (this.recetaService.error?.includes('401')) {
        this.router.navigate(['/acceso']);
      }
    } catch (error) {
      console.error('Error al cargar la receta:', error);
    }
  }

  convertirALista(texto: string): string[] {
    return this.recetaService.convertirALista(texto);
  }

  volver(): void {
    this.location.back();
  }
}