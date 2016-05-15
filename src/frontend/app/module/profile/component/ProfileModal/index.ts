import {Component} from "angular2/core";

import {ProfileModalModel} from "./model";
import {AccountTab} from "./Tab/Account/index";
import {PersonalTab} from "./Tab/Personal/index";
import {InterestsTab} from "./Tab/Interests/index";
import {ProfilesTab} from "./Tab/Profiles/index";

@Component({
    selector: 'cass-profile-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        AccountTab,
        PersonalTab,
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
}

class TabControls
{
    current: ProfileModalTab = ProfileModalTab.Account;

    go(tab: ProfileModalTab) {
        this.current = tab;
    }

    isCurrent(tab: ProfileModalTab) {
        return this.current === tab;
    }
}

enum ProfileModalTab
{
    Account = <any>"Account",
    Personal = <any>"Personal",
    Interests = <any>"Interests",
    Profiles = <any>"Profile",
    SignOut = <any>"SignOut"
}