import {Component, Input, Output} from "@angular/core";

import {Theme, THEME_PREVIEW_PUBLIC_PREFIX} from "../../../definitions/entity/Theme";
import {EventEmitter} from "@angular/common/src/facade/async";

@Component({
    selector: 'cass-theme-card-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
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