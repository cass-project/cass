import {Component, Input, EventEmitter, Output} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable";

import {ProfileSetupModel} from "./model";
import {ScreenControls} from "../../../../common/classes/ScreenControls";
import {ProfileRESTService} from "../../../service/ProfileRESTService";
import {ProfileEntity} from "../../../definitions/entity/Profile";
import {MessageBusService} from "../../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../../message/component/MessageBusNotifications/model";

enum ProfileSetupScreen {
    Welcome = <any>"Welcome",
    Gender = <any>"Gender",
    Greetings = <any>"Greetings",
    Image = <any>"Image",
    Interests = <any>"Interests",
    ExpertIn = <any>"ExpertIn",
    Saving = <any>"Saving",
    Finish = <any>"Finish"
}

@Component({
    selector: 'cass-profile-setup',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ProfileSetupModel
    ],
})
export class ProfileSetup
{
    @Input('profile') profile: ProfileEntity;
    @Output('success') successEvent = new EventEmitter<ProfileEntity>();

    public screens: ScreenControls<ProfileSetupScreen> = new ScreenControls<ProfileSetupScreen>(ProfileSetupScreen.Welcome, (sc: ScreenControls<ProfileSetupScreen>) => {
        sc.add({ from: ProfileSetupScreen.Welcome, to: ProfileSetupScreen.Gender })
          .add({ from: ProfileSetupScreen.Gender, to: ProfileSetupScreen.Greetings })
          .add({ from: ProfileSetupScreen.Greetings, to: ProfileSetupScreen.Image })
          .add({ from: ProfileSetupScreen.Image, to: ProfileSetupScreen.Interests })
          .add({ from: ProfileSetupScreen.Interests, to: ProfileSetupScreen.ExpertIn })
          .add({ from: ProfileSetupScreen.ExpertIn, to: ProfileSetupScreen.Saving })
          .add({ from: ProfileSetupScreen.Saving, to: ProfileSetupScreen.Finish });
    });

    constructor(
        private model: ProfileSetupModel,
        private service: ProfileRESTService,
        private messages: MessageBusService,
        private router: Router
    ) {}

    ngAfterViewInit() {
        this.model.specifyProfile(this.profile);
    }
    
    nextScreen() {
        this.screens.next();

        if(this.screens.isOn(ProfileSetupScreen.Saving)) {
            this.performSaveChanges();
        }
    }

    prevScreen() {
        this.screens.previous();
    }

    performSaveChanges() {
        let profileId = this.model.getProfile().id;
        
        let requests = {
            gender: this.service.setGender(profileId, {
                gender: this.model.gender
            }),
            interestingIn: this.service.setInterestingIn(profileId, {
                theme_ids: this.model.expertIn
            }),
            expertIn: this.service.setExpertIn(profileId, {
                theme_ids: this.model.expertIn
            })
        };
        
        requests.gender.subscribe(
            response => {
                this.profile.gender = response.gender;
            },
            error => {}
        );

        requests.interestingIn.subscribe(
            response => {
                this.profile.interesting_in_ids = this.model.interestingIn;
            },
            error => {}
        );

        requests.expertIn.subscribe(
            response => {
                this.profile.expert_in_ids = this.model.expertIn;
            },
            error => {}
        );

        Observable.forkJoin([
            requests.gender,
            requests.interestingIn,
            requests.expertIn,
        ]).subscribe(
            success => {
                this.profile.is_initialized = true;
                this.messages.push(MessageBusNotificationsLevel.Info, 'Ваши данные сохранены');
                this.router.navigate(['/profile', 'current']);
            },
            error => {
                this.screens.goto(ProfileSetupScreen.ExpertIn);
                this.messages.push(MessageBusNotificationsLevel.Warning, 'Ваши данные не были сохранены')
            }
        )
    }
}