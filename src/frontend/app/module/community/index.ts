import {Component} from "angular2/core";

import {CommunityRESTService} from "./service/CommunityRESTService";
import {CommunityRouteModal} from "./component/Modal/CommunityRouteModal/index";
import {CommunityCreateModal} from "./component/Modal/CommunityCreateModal/index";
import {CommunityJoinModal} from "./component/Modal/CommunityJoinModal/index";
import {CommunityComponentService} from "./service";

@Component({
    selector: 'cass-community',
    template: require('./template.html'),
    providers: [
        CommunityRESTService,
    ],
    directives: [
        CommunityRouteModal,
        CommunityCreateModal,
        CommunityJoinModal,
    ]
})
export class CommunityComponent
{
    constructor(private service: CommunityComponentService) {}
}