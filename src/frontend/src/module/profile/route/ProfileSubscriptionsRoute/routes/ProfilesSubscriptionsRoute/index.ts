import {Component,Input} from "@angular/core";
import {SubscribeRESTService} from "../../../../../subscribe/service/SubscribeRESTService";
import {ProfileRouteService} from "../../../ProfileRoute/service";
import {ProfileEntity} from "../../../../definitions/entity/Profile";
import {ListSubscribeProfileRequest} from "../../../../../subscribe/definitions/paths/list-profiles";
import {SubscriptionEntity} from "../../../../../subscribe/definitions/entity/Subscription";
import {LoadingManager} from "../../../../../common/classes/LoadingStatus";
import {ViewOptionValue} from "../../../../../feed/service/FeedService/options/ViewOption";
import {ViewOptionService} from "../../../../../public/component/Options/ViewOption/service";
import {Router} from "@angular/router";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfilesSubscriptionsRoute
{
    private status: LoadingManager = new LoadingManager();

    private profile: ProfileEntity;
    private subscribes: SubscriptionEntity<ProfileEntity>[];
    private request: ListSubscribeProfileRequest = {
        limit: 50,
        offset: 0
    };

    constructor(
        private subscribe: SubscribeRESTService,
        private service: ProfileRouteService,
        private viewOptions: ViewOptionService,
        private router: Router,
    ){}

    ngOnInit() {
        this.profile = this.service.getProfile();

        let loading = this.status.addLoading();

        this.subscribe.listProfiles(this.profile.id, this.request).subscribe(
            response => {
                this.subscribes = response.subscribes;

                loading.is = false;
            },

            error => {
                loading.is = false;
            }
        )
    }

    getProfiles() {
        return this.subscribes.map(subscription => subscription.entity);
    }

    openCommunity(profile: ProfileEntity) {
        this.router.navigate(['/profile/', profile.id]);
    }

    getViewMode(): ViewOptionValue {
        return this.viewOptions.option.current;
    }
}
