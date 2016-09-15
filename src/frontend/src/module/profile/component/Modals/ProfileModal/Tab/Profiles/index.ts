import {Component} from "@angular/core";
import {ProfilesTabService} from "./service";
import {ThemeService} from "../../../../../../theme/service/ThemeService";
import {ProfileModalModel} from "../../model";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ProfilesTabService
    ],selector: 'cass-profile-modal-tab-profiles'})

export class ProfilesTab
{
    constructor(private service: ProfilesTabService, private themeService: ThemeService, private model: ProfileModalModel) {}
}