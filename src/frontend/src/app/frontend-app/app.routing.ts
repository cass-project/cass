import { Routes, RouterModule } from '@angular/router';
import {ProfileRoute} from "../../module/profile/route/ProfileRoute/index";

const appRoutes: Routes = [
    { path: 'crisis-center', component: CrisisCenterComponent },
    {
        path: 'heroes',
        component: HeroListComponent,
        data: {
            title: 'Heroes List'
        }
    },
    { path: 'profile/:id', component: ProfileRoute },
    { path: '**', component: PageNotFoundComponent }
];

export const appRoutingProviders: any[] = [

];

export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);