import {Injectable} from "angular2/core";
import {AuthService} from "../../../../auth/service/AuthService";
import {ProfileRESTService} from "../../../service/ProfileRESTService";
import {AccountRESTService} from "../../../../account/service/AccountRESTService";
import {AuthToken} from "../../../../auth/service/AuthToken";
import {MessageBusService} from "../../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../../message/component/MessageBusNotifications/model";
import {Observable} from "rxjs/Observable";
import {CurrentProfileService} from "../../../service/CurrentProfileService";
import {CurrentAccountService} from "../../../../account/service/CurrentAccountService";

@Injectable()
export class ProfileModalModel
{
    constructor(private profileRESTService: ProfileRESTService,
                private accountRESTService: AccountRESTService,
                private currentProfileService: CurrentProfileService,
                private currentAccountService: CurrentAccountService,
                protected messages: MessageBusService,
                protected authToken: AuthToken){}
    
    profile = JSON.parse(JSON.stringify(this.currentProfileService.get().entity.profile));
    account = JSON.parse(JSON.stringify(this.currentAccountService.get().entity));
    
    loading: boolean = false;

    password = {
        old: '',
        new: '',
        repeat: ''
    };
    
    getAccountOriginal(){
        return this.currentAccountService.get().entity;
    }
    
    getProfileOriginal(){
        return this.currentProfileService.get().entity.profile;
    }

    reset(){
        this.profile = JSON.parse(JSON.stringify(this.currentProfileService.get().entity.profile));
        this.password = {
            old: '',
            new: '',
            repeat: ''
        };
    }

    canSave(){
       return (this.checkAccountChanges() || this.checkExpertListChanges() || this.checkInterestListChanges() || this.checkPersonalChanges());
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
                this.getProfileOriginal().greetings = JSON.parse(JSON.stringify(this.profile.greetings));
                this.getProfileOriginal().gender.string = this.profile.gender.string;
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
    }
}
