import {Injectable} from "angular2/core";
import {AuthService} from "../../../../auth/service/AuthService";
import {ProfileExtendedEntity} from "../../../definitions/entity/Profile";

@Injectable()
export class ProfileModalModel
{
    constructor(public authService: AuthService){}
    
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
       return this.checkPersonalChanges();
    }

    saveAllChanges(){
        if(this.checkAccountChanges() && this.checkInterestsChanges() && this.checkPersonalChanges()){
            
        }
    }

    hasChanges(): boolean {
        return false;
    }

    checkAccountChanges(){

    }

    checkInterestsChanges(){

    }

    checkPersonalChanges(){
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