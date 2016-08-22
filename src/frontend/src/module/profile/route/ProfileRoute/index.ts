import {Component} from "@angular/core";

import {Router, ROUTER_DIRECTIVES} from '@angular/router-deprecated';
import {RouteConfig, RouteParams} from "@angular/router-deprecated";

import {ProgressLock} from "../../../form/component/ProgressLock/index";
import {ProfileCollectionsRoute} from "../ProfileCollectionsRoute/index";
import {ProfileRouteService} from "./service";
import {ProfileDashboardRoute} from "../ProfileDashboardRoute/index";
import {ProfileHeader} from "../../component/Elements/ProfileHeader/index";
import {AuthService} from "../../../auth/service/AuthService";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {Session} from "../../../session/Session";

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
        FeedCriteriaService,
        FeedOptionsService,
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
        private session: Session,
        private authService: AuthService
    ) {
        let id = params.get('id');

        if (authService.isSignedIn() && (id === 'current' || id === this.session.getCurrentProfile().getId().toString())) {
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