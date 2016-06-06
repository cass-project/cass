import {Injectable, Input,} from "angular2/core";
import {FrontlineService} from "../../../frontline/service";
import {ProfileSetup} from "./index";
import {ProfileSetupScreenImage} from "./Screen/ProfileSetupScreenImage/index";

@Injectable()
export class ProfileSetupModel
{
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