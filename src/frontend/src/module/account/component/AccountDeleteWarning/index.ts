import {Component} from "@angular/core";
import {AuthService} from "../../../auth/service/AuthService";

@Component({
    selector: 'cass-account-delete-warning',
    template: require('./template.jade'),
})
export class AccountDeleteWarning
{
    private enabled: boolean = false;
    private date: string = 'NONE';
    
    constructor(private authService: AuthService) {
        if(authService.isSignedIn()) {
            let request = authService.getCurrentAccount().entity.delete_request;
            
            if(request.has) {
                this.enabled = true;
                this.date = request.date;
            }
        }
    }
}