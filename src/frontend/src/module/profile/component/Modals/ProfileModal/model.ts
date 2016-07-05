import {Injectable} from "angular2/core";
import {AuthService} from "../../../../auth/service/AuthService";
import {ProfileRESTService} from "../../../service/ProfileRESTService";
import {AccountRESTService} from "../../../../account/service/AccountRESTService";
import {ProfileModals} from "../../../modals";

@Injectable()
export class ProfileModalModel
{
    constructor(public authService: AuthService, private profileRESTService: ProfileRESTService, private accountRESTService: AccountRESTService, private profileModals: ProfileModals){}
    
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
    }

    canSave(){
       return (this.checkAccountChanges() || this.checkExpertListChanges() || this.checkInterestListChanges() || this.checkPersonalChanges());
    }

    saveAllChanges(){
        this.loading = true;

        if(this.checkAccountChanges()){
            this.accountRESTService.changePassword(this.password.old, this.password.new).subscribe(data => {
                this.loading = false;
            });
        }
        if(this.checkInterestListChanges()){
            let request = {
                theme_ids: this.profile.interesting_in_ids
            };

            this.profileRESTService.setInterestingIn(this.getProfileOriginal().id, request).subscribe(data => {
                this.getProfileOriginal().interesting_in_ids = this.profile.interesting_in_ids.splice(0);
                this.loading = false;
            })
        }
        if(this.checkExpertListChanges()){
            let request = {
                theme_ids: this.profile.expert_in_ids
            };

            this.profileRESTService.setExpertIn(this.getProfileOriginal().id, request).subscribe(data => {
                this.getProfileOriginal().expert_in_ids = this.profile.expert_in_ids.splice(0);
                this.loading = false;
            })
        }
        if(this.checkPersonalChanges()){
            let request = {
                gender: this.profile.gender.string,
                method: this.profile.greetings.method,
                last_name: this.profile.greetings.last_name,
                first_name: this.profile.greetings.first_name,
                middle_name: this.profile.greetings.middle_name,
                nick_name: this.profile.greetings.nick_name
            };

            this.profileRESTService.editPersonal(this.getProfileOriginal().id, request).subscribe(data => {
                this.getProfileOriginal().greetings = JSON.parse(JSON.stringify(this.profile.greetings));
                this.getProfileOriginal().gender.string = this.profile.gender.string;
                this.loading = false;
            })
        }
    }

    hasChanges(): boolean {
        return false;
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