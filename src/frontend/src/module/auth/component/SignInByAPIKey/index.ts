import {Component, Output, EventEmitter} from "@angular/core";

import {AuthService} from "../../service/AuthService";

@Component({
    selector: 'cass-auth-sign-in-by-api-key',
    template: require('./template.jade')
})

export class SignInByAPIKeyComponent
{
    @Output('close') close = new EventEmitter<boolean>();
    @Output('error') error = new EventEmitter();

    private apiKey: string = '';
    private loading: boolean = false;

    constructor(private auth: AuthService) {}
    
    cancel() {
        this.close.emit(true);
    }

    enter() {
        this.auth.signInWithAPIKey(this.apiKey);
        
        window.location.href = '/';
        window.location.reload();
    }
}
