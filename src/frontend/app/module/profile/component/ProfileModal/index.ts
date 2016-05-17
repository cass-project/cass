import {Component} from "angular2/core";

import {ProfileModalModel} from "./model";
import {AccountTab} from "./Tab/Account/index";
import {PersonalTab} from "./Tab/Personal/index";
import {InterestsTab} from "./Tab/Interests/index";
import {ProfilesTab} from "./Tab/Profiles/index";
import {ImageTab} from "./Tab/Image/index";

enum ProfileModalTab
{
    Account = <any>"Account",
    Personal = <any>"Personal",
    Image = <any>"Image",
    Interests = <any>"Interests",
    Profiles = <any>"Profiles",
    SignOut = <any>"SignOut"
}

@Component({
    selector: 'cass-profile-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        AccountTab,
        PersonalTab,
        ImageTab,
        InterestsTab,
        ProfilesTab
    ],
    providers: [
        ProfileModalModel,  // В эту модель сохраняются изменения, сделанные пользователем.
                            // Этот коммент удалить.
    ]
})
export class ProfileModal
{
    tabs: TabControls = new TabControls();

    constructor(public model: ProfileModalModel) {}
}

class TabControls
{
    static DEFAULT_TAB = ProfileModalTab.Profiles;

    current: ProfileModalTab = TabControls.DEFAULT_TAB;

    go(tab: ProfileModalTab) {
        this.current = tab;
    }

    isCurrent(tab: ProfileModalTab) {
        return this.current === tab;
    }
}