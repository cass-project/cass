import {Component, Output, EventEmitter} from "@angular/core";
import {AuthService} from "../../auth/service/AuthService";

@Component({
    selector: 'cass-auth-dev',
    template: require('./template.jade')
})

export class AuthDev
{
    constructor(
        private auth: AuthService
    ) {}
    
    apiKey: string = '';

    @Output('close') close = new EventEmitter<boolean>();
    @Output('error') error = new EventEmitter();
    
    private loading: boolean;
    
    cancel(){
        this.close.emit(true);
    }

    enter(){
        this.auth.signInWithAPIKey(this.apiKey);
        
        window.location.href = '/';
        window.location.reload();
    }
    
}
