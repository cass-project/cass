import {Component} from "angular2/core";

import {Screen} from "../../screen";
import {ThemeSelect} from "../../../../../../theme/component/ThemeSelect/index";

@Component({
    selector: 'cass-community-create-modal-screen-theme',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ThemeSelect
    ]
})
export class ScreenTheme extends Screen
{
    private themeIds: number[] = [];

    updateThemeIds(themeIds: number[]) {
        console.log('CHANGE: ', themeIds, 'actual: ', this.themeIds);
    }
}