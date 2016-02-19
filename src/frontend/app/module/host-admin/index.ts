import {Component} from 'angular2/core';
import {Injectable} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
interface Theme {
    id: number;
    name: string;
}

@Component({
    selector: 'host-admin',
    template: require('./template.html'),
    directives: [ROUTER_DIRECTIVES],
})
export class HostAdminComponent
{
    themes = THEMES;
    addTheme(newTheme:string){
        if(newTheme){
            this.themes.push({"id": THEMES.length + 2, "name": newTheme});
        }
        //selectedTheme: Theme;
        //onselect(theme: Theme) {this.selectedTheme = theme;}
    }
}
var THEMES = [{"id": 1, "name": "test1"}, {"id": 2, "name": "test2"}];