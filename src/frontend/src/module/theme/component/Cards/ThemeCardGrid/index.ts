import {Component, Input, Output, EventEmitter} from "@angular/core";

import {Theme} from "../../../definitions/entity/Theme";

@Component({
    selector: 'cass-theme-card-grid',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ThemeCardGrid
{
    @Input('theme') theme: Theme;
    @Output('click') clickEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    click() {
        this.clickEvent.emit(this.theme);
    }
}