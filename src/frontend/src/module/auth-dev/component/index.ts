import {Component, Output, EventEmitter, Directive} from "@angular/core";
import {ModalComponent} from "../../modal/component/index";
import {ModalBoxComponent} from "../../modal/component/box/index";
import {ProgressLock} from "../../form/component/ProgressLock/index";
import {AuthService} from "../../auth/service/AuthService";

@Component({
    selector: 'cass-auth-dev',
    template: require('./template.jade'),
    providers: [ModalComponent, ModalBoxComponent, ProgressLock]
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
