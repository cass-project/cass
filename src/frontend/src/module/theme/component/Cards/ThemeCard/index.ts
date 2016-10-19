import {Component, Input, Output} from "@angular/core";

import {Theme} from "../../../definitions/entity/Theme";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {EventEmitter} from "@angular/common/src/facade/async";
import {ThemeCardFeed} from "./view-modes/ThemeCardFeed/index";
import {ThemeCardGrid} from "./view-modes/ThemeCardGrid/index";
import {ThemeCardList} from "./view-modes/ThemeCardList/index";

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
    @Output('go') goEvent: EventEmitter<Theme> = new EventEmitter<Theme>();

    go(theme: Theme) {
        this.goEvent.emit(theme);
    }

    isViewMode(viewMode: ViewOptionValue) {
        return this.viewMode === viewMode;
    }
}

export const THEME_CARD_DIRECTIVES = [
    ThemeCard,
    ThemeCardFeed,
    ThemeCardGrid,
    ThemeCardList,
];