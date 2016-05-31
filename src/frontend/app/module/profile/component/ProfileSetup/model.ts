import {Injectable, Input,} from "angular2/core";
import {FrontlineService} from "../../../frontline/service";
import {ProfileSetup} from "./index";

@Injectable()
export class ProfileSetupModel
{
    constructor(private frontlineService: FrontlineService){}


    //profile = (JSON.parse(JSON.stringify(this.frontlineService.session.auth.profiles[0])));


    interestingIn = [];
    expertIn =  [];

    gender = 'none';

    greetings = {
        greetings_method: '',
        first_name: '',
        last_name: '',
        middle_name: '',
        nickname: ''
    };
}