import {Component} from "angular2/core";

import {RouteParams, Router, ROUTER_DIRECTIVES, RouteConfig} from "angular2/router";
import {ProgressLock} from "../../../form/component/ProgressLock/index";
import {ProfileCollectionsRoute} from "../ProfileCollectionsRoute/index";
import {ProfileRouteService} from "./service";
import {ProfileDashboardRoute} from "../ProfileDashboardRoute/index";
import {ProfileHeader} from "../../component/Elements/ProfileHeader/index";
import {CurrentProfileService} from "../../service/CurrentProfileService";
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
        private service: ProfileRouteService,
        private currentProfileService: CurrentProfileService,
        private authService: AuthService
    ) {
        let id = params.get('id');

        if (authService.isSignedIn() && (id === 'current' || id === this.currentProfileService.get().getId().toString())) {
                service.loadCurrentProfile();
        } else if (Number(id)) {
            service.loadProfileById(Number(id));
        } else {
            router.navigate(['/Profile/NotFound']);
            return;
        }

        if (service.getObservable() !== undefined) {
            service.getObservable().subscribe(
                (response) => {
                },
                (error) => {
                    router.navigate(['/Profile/NotFound']);
                }
            )
        } else {
            router.navigate(['/Public']);
        }
    }
}