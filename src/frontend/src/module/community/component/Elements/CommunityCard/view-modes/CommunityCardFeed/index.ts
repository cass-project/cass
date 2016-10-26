import {Component, Input, Output, EventEmitter} from "@angular/core";

import {CommunityCardHelper} from "../../helper";
import {CommunityEntity} from "../../../../../definitions/entity/Community";
import {SubscribeRESTService} from "../../../../../../subscribe/service/SubscribeRESTService";
import {LoadingManager} from "../../../../../../common/classes/LoadingStatus";

@Component({
    selector: 'cass-community-card-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
        require('./style.navigation.shadow.scss'),
    ]
})
export class CommunityCardFeed
{
    @Input('community') community: CommunityEntity;
    @Output('open') openEvent: EventEmitter<CommunityEntity> = new EventEmitter<CommunityEntity>();

    private isSubscribed: boolean = false;
    private subscribeLoading: LoadingManager = new LoadingManager();
    
    constructor(
        private helper: CommunityCardHelper,
        private subscribeService: SubscribeRESTService
    ) {}

    open($event) {
        this.openEvent.emit(this.community);
    }

    subscribe() {
        let loading = this.subscribeLoading.addLoading();

        this.subscribeService.subscribeCommunity(this.community.id).subscribe(response => {
            this.isSubscribed = true;
            loading.is = false;
        });
    }

    unsubscribe() {
        let loading = this.subscribeLoading.addLoading();

        this.subscribeService.unsubscribeCommunity(this.community.id).subscribe(response => {
            this.isSubscribed = false;
            loading.is = false;
        });
    }
}

