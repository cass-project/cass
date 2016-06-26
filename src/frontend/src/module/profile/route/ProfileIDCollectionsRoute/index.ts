import {Component} from "angular2/core";
import {RouteParams} from "angular2/router";

import {MessageBusService} from "../../../message/service/MessageBusService/index";
import {CurrentProfileService} from "../../service/CurrentProfileService";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileIDCollectionsRoute
{
    constructor(
        private messageBus: MessageBusService,
        private current: CurrentProfileService,
        params: RouteParams
    ) {
        this.current.loadProfileById(parseInt(params.get('id'), 10));
    }
}
