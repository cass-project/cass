import {Component, Input, Output, EventEmitter} from "@angular/core";

import {Theme, THEME_PREVIEW_PUBLIC_PREFIX} from "../../../definitions/entity/Theme";

@Component({
    selector: 'cass-theme-card-grid',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ThemeCardGrid
{
    private prefix: string = THEME_PREVIEW_PUBLIC_PREFIX;

    @Input('theme') theme: Theme;
    @Output('go') goEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    go() {
        this.goEvent.emit(this.theme);
    }
}