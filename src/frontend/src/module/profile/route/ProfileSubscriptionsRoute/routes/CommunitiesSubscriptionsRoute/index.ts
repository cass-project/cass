import {Component} from "@angular/core";
import {LoadingManager} from "../../../../../common/classes/LoadingStatus";
import {CommunityEntity} from "../../../../../community/definitions/entity/Community";
import {SubscriptionEntity} from "../../../../../subscribe/definitions/entity/Subscription";
import {ListSubscribeCommunitiesRequest} from "../../../../../subscribe/definitions/paths/list-communities";
import {SubscribeRESTService} from "../../../../../subscribe/service/SubscribeRESTService";
import {ProfileEntity} from "../../../../definitions/entity/Profile";
import {ProfileRouteService} from "../../../ProfileRoute/service";
import {ViewOptionValue} from "../../../../../feed/service/FeedService/options/ViewOption";
import {ViewOptionService} from "../../../../../public/component/Options/ViewOption/service";
import {Router} from "@angular/router";



@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunitiesSubscriptionsRoute
{

    private status: LoadingManager = new LoadingManager();

    private profile: ProfileEntity;
    private subscribes: SubscriptionEntity<CommunityEntity>[];
    private request: ListSubscribeCommunitiesRequest = {
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

        this.subscribe.listCommunities(this.profile.id, this.request).subscribe(
            response => {
                this.subscribes = response.subscribes;

                loading.is = false;
            },

            error => {
                loading.is = false;
            }
        )
    }

    getCommunities() {
        return this.subscribes.map(subscription => subscription.entity);
    }

    openCommunity(community: CommunityEntity) {
        this.router.navigate(['/community/',  community.id]);
    }

    getViewMode(): ViewOptionValue {
        return this.viewOptions.option.current;
    }
}