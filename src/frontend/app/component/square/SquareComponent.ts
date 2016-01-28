import {Component} from 'angular2/core';
import {RouteConfig, RouterOutlet} from 'angular2/router';

@Component({
    selector: 'app',
    template: require('./template.html'),
    directives: [RouterOutlet]
})
@RouteConfig([
    {path:'/', name: 'Square', component: SquareComponent, useAsDefault: true},
])
export class SquareComponent
{
    input:number = 0;
}