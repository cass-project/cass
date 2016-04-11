import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {CurrentProfileRestService} from "../../service/CurrentProfileRestService";
import {AccountWelcome} from "../AccountWelcome/component";


@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    'providers': [
        CurrentProfileRestService
    ]
})

export class AvatarCropper {
    constructor(private accountWelcome: AccountWelcome) {
    }
}