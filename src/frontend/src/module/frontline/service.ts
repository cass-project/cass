import {FrontlineResponse200} from "./definitions/paths/frontline";

var merge = require('merge');

export class FrontlineService
{
    constructor(public session: FrontlineResponse200) {}

    merge(data) {
        merge(this.session, data);
    }
}

export function frontline(callback: { (session: FrontlineResponse200) }) {
    let xhr = new XMLHttpRequest();

    xhr.open('GET', '/backend/api/frontline/*/', true);
    xhr.addEventListener("load", (event: Event) => {
        callback(JSON.parse(xhr.responseText));
    });
    xhr.send();
}