import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { RecetasService } from '../../services/recetas.service';
import { AuthService } from '../../services/auth.service';
import { Receta } from '../../interfaces/receta.interface';

@Component({
  selector: 'app-recetas',
  templateUrl: './recetas.component.html',
  styleUrls: ['./recetas.component.css']
})
export class RecetasComponent implements OnInit {
  constructor(
    public recetasService: RecetasService,
    private authService: AuthService,
    private router: Router
  ) { }

  ngOnInit(): void {
    if (!this.authService.isLoggedIn()) {
      this.router.navigate(['/acceso'], { 
        queryParams: { returnUrl: this.router.url } 
      });
      return;
    }

    this.cargarRecetas();
  }

  async cargarRecetas(): Promise<void> {
    await this.recetasService.listarRecetas();
  }

  getColumnRecipes(columnIndex: number): Receta[] {
    return this.recetasService.getColumnRecipes(this.recetasService.recetas, columnIndex);
  }
} 