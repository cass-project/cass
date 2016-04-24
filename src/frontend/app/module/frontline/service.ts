import {AccountEntity} from "../account/entity/Account";
import {ProfileEntity} from "../profile/entity/Profile";
import {Injectable, Inject} from "angular2/core";
import {ThemeTree} from "../theme/Theme";
import {CollectionLeaf} from "../collection/Collection";

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
    themes: ThemeTree[],
    collections?: CollectionLeaf[];
}


export function frontline(callback: { (session: FrontlineSessionData) }) {
    let xhr = new XMLHttpRequest();

    xhr.open('GET', '/backend/api/frontline/', true);
    xhr.addEventListener("load", (event: Event) => {
        callback(JSON.parse(xhr.responseText));
    });
    xhr.send();
}