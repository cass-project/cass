import {Component} from "angular2/core";

import {CommunityCreateModalModel} from "../../../CommunityCreateModal/model";
import {ThemeSelect} from "../../../../../../theme/component/ThemeSelect/index";
import {CommunityResponseModel, CommunityModel} from "../../../../../model";

@Component({
    selector: 'cass-community-settings-modal-tab-general',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives:[
        ThemeSelect
    ]
})

export class GeneralTab {

    constructor(protected model: CommunityModel, protected responseModel: CommunityResponseModel) {
        this.model = responseModel.entity;
    }

    updateThemeId(themeIds: number[]) {
        this.model.theme_id = themeIds[0];
    }

    unsetTheme(){
        this.model.theme_id = null;
    }

}