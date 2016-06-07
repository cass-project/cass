import {Palette} from "../util/definitions/palette";
var merge = require('merge');

import {AccountEntity} from "../account/entity/Account";
import {ProfileEntity} from "../profile/entity/Profile";
import {ThemeTree} from "../theme/entity/Theme";

export class FrontlineService
{
    constructor(public session: FrontlineSessionData) {}

    merge(data) {
        merge(this.session, data);

        console.log(this.session);
    }
}

export interface FrontlineSessionData
{
    auth?: {
        api_key: string,
        account: AccountEntity,
        profiles: Array<ProfileEntity>,
    },
    themes: ThemeTree[];
    config: {
        account: {
            delete_account_request_days: number
        },
        profile: {
            max_profiles: number
        },
        colors: Palette[],
        community: {
            features: {
                code: string;
                is_development_ready: boolean,
                is_production_ready: boolean,
            }[]
        }
    }
}

export function frontline(callback: { (session: FrontlineSessionData) }) {
    let xhr = new XMLHttpRequest();

    xhr.open('GET', '/backend/api/frontline/*/', true);
    xhr.addEventListener("load", (event: Event) => {
        callback(JSON.parse(xhr.responseText));
    });
    xhr.send();
}