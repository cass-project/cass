import {Component, Input, OnChanges, EventEmitter, Output} from "@angular/core";

import {CommunityEntity} from "../../../definitions/entity/Community";
import {CommunityCardHelper} from "./helper";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {CommunityCardFeed} from "./view-modes/CommunityCardFeed/index";
import {CommunityCardList} from "./view-modes/CommunityCardList/index";
import {CommunityCardGrid} from "./view-modes/CommunityCardGrid/index";

@Component({
    selector: 'cass-community-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers:[
        CommunityCardHelper
    ]
})
export class CommunityCard implements OnChanges
{
    @Input('community') community: CommunityEntity;
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openEvent: EventEmitter<CommunityEntity> = new EventEmitter<CommunityEntity>();
    
    constructor(
        private helper: CommunityCardHelper
    ) {}

    isViewMode(viewMode: ViewOptionValue): boolean {
        return this.viewMode === viewMode;
    }
    
    ngOnChanges() {
        this.helper.setCommunity(this.community);
    }

    open($event) {
        this.openEvent.emit($event);
    }
}

export const COMMUNITY_CARD_DIRECTIVES = [
    CommunityCard,
    CommunityCardFeed,
    CommunityCardList,
    CommunityCardGrid,
];