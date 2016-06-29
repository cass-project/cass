import {Injectable} from "angular2/core";

import {Account} from "../../account/definitions/entity/Account";
import {AuthService, AuthToken} from "./AuthService";
import {Profile} from "../../profile/definitions/entity/Profile";

@Injectable()
export class CurrentAccountService
{
    constructor(private authService: AuthService) {}

    public getToken(): AuthToken {
        if(this.authService.isSignedIn()) {
            return this.authService.getAuthToken();
        }else{
            throw new Error("You're not signed in.");
        }
    }

    public getAccount(): Account {
        return this.getToken().account;
    }

    public getCurrentProfile(): Profile {
        return this.getToken().getCurrentProfile();
    }
}