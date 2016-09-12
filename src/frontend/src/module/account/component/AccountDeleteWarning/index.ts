import {Component, Directive} from "@angular/core";
import {AuthService} from "../../../auth/service/AuthService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-account-delete-warning'})
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