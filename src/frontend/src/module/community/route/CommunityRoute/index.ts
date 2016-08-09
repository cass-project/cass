import {Component} from "@angular/core";

import {RouteParams, RouteConfig} from "@angular/router-deprecated";
import {Router, ROUTER_DIRECTIVES} from '@angular/router-deprecated';
import {ProgressLock} from "../../../form/component/ProgressLock/index";
import {CommunityCollectionsRoute} from "../CommunityCollectionsRoute/index";
import {CommunityRouteService} from "./service";
import {CommunityDashboardRoute} from "../CommunityDashboardRoute/index";
import {CommunityHeader} from "../../component/Elements/CommunityHeader/index";
import {AuthService} from "../../../auth/service/AuthService";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        ProgressLock,
        CommunityHeader,
    ],
    providers: [
        CommunityRouteService,
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
        private service: CommunityRouteService,
        private authService: AuthService
    ) {
        let sid = params.get('sid');
        
        if (sid){
            service.loadCommunityBySID(sid);
        } else {
            router.navigate(['/Community/NotFound']);
            return;
        }

        if (service.getObservable() !== undefined) {
            service.getObservable().subscribe(
                (response) => {
                },
                (error) => {
                    router.navigate(['/Community/NotFound']);
                }
            )
        } else {
            router.navigate(['/Community/NotFound']);
        }
    }
}