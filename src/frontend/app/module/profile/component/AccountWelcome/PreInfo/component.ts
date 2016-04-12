import {Component, Injectable} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';




@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
    ]
})

@Injectable
export class PreInfo {
    constructor(){}

    data: any;
    profileId: number;
    nickname: string;
    firstname: string;
    lastname: string;
    middlename: string;

}