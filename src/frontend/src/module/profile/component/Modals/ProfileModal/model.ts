import {Injectable} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable";

import {ProfileRESTService} from "../../../service/ProfileRESTService";
import {AccountRESTService} from "../../../../account/service/AccountRESTService";
import {Session} from "../../../../session/Session";
import {MessageBusService} from "../../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../../message/component/MessageBusNotifications/model";
import {ProfileEntity} from "../../../definitions/entity/Profile";
import {AccountEntity} from "../../../../account/definitions/entity/Account";

@Injectable()
export class ProfileModalModel
{
    public profile: ProfileEntity;
    public account: AccountEntity;

    constructor(
        private profileRESTService: ProfileRESTService,
        private accountRESTService: AccountRESTService,
        private session: Session,
        private messages: MessageBusService,
        private router: Router
    ) {
        this.reset();
    }

    loading: boolean = false;

    password = {
        old: '',
        new: '',
        repeat: ''
    };

    getAccountOriginal(){
        return this.session.getCurrentAccount().entity;
    }

    getProfileOriginal(){
        return this.session.getCurrentProfile().entity.profile;
    }

    reset() {
        this.account = JSON.parse(JSON.stringify(this.session.getCurrentAccount().entity));
        this.profile = JSON.parse(JSON.stringify(this.session.getCurrentProfile().entity.profile));
        this.password = {
            old: '',
            new: '',
            repeat: ''
        };
    }

    canSave(){
        return (
            this.checkAccountChanges() ||
            this.checkExpertListChanges() ||
            this.checkInterestListChanges() ||
            this.checkPersonalChanges()
        );
    }

    performSaveChanges(){
        this.loading = true;

        let observableRequest = [];

        if(this.checkAccountChanges()){
            observableRequest.push(this.accountRESTService.changePassword(this.password.old, this.password.new));

            this.accountRESTService.changePassword(this.password.old, this.password.new).subscribe(data => {
                this.password = {
                    old: '',
                    new: '',
                    repeat: ''
                }}, error => {});
        }

        if(this.checkExpertListChanges()){
            let expertRequest = {
                theme_ids: this.profile.expert_in_ids
            };

            observableRequest.push(this.profileRESTService.setExpertIn(this.getProfileOriginal().id, expertRequest));

            this.profileRESTService.setExpertIn(this.getProfileOriginal().id, expertRequest).subscribe(data => {
                this.getProfileOriginal().expert_in_ids = JSON.parse(JSON.stringify(this.profile.expert_in_ids));
            }, error => {});
        }

        if(this.checkInterestListChanges()){
            let interestingRequest = {
                theme_ids: this.profile.interesting_in_ids
            };

            observableRequest.push(this.profileRESTService.setInterestingIn(this.getProfileOriginal().id, interestingRequest));

            this.profileRESTService.setInterestingIn(this.getProfileOriginal().id, interestingRequest).subscribe(data => {
                this.getProfileOriginal().interesting_in_ids = JSON.parse(JSON.stringify(this.profile.interesting_in_ids));
            }, error => {});
        }

        if(this.checkPersonalChanges()){
            let personalRequest = {
                gender: this.profile.gender.string,
                avatar: false,
                method: this.profile.greetings.method,
                last_name: this.profile.greetings.last_name,
                first_name: this.profile.greetings.first_name,
                middle_name: this.profile.greetings.middle_name,
                nick_name: this.profile.greetings.nick_name
            };

            observableRequest.push(this.profileRESTService.editPersonal(this.getProfileOriginal().id, personalRequest));

            if(this.profile.greetings.method !== this.getProfileOriginal().greetings.method && this.getProfileOriginal().image.is_auto_generated){
                personalRequest.avatar = true;
            }

            this.profileRESTService.editPersonal(this.getProfileOriginal().id, personalRequest).subscribe(data => {
                this.getProfileOriginal().greetings = JSON.parse(JSON.stringify(data.entity.greetings));
                this.getProfileOriginal().gender.string = data.entity.gender.string;
                this.profile.greetings = JSON.parse(JSON.stringify(data.entity.greetings));
                if(personalRequest.avatar){
                    this.getProfileOriginal().image = JSON.parse(JSON.stringify(data.entity.image));
                }
            }, error => {});

        }

        Observable.forkJoin(observableRequest).subscribe(
            success => {
                this.loading = false;
                this.messages.push(MessageBusNotificationsLevel.Info, 'Ваши данные сохранены');

            },
            error => {
                this.messages.push(MessageBusNotificationsLevel.Warning, 'Ваши данные не были сохранены')
            }
        )
    }

    checkAccountChanges(): boolean {
        return (this.password.old.length > 5 && this.password.new.length > 5 && this.password.repeat.length > 5 && this.password.new === this.password.repeat);
    }

    checkExpertListChanges(): boolean {
        return (this.profile.expert_in_ids.sort().toString() !== this.getProfileOriginal().expert_in_ids.sort().toString());
    }

    checkInterestListChanges(): boolean {
        return (this.profile.interesting_in_ids.sort().toString() !== this.getProfileOriginal().interesting_in_ids.sort().toString());
    }

    checkPersonalChanges(): boolean {
        if(this.profile.gender.string  !== this.getProfileOriginal().gender.string){
            return true;
        }

        for(let prop in this.getProfileOriginal().greetings){
            if(this.getProfileOriginal().greetings[prop] !== this.profile.greetings[prop]){
                return true;
            }
        }
        return false;
    }
}

interface ChangeDetectorHandler {

}