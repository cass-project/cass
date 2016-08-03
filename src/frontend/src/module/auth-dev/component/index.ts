import {Component, Output, EventEmitter} from "angular2/core";
import {Router} from "angular2/router";
import {ModalComponent} from "../../modal/component/index";
import {ModalBoxComponent} from "../../modal/component/box/index";
import {ProgressLock} from "../../form/component/ProgressLock/index";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";

@Component({
    template: require('./template.jade'),
    selector: "cass-auth-dev",
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ProgressLock
    ]
})
export class AuthDev
{
    constructor(
        private messages: MessageBusService,
        private router: Router,
        private token: AuthToken
    ) {}
    
    apiKey: string = '';

    @Output('close') close = new EventEmitter<boolean>();
    @Output('error') error = new EventEmitter();
    
    private loading: boolean;

    cancel(){
        this.close.emit(true);
    }

    enter(){
        this.token.setToken(this.apiKey);
        localStorage.setItem('api_key', this.apiKey);
        this.router.navigate(['Profile/Profile', {id: 'current'}]);
        window.location.reload();
    }
    
}
