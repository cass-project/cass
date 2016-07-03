import {Component} from "angular2/core";

import {RouteParams, Router, ROUTER_DIRECTIVES} from "angular2/router";
import {ProfileExtendedEntity} from "../../definitions/entity/Profile";
import {Observable} from "rxjs/Observable";
import {ProfileCachedIdentityMap} from "../../service/ProfileCachedIdentityMap";
import {ProgressLock} from "../../../form/component/ProgressLock/index";
import {AuthService} from "../../../auth/service/AuthService";
import {ProfileHeader} from "../../component/Elements/ProfileHeader/index";

@Component({
    template: require('./template.jade'),
    directives: [
        ProgressLock,
        ProfileHeader,
        ROUTER_DIRECTIVES,
    ]
})
export class ProfileRoute
{
    private loading: boolean = true;
    private observable: Observable<ProfileExtendedEntity>;
    private profile: ProfileExtendedEntity;

    constructor(
        params: RouteParams,
        auth: AuthService,
        entities: ProfileCachedIdentityMap,
        router: Router
    ) {
        let id = params.get('id');

        if(id === 'current') {
            this.observable = new Observable(observer => {
                observer.next(auth.getCurrentAccount().getCurrentProfile());
                observer.complete();
            });
        }else if(id.match(/^(\d+)$/)) {
            this.observable = entities.getProfileById(parseInt(id, 10));
        }else {
            router.navigate(['/Profile/NotFound']);
            return;
        }

        this.observable.subscribe(
            (profile) => { 
                this.loading = false;
                this.profile = profile;
            },
            () => {
                router.navigate(['/Profile/NotFound'])
            }
         )
    }
}