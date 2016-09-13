import {Component, Output, EventEmitter, Directive} from "@angular/core";
import {Router} from '@angular/router';


import {ProfileModalModel} from "./model";
import {ProfileRESTService} from "../../../service/ProfileRESTService";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {AuthService} from "../../../../auth/service/AuthService";
import {AccountRESTService} from "../../../../account/service/AccountRESTService";

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
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        AccountRESTService,
        ProfileModalModel,
        ProfileRESTService,
        ThemeService
    ],selector: 'cass-profile-settings'})


export class ProfileModal
{
    tabs: TabControls = new TabControls();

    @Output("close") closeEvent = new EventEmitter<Boolean>();

    constructor(
        public model: ProfileModalModel,
        private authService: AuthService,
        private router: Router
    ) {}

    closeProfileModal() {
        this.closeEvent.emit(true);
    }

    signOut() {
        this.authService.signOut().subscribe(() => {
            this.closeProfileModal();
            this.router.navigate(['Public']);
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