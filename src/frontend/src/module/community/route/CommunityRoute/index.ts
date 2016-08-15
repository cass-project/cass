import {Component} from "@angular/core";
import {Router, ROUTER_DIRECTIVES, RouteParams, RouteConfig} from "@angular/router-deprecated";

import {CollectionCreateMaster} from "../../../collection/component/Modal/CollectionCreateMaster/index";
import {CommunityCollectionsRoute} from "../CommunityCollectionsRoute/index";
import {CommunityDashboardRoute} from "../CommunityDashboardRoute/index";
import {CommunityHeader} from "../../component/Elements/CommunityHeader/index";
import {CommunityModalService} from "../../service/CommunityModalService";
import {CommunityService} from "../../service/CommunityService";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {ModalComponent} from "../../../modal/component/index";
import {ProgressLock} from "../../../form/component/ProgressLock/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        ProgressLock,
        CommunityHeader,
        ModalComponent,
        ModalBoxComponent,
        CollectionCreateMaster
    ],
    providers: [
        FeedCriteriaService,
        FeedOptionsService,
    ]
})
@RouteConfig([
    {
        path: '/',
        name: 'Dashboard',
        component: CommunityDashboardRoute,
        useAsDefault: true
    },
    {
        path: '/collections/...',
        name: 'Collections',
        component: CommunityCollectionsRoute
    },
])
export class CommunityRoute
{
    constructor(
        private params: RouteParams,
        private router: Router,
        private modals: CommunityModalService,
        private communityService: CommunityService
    ) {
        let sid = params.get('sid');
        if (sid){
            communityService.getCommunityBySid(sid).subscribe(
                () => {},
                () => router.navigate(['/CommunityRoot/NotFound'])
            );
        } else {
            router.navigate(['/CommunityRoot/NotFound']);
        }
    }
}