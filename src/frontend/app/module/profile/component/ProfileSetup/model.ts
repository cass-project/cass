import {Injectable} from "angular2/core";
import {FrontlineService} from "../../../frontline/service";

@Injectable()
export class ProfileSetupModel
{
    constructor(private frontlineService: FrontlineService){}

    gender: string = 'none';

    expertIn = (JSON.parse(JSON.stringify(this.frontlineService.session.auth.profiles[0].expert_in)));
    interestingIn = (JSON.parse(JSON.stringify(this.frontlineService.session.auth.profiles[0].interesting_in)));

    greetings = {
        greetingsMethod: '',
        first_name: '',
        last_name: '',
        middle_name: '',
        nickname: ''
    };



}