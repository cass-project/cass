import {AccountEntity} from "../account/entity/Account";
import {ProfileEntity} from "../profile/entity/Profile";

export class FrontlineService
{
    constructor(public session: FrontlineSessionData) {}
}

export interface FrontlineSessionData
{
    auth?: {
        api_key: string,
        account: AccountEntity,
        profiles: Array<ProfileEntity>,
    },
}


export function frontline(callback: { (session: FrontlineSessionData) }) {
    let xhr = new XMLHttpRequest();

    xhr.open('GET', '/backend/api/frontline/', true);
    xhr.addEventListener("load", (event: Event) => {
        callback(JSON.parse(xhr.responseText));
    });
    xhr.send();
}