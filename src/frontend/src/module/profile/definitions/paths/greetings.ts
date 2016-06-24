import {Success200} from "../../../common/definitions/common";
import {ProfileGreetingsEntity} from "../entity/Profile";

export interface GreetingsRequest
{
    first_name?: string;
    last_name?: string;
    middle_name?: string;
    nick_name?: string;
}

export interface GreetingsResponse200 extends Success200
{
    greetings: ProfileGreetingsEntity;
}