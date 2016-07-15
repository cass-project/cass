import {Component} from "angular2/core";

import {RouteParams, Router, ROUTER_DIRECTIVES, RouteConfig} from "angular2/router";
import {ProgressLock} from "../../../form/component/ProgressLock/index";
import {CommunityCollectionsRoute} from "../CommunityCollectionsRoute/index";
import {CommunityRouteService} from "./service";
import {CommunityDashboardRoute} from "../CommunityDashboardRoute/index";
import {ProfileHeader} from "../../component/Elements/CommunityHeader/index";
import {AuthService} from "../../../auth/service/AuthService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        ProgressLock,
        ProfileHeader,
    ],
    providers: [
        CommunityRouteService,
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
        let id = params.get('id');
        
        if (id.match(/^(\d+)$/)) {
            service.loadCommunityBySID(id);
        } else {
            router.navigate(['/Profile/NotFound']);
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