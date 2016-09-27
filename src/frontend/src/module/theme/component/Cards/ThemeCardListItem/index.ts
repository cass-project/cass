import {Component, Input, Output} from "@angular/core";

import {Theme} from "../../../definitions/entity/Theme";
import {EventEmitter} from "@angular/forms/src/facade/async";

@Component({
    selector: 'cass-theme-card-list-item',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ThemeCardlistItem
{
    @Input('theme') theme: Theme;
    @Output('click') clickEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    click() {
        this.clickEvent.emit(this.theme);
    }
}