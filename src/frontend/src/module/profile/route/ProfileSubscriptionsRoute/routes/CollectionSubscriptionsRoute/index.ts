import {Component} from "@angular/core";

import {LoadingManager} from "../../../../../common/classes/LoadingStatus";
import {SubscriptionEntity} from "../../../../../subscribe/definitions/entity/Subscription";
import {ListSubscribeCollectionsRequest} from "../../../../../subscribe/definitions/paths/list-collections";
import {SubscribeRESTService} from "../../../../../subscribe/service/SubscribeRESTService";
import {ProfileRouteService} from "../../../ProfileRoute/service";
import {ProfileEntity} from "../../../../definitions/entity/Profile";
import {CollectionEntity} from "../../../../../collection/definitions/entity/collection";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CollectionSubscriptionsRoute
{
    private status: LoadingManager = new LoadingManager();
    private profile: ProfileEntity;
    private subscribes: SubscriptionEntity<CollectionEntity>[];
    private request: ListSubscribeCollectionsRequest = {
        limit: 50,
        offset: 0
    };

    constructor(
        private subscribe: SubscribeRESTService,
        private service: ProfileRouteService
    ) {}

    ngOnInit() {
        this.profile = this.service.getProfile();

        let loading = this.status.addLoading();

        this.subscribe.listCollections(this.profile.id, this.request).subscribe(
            response => {
                this.subscribes = response.subscribes;

                loading.is = false;
            },

            error => {
                loading.is = false;
            }
        )
    }

    hasSubscribes(): boolean {
        return this.subscribes.length > 0;
    }

    getCollection(): CollectionEntity[] {
        return this.subscribes.map(subscription => subscription.entity);
    }
}