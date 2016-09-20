import {Injectable} from "@angular/core";

import {AuthService} from "../auth/service/AuthService";
import {Account} from "../account/definitions/entity/Account";
import {Profile} from "../profile/definitions/entity/Profile";
import {AuthToken} from "../auth/service/AuthToken";

@Injectable()
export class Session
{
    constructor(
        private auth: AuthService,
        private token: AuthToken
    ) {}

    isSignedIn(): boolean {
        return this.auth.isSignedIn();
    }

    getToken(): AuthToken
    {
        if(! this.isSignedIn()) {
            throw new Error("You're not signed in.");
        }

        return this.token;
    }

    getCurrentAccount(): Account {
        return this.auth.getCurrentAccount();
    }
    
    getCurrentProfile(): Profile {
        return this.auth.getCurrentAccount().getCurrentProfile();
    }
}