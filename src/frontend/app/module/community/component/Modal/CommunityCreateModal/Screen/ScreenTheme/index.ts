import {Component} from "angular2/core";

import {Screen} from "../../screen";
import {ThemeSelect} from "../../../../../../theme/component/ThemeSelect/index";
import {CommunityCreateModalModel} from "../../model";

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
    constructor(protected model: CommunityCreateModalModel) {
        super(model);
    }

    updateThemeIds(themeIds: number[]) {
        this.model.theme_ids = themeIds;
    }

    unsetTheme(){
        this.model.theme_ids = null;
    }
}