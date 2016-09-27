import {Component, Input, Output} from "@angular/core";

import {Theme} from "../../../definitions/entity/Theme";
import {EventEmitter} from "@angular/common/src/facade/async";

@Component({
    selector: 'cass-theme-card-table',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ThemeCardTable
{
    @Input('theme') theme: Theme;
    @Output('click') clickEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    click() {
        this.clickEvent.emit(this.theme);
    }
}