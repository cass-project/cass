import {Injectable} from "angular2/core";
import {AuthService} from "../../../../auth/service/AuthService";
import {ProfileRESTService} from "../../../service/ProfileRESTService";
import {AccountRESTService} from "../../../../account/service/AccountRESTService";
import {AuthToken} from "../../../../auth/service/AuthToken";
import {MessageBusService} from "../../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../../message/component/MessageBusNotifications/model";
import {Observable} from "rxjs/Observable";

@Injectable()
export class ProfileModalModel
{
    constructor(public authService: AuthService,
                private profileRESTService: ProfileRESTService,
                private accountRESTService: AccountRESTService,
                protected messages: MessageBusService,
                protected authToken: AuthToken){}
    
    profile = JSON.parse(JSON.stringify(this.authService.getCurrentAccount().getCurrentProfile().entity.profile));
    account = JSON.parse(JSON.stringify(this.authService.getCurrentAccount().entity));
    
    loading: boolean = false;

    password = {
        old: '',
        new: '',
        repeat: ''
    };
    
    getAccountOriginal(){
        return this.authService.getCurrentAccount().entity;
    }
    
    getProfileOriginal(){
        return this.authService.getCurrentAccount().getCurrentProfile().entity.profile;
    }

    reset(){
        this.profile = JSON.parse(JSON.stringify(this.authService.getCurrentAccount().getCurrentProfile().entity.profile));
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

        let personalRequest = {
            gender: this.profile.gender.string,
            avatar: false,
            method: this.profile.greetings.method,
            last_name: this.profile.greetings.last_name,
            first_name: this.profile.greetings.first_name,
            middle_name: this.profile.greetings.middle_name,
            nick_name: this.profile.greetings.nick_name
        };

        let requests = {
            account: this.accountRESTService.changePassword(this.password.old, this.password.new),
            expert_in:  this.profileRESTService.setExpertIn(this.getProfileOriginal().id, this.profile.expert_in_ids),
            interests_in: this.profileRESTService.setInterestingIn(this.getProfileOriginal().id, this.profile.interesting_in_ids),
            personal: this.profileRESTService.editPersonal(this.getProfileOriginal().id, personalRequest)
        };

        let observableRequest = [];

        if(this.checkAccountChanges()){
            observableRequest.push(requests.account);

            requests.account.subscribe(data => {
                this.password = {
                    old: '',
                    new: '',
                    repeat: ''
                }}, error => {});
        }

        if(this.checkExpertListChanges()){
            observableRequest.push(requests.expert_in);

            requests.expert_in.subscribe(data => {
                this.getProfileOriginal().expert_in_ids = this.profile.expert_in_ids.splice(0);
            }, error => {});
        }

        if(this.checkInterestListChanges()){
            observableRequest.push(requests.interests_in);

            requests.interests_in.subscribe(data => {
                this.getProfileOriginal().interesting_in_ids = this.profile.interesting_in_ids.splice(0);
            }, error => {});
        }

        if(this.checkPersonalChanges()){
            observableRequest.push(requests.personal);

            if(this.profile.greetings.method !== this.getProfileOriginal().greetings.method){
                personalRequest.avatar = true;
            }

            requests.personal.subscribe(data => {
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