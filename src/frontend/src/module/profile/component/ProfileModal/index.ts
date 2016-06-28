import {Component, Output, EventEmitter} from "angular2/core";

import {ProfileModalModel} from "./model";
import {AccountTab} from "./Tab/Account/index";
import {PersonalTab} from "./Tab/Personal/index";
import {InterestsTab} from "./Tab/Interests/index";
import {ProfilesTab} from "./Tab/Profiles/index";
import {ImageTab} from "./Tab/Image/index";
import {ProfileRESTService} from "../../service/ProfileRESTService";
import {ProfileService} from "../../service/ProfileService";
import {ThemeService} from "../../../theme/service/ThemeService";
import {AuthService} from "../../../auth/service/AuthService";

enum ProfileModalTab
{
    Account = <any>"Account",
    Personal = <any>"Personal",
    Image = <any>"Image",
    Interests = <any>"Interests",
    Profiles = <any>"AccountProfiles",
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

    @Output("close") closeEvent = new EventEmitter();

    constructor(
        public model: ProfileModalModel,
        private authService: AuthService
    ) {}

    close() {
        this.closeEvent.emit("closed");
    }

    signOut() {
        this.authService.signOut().subscribe(() => {
            this.close();
        });
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