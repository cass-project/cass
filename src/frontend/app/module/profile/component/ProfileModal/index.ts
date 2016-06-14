import {Component} from "angular2/core";

import {ProfileModalModel} from "./model";
import {AccountTab} from "./Tab/Account/index";
import {PersonalTab} from "./Tab/Personal/index";
import {InterestsTab} from "./Tab/Interests/index";
import {ProfilesTab} from "./Tab/Profiles/index";
import {ImageTab} from "./Tab/Image/index";
import {ProfileComponentService} from "../../service";
import {ProfileRESTService} from "../../service/ProfileRESTService";
import {ProfileService} from "../../service/ProfileService";
import {ThemeSelect} from "../../../theme/component/ThemeSelect/index";
import {ThemeService} from "../../../theme/service/ThemeService";


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
    selector: 'cass-profile-settings',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        AccountTab,
        PersonalTab,
        ImageTab,
        InterestsTab,
        ProfilesTab,

    ],
    providers: [
        ProfileModalModel,
        ProfileRESTService,
        ProfileService,
        ThemeService
    ]
})

export class ProfileModal
{
    tabs: TabControls = new TabControls();

    constructor(public model: ProfileModalModel, private modals: ProfileComponentService){}


    close() {
        this.modals.modals.settings.close();
    }
}


class TabControls
{
    static DEFAULT_TAB = ProfileModalTab.Personal;

    current: ProfileModalTab = TabControls.DEFAULT_TAB;

    go(tab: ProfileModalTab) {
        this.current = tab;
    }

    isCurrent(tab: ProfileModalTab) {
        return this.current === tab;
    }
}