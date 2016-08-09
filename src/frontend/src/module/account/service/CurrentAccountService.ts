import {Injectable} from "@angular/core";

import {Account} from "../definitions/entity/Account";
import {AuthService} from "../../auth/service/AuthService";

@Injectable()
export class CurrentAccountService
{
    constructor(private authService: AuthService) {}
    
    public get(): Account {
        return this.authService.getCurrentAccount();
    }
}