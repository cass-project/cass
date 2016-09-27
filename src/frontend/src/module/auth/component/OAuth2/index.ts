import {Component} from "@angular/core";

@Component({
    selector: 'cass-auth-oauth2',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class OAuth2Component
{
    private getOAuth2Url(provider) {
        let url = '/backend/api/auth/oauth';

        return `${url}/${provider}`
    }

    oAuthGo(provider: string){
        window.location.href = this.getOAuth2Url(provider);
    }
}