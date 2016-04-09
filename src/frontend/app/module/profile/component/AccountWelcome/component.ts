import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {CurrentProfileRestService} from "../../service/CurrentProfileRestService";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ]})

export class AccountWelcome {
   constructor (private currentProfileRestService: CurrentProfileRestService
   ){}
}