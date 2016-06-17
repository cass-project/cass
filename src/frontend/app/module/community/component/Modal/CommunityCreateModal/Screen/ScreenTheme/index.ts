import {Component} from "angular2/core";

import {Screen} from "../../screen";
import {ThemeSelect} from "../../../../../../theme/component/ThemeSelect/index";
import {CommunityCreateModalModel} from "../../model";
import {CommunityCreateModalForm} from "../../Form/index";

@Component({
    selector: 'cass-community-create-modal-screen-theme',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ThemeSelect,
        CommunityCreateModalForm
    ]
})
export class ScreenTheme extends Screen
{
    constructor(public model: CommunityCreateModalModel) {
        super();
    }

    updateThemeId(themeIds: number[]) {
        this.model.theme_id = themeIds[0];
    }
}