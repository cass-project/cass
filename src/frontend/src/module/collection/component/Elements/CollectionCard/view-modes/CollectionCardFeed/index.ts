import {Component, Input, Output, EventEmitter} from "@angular/core";

import {CollectionEntity} from "../../../../../definitions/entity/collection";
import {CollectionCardHelper} from "../../helper";
import {SubscribeRESTService} from "../../../../../../subscribe/service/SubscribeRESTService";
import {LoadingManager} from "../../../../../../common/classes/LoadingStatus";
import {ProfileEntity} from "../../../../../../profile/definitions/entity/Profile";


@Component({
    selector: 'cass-collection-card-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
        require('./style.navigation.shadow.scss'),
    ]
})
export class CollectionCardFeed
{
    @Input('entity') entity: CollectionEntity;
    @Output('open') openEvent: EventEmitter<CollectionEntity> = new EventEmitter<CollectionEntity>();
    @Input('profile') profile: ProfileEntity;

    private isSubscribed: boolean = false;
    private subscribeLoading: LoadingManager = new LoadingManager();


    constructor(
        private helper: CollectionCardHelper,
        private subscribeService: SubscribeRESTService
    ) {}

    open($event) {
        $event.preventDefault();

        this.openEvent.emit(this.entity);
    }

    subscribe() {
        let loading = this.subscribeLoading.addLoading();

        this.subscribeService.subscribeCollection(this.entity.id).subscribe(response => {
            this.isSubscribed = true;
            loading.is = false;
        });
    }

    unsubscribe() {
        let loading = this.subscribeLoading.addLoading();

        this.subscribeService.unsubscribeCollection(this.entity.id).subscribe(response => {
            this.isSubscribed = false;
            loading.is = false;
        });
    }
}