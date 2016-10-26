import {Component, Input, Output, EventEmitter} from "@angular/core";

import {ProfileEntity} from "../../../../../definitions/entity/Profile";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {ProfileCardHelper} from "../../helper";
import {ProfileThemeListMode} from "../../index";
import {SubscribeRESTService} from "../../../../../../subscribe/service/SubscribeRESTService";
import {LoadingManager} from "../../../../../../common/classes/LoadingStatus";

@Component({
    selector: 'cass-profile-card-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
        require('./style.navigation.shadow.scss'),
    ]
})
export class ProfileCardFeed
{
    @Input('profile') profile: ProfileEntity;
    @Input('theme-list-mode') themeListMode: ProfileThemeListMode = ProfileThemeListMode.InterestingIn;
    @Output('open') openProfile: EventEmitter<ProfileEntity> = new EventEmitter<ProfileEntity>();

    private isSubscribed: boolean = false;
    private subscribeLoading: LoadingManager = new LoadingManager();
    private viewMode: ViewOptionValue = ViewOptionValue.Feed;

    constructor(
        private helper: ProfileCardHelper,
        private subscribeService: SubscribeRESTService
    ) {}

    open() {
        this.openProfile.emit(this.profile);
    }

    isFemale(): boolean {
        return this.profile.gender.string === 'female';
    }

    isMale(): boolean {
        return this.profile.gender.string === 'male';
    }

    notSpecifiedGender(): boolean {
        return this.profile.gender.string === 'not-specified';
    }

    subscribe() {
        let loading = this.subscribeLoading.addLoading();
        
        this.subscribeService.subscribeProfile(this.profile.id).subscribe(response => {
            this.isSubscribed = true;
            loading.is = false;
        });
    }

    unsubscribe() {
        let loading = this.subscribeLoading.addLoading();
        
        this.subscribeService.unsubscribeProfile(this.profile.id).subscribe(response => {
            this.isSubscribed = false;
            loading.is = false;
        });
    }
}