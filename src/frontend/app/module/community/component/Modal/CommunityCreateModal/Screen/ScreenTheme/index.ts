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

    updateThemeId(themeIds: number[]) {
        this.model.theme_id = themeIds[0];
    }

    unsetTheme(){
        this.model.theme_id = null;
    }
}