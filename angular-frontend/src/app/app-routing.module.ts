import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './components/home/home.component';
import { AccesoComponent } from './components/acceso/acceso.component';
import { RegistroComponent } from './components/registro/registro.component';
import { CuentaComponent } from './components/cuenta/cuenta.component';
import { RecetasComponent } from './components/recetas/recetas.component';
import { RecetaDetalleComponent } from './components/receta-detalle/receta-detalle.component';
import { AuthGuard } from './guards/auth.guard';
import { ListasComponent } from './components/listas/listas.component';

const routes: Routes = [
  { path: '', redirectTo: '/home', pathMatch: 'full' },
  { path: 'home', component: HomeComponent, canActivate: [AuthGuard] },
  { path: 'acceso', component: AccesoComponent },
  { path: 'registro', component: RegistroComponent },
  { path: 'cuenta', component: CuentaComponent, canActivate: [AuthGuard] },
  { path: 'recetas', component: RecetasComponent, canActivate: [AuthGuard] },
  { path: 'receta/:id', component: RecetaDetalleComponent, canActivate: [AuthGuard] },
  { path: 'listas', component: ListasComponent, canActivate: [AuthGuard] },
  { path: '**', redirectTo: '/acceso' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
