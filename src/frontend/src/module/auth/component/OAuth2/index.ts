import {Component} from "@angular/core";
import {ROUTER_DIRECTIVES} from '@angular/router';

@Component({
    directives: [
        ROUTER_DIRECTIVES,
    ],
    selector: 'cass-auth-oauth2',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class OAuth2Component
{
    constructor(){
    }

    private getOAuth2Url(provider){
        let url = 'backend/api/auth/oauth/';
        return `${url}${provider}`
    }

    oAuthGo(provider: string){
        /*ToDo: Make @angular great again!*/
        return window.location.href = this.getOAuth2Url(provider);
    }
}