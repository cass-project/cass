import {Component} from "angular2/core";
import {AuthService} from "../../../auth/service/AuthService";

@Component({
    selector: 'cass-account-delete-warning',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class AccountDeleteWarning
{
    private enabled: boolean = false;
    private date: string = 'NONE';
    
    constructor(private authService: AuthService) {
        if(AuthService.isSignedIn()) {
            let token = AuthService.getAuthToken();
            let request = token.account.entity.delete_request;
            
            if(request.has) {
                this.enabled = true;
                this.date = request.date;
            }
        }
    }
}