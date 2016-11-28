import {Component, Input, Output, EventEmitter} from "@angular/core";

import {THEME_PREVIEW_PUBLIC_PREFIX, Theme} from "../../../../../definitions/entity/Theme";
import {LoadingManager} from "../../../../../../common/classes/LoadingStatus";
import {SubscribeRESTService} from "../../../../../../subscribe/service/SubscribeRESTService";

@Component({
    selector: 'cass-theme-card-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
        require('./style.navigation.shadow.scss'),
    ]
})
export class ThemeCardFeed
{
    private prefix: string = THEME_PREVIEW_PUBLIC_PREFIX;

    @Input('theme') theme: Theme;
    @Output('go') goEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    private subscribeLoading: LoadingManager = new LoadingManager();

    constructor(
        private subscribeService: SubscribeRESTService
    ) {}

    go() {
        this.goEvent.emit(this.theme);
    }

    subscribe() {
        let loading = this.subscribeLoading.addLoading();

        this.subscribeService.subscribeTheme(this.theme.id).subscribe(response => {
            this.theme.subscribed = true;
            loading.is = false;
        });
    }

    unsubscribe() {
        let loading = this.subscribeLoading.addLoading();

        this.subscribeService.unsubscribeTheme(this.theme.id).subscribe(response => {
            this.theme.subscribed = false;
            loading.is = false;
        });
    }
}