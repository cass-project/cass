import {Component, Input, Output} from "@angular/core";

import {Theme} from "../../../definitions/entity/Theme";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {ThemeCardFeed} from "../ThemeCardFeed/index";
import {ThemeCardGrid} from "../ThemeCardGrid/index";
import {ThemeCardTable} from "../ThemeCardTable/index";
import {ThemeCardlistItem} from "../ThemeCardListItem/index";
import {EventEmitter} from "@angular/common/src/facade/async";

@Component({
    selector: 'cass-theme-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ThemeCard
{
    @Input('theme') theme: Theme;
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('click') clickEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    click() {
        this.clickEvent.emit(this.theme);
    }

    isViewMode(viewMode: ViewOptionValue) {
        return this.viewMode === viewMode;
    }
}

export const THEME_CARD_DIRECTIVES = [
    ThemeCard,
    ThemeCardFeed,
    ThemeCardGrid,
    ThemeCardTable,
    ThemeCardlistItem,
];