import {Injectable} from "@angular/core";

import {AuthService} from "../../auth/service/AuthService";
import {Profile} from "../definitions/entity/Profile";

@Injectable()
export class CurrentProfileService
{
    constructor(private auth: AuthService) {}

    get(): Profile {
        return this.auth.getCurrentAccount().getCurrentProfile();
    }
}