import {Component, Output, EventEmitter} from "@angular/core";

import {ProfileSetupModel} from "../../model";
import {ProgressLock} from "../../../../../../form/component/ProgressLock/index";
import {ProfileRESTService} from "../../../../../service/ProfileRESTService";
import {EditPersonalResponse200} from "../../../../../definitions/paths/edit-personal";
import {AuthService} from "../../../../../../auth/service/AuthService";
import {CurrentProfileService} from "../../../../../service/CurrentProfileService";

@Component({
    selector: 'cass-profile-setup-screen-greetings',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProgressLock
    ]
})

export class ProfileSetupScreenGreetings
{
    private saving: boolean = false;

    @Output('back') backEvent = new EventEmitter<ProfileSetupModel>();
    @Output('next') nextEvent = new EventEmitter<ProfileSetupModel>();

    constructor(
        private model: ProfileSetupModel,
        private profileRESTService: ProfileRESTService,
        private currentProfileService: CurrentProfileService
    ) {}

    back() {
        this.backEvent.emit(this.model);
    }

    submit() {
        let profileId = this.model.getProfile().id;

        this.saving = true;
        this.profileRESTService.editPersonal(profileId, {
            avatar: true,
            method: this.model.greetings.method,
            first_name: this.model.greetings.firstName,
            last_name: this.model.greetings.lastName,
            middle_name: this.model.greetings.middleName,
            nick_name: this.model.greetings.nickName,
        }).subscribe(
            (response: EditPersonalResponse200) => {
                this.currentProfileService.get().replaceAvatar(response.entity.image);
                this.currentProfileService.get().changeGreetings(response.entity.greetings);
                this.nextEvent.emit(this.model);
            },
            (error) => {
                this.saving = false;
            }
        );
    }
}