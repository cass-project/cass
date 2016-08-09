import {FrontlineResponse200} from "./definitions/paths/frontline";
import {Injectable} from "@angular/core";

var merge = require('merge');

@Injectable()
export class FrontlineService
{
    constructor(public session: FrontlineResponse200) {}

    merge(data) {
        merge(this.session, data);
    }
}

export function frontline(callback: { (session: FrontlineResponse200) }) {
    let xhr = new XMLHttpRequest();
    let apiKey = window.localStorage['api_key'];

    xhr.open('GET', '/backend/api/frontline/*/', true);
    xhr.setRequestHeader('Authorization', apiKey);
    xhr.addEventListener("load", (event: Event) => {
        callback(JSON.parse(xhr.responseText));
    });
    xhr.send();
}