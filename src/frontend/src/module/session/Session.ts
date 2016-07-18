import {Injectable} from "angular2/core";

import {AuthService} from "../auth/service/AuthService";
import {Account} from "../account/definitions/entity/Account";
import {Profile} from "../profile/definitions/entity/Profile";

@Injectable()
export class Session
{
    constructor(private auth: AuthService) 
    {}

    isSignedIn(): boolean {
        return this.auth.isSignedIn();
    }
    
    getCurrentAccount(): Account {
        return this.auth.getCurrentAccount();
    }
    
    getCurrentProfile(): Profile {
        return this.auth.getCurrentAccount().getCurrentProfile();
    }
}