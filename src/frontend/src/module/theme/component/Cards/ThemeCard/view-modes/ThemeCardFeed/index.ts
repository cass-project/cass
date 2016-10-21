import {Component, Input, Output, EventEmitter} from "@angular/core";

import {THEME_PREVIEW_PUBLIC_PREFIX, Theme} from "../../../../../definitions/entity/Theme";

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

    go() {
        this.goEvent.emit(this.theme);
    }
}