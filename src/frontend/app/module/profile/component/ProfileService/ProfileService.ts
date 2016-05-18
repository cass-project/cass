import {Injectable} from 'angular2/core';
import {frontline, FrontlineService} from "../../../frontline/service";

@Injectable()
export class ProfileService {
    constructor(public frontlineService:FrontlineService) {}


    getAccountEmail(){
        return this.frontlineService.session.auth.account.email;
    }

}