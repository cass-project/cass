import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES, ROUTER_PROVIDERS, RouteConfig, Location, Router} from 'angular2/router';

@Component({
    directives: [ROUTER_DIRECTIVES],
    selector: 'cass-auth-oauth2',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class OAuth2Component
{
    constructor(){
    }


    oAuthGo(url: string){
        /*ToDo: Make angular2 great again!*/
        return window.location.href = url;
    }
}