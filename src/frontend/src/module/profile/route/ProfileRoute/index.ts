import {Component} from "angular2/core";

import {RouteParams, Router, ROUTER_DIRECTIVES, RouteConfig} from "angular2/router";
import {ProgressLock} from "../../../form/component/ProgressLock/index";
import {ProfileCollectionsRoute} from "../ProfileCollectionsRoute/index";
import {ProfileRouteService} from "./service";
import {ProfileDashboardRoute} from "../ProfileDashboardRoute/index";
import {ProfileHeader} from "../../component/Elements/ProfileHeader/index";

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
        ProfileRouteService,
    ]
})
@RouteConfig([
    {
        path: '/',
        name: 'Dashboard',
        component: ProfileDashboardRoute,
        useAsDefault: true
    },
    {
        path: '/collections/...',
        name: 'Collections',
        component: ProfileCollectionsRoute
    },
])
export class ProfileRoute
{
    constructor(
        private params: RouteParams,
        private router: Router,
        private service: ProfileRouteService
    ) {
        let id = params.get('id');

        if(id === 'current') {
            service.loadCurrentProfile();
        }else if(id.match(/^(\d+)$/)) {
            service.loadProfileById(parseInt(id, 10));
        }else {
            router.navigate(['/Profile/NotFound']);
            return;
        }

        service.getObservable().subscribe(
            (response) => {},
            (error) => {
                router.navigate(['/Profile/NotFound']);
            }
        )
    }
    
    goDashboard() {
        console.log('go dashboard');
    }
    
    goCollection(sid: string) {
        console.log('go collection', sid);
    }
}