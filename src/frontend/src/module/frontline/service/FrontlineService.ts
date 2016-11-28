import {Injectable} from "@angular/core";
import {FrontlineResponse200} from "../definitions/paths/frontline";

var merge = require('merge');

@Injectable()
export class FrontlineService
{
    constructor(public session: FrontlineResponse200) {}

    merge(data) {
        merge(this.session, data);
    }
}