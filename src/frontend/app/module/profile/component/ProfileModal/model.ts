import {Injectable} from "angular2/core";
import {ProfileRESTService} from "../ProfileService/ProfileRESTService";
import {ProfileService} from "../ProfileService/ProfileService";
import {ProfileComponentService} from "../../service";
import {ThemeSelect} from "../../../theme/component/ThemeSelect/index";
import {FrontlineService} from "../../../frontline/service";


@Injectable()
export class ProfileModalModel
{
    constructor(private profileRESTService: ProfileRESTService,
                private profileService: ProfileService,
                private modals: ProfileComponentService,
                private frontlineService: FrontlineService) {}

    changePasswordStn = {old_password: '', new_password: '', repeat_password: ''};
    profile = (JSON.parse(JSON.stringify(this.frontlineService.session.auth.profiles[0])));

    expertIn = (JSON.parse(JSON.stringify(this.frontlineService.session.auth.profiles[0].expert_in))); //Nice method to clone object, lol
    interestingIn = (JSON.parse(JSON.stringify(this.frontlineService.session.auth.profiles[0].interesting_in)));

    ApiKey;

    reset(){
        this.profileService.accountCondReset(this.changePasswordStn);
        this.profileService.personalCondReset(this.profile);
        this.profileService.interestCondReset(this.expertIn, this.interestingIn);
    }

    canSave(){
        if(this.profileService.accountCondToSave(this.changePasswordStn) ||
            this.profileService.personalCondToSave(this.profile) ||
            this.profileService.interestCondToSave(this.expertIn, this.interestingIn)){
            return true;
        } else {
            return false;
        }
    }

    saveAllChanges(){
        if(this.profileService.personalCondToSave(this.profile) && this.profileService.interestCondToSave(this.expertIn, this.interestingIn) && this.profileService.accountCondToSave(this.changePasswordStn)){
            this.profileRESTService.editPersonal(this.profile).subscribe(data => {
                this.profileRESTService.editSex(this.profile).subscribe(data => {
                    this.profileService.personalCondReset(this.profile);
                    this.profileRESTService.updateInterestThemes(this.interestingIn).subscribe(data => {
                    this.profileRESTService.updateExpertThemes(this.expertIn).subscribe(data => {this.profileService.interestCondReset(this.expertIn, this.interestingIn);
                        this.profileRESTService.changePassword(this.changePasswordStn).subscribe(data => {
                            this.profileService.accountCondReset(this.changePasswordStn);
                            //apiKey переназначается но сессия все равно заканчивается, нужно инвестигейтить
                            this.ApiKey = data;
                            this.ApiKey = JSON.parse(this.ApiKey._body);
                            this.frontlineService.session.auth.api_key = this.ApiKey.apiKey;
                            this.modals.modals.settings.close();});
                    });
                });
            });
        });
        } else if(this.profileService.personalCondToSave(this.profile) && this.profileService.interestCondToSave(this.expertIn, this.interestingIn)){
            this.profileRESTService.editPersonal(this.profile).subscribe(data => {
                this.profileRESTService.editSex(this.profile).subscribe(data => {
                    this.profileService.personalCondReset(this.profile);
                this.profileRESTService.updateInterestThemes(this.interestingIn).subscribe(data => {
                    this.profileRESTService.updateExpertThemes(this.expertIn).subscribe(data => {
                        this.profileService.interestCondReset(this.expertIn, this.interestingIn); this.modals.modals.settings.close();
                        });
                    });
                });
            });
        } else if(this.profileService.interestCondToSave(this.expertIn, this.interestingIn) && this.profileService.accountCondToSave(this.changePasswordStn)){
            this.profileRESTService.updateInterestThemes(this.interestingIn).subscribe(data => {
                this.profileRESTService.updateExpertThemes(this.expertIn).subscribe(data => {
                    this.profileService.interestCondReset(this.expertIn, this.interestingIn);
                    this.profileRESTService.changePassword(this.changePasswordStn).subscribe(data => {
                        this.profileService.accountCondReset(this.changePasswordStn);
                        //apiKey переназначается но сессия все равно заканчивается, нужно инвестигейтить
                        this.ApiKey = data;
                        this.ApiKey = JSON.parse(this.ApiKey._body);
                        this.frontlineService.session.auth.api_key = this.ApiKey.apiKey;
                        this.modals.modals.settings.close();
                    });
                });
            });
        } else if(this.profileService.personalCondToSave(this.profile) && this.profileService.accountCondToSave(this.changePasswordStn)) {
            this.profileRESTService.editPersonal(this.profile).subscribe(data => {
                this.profileRESTService.editSex(this.profile).subscribe(data => {
                    this.profileService.personalCondReset(this.profile);
                this.profileRESTService.changePassword(this.changePasswordStn).subscribe(data => {
                    this.profileService.accountCondReset(this.changePasswordStn);
                    this.ApiKey = data;
                    this.ApiKey = JSON.parse(this.ApiKey._body);
                    this.frontlineService.session.auth.api_key = this.ApiKey.apiKey;
                    this.modals.modals.settings.close();
                });
            });
        });
        } else if (this.profileService.personalCondToSave(this.profile)){
            this.profileRESTService.editPersonal(this.profile).subscribe(data => {
                this.profileRESTService.editSex(this.profile).subscribe(data => {
                    this.profileService.personalCondReset(this.profile); this.modals.modals.settings.close();
                });
            });
        } else if(this.profileService.interestCondToSave(this.expertIn, this.interestingIn)){
            this.profileRESTService.updateInterestThemes(this.interestingIn).subscribe(data => {
                this.profileRESTService.updateExpertThemes(this.expertIn).subscribe(data => {this.profileService.interestCondReset(this.expertIn, this.interestingIn); this.modals.modals.settings.close();});
            });
        } else if(this.profileService.accountCondToSave(this.changePasswordStn)){
            this.profileRESTService.changePassword(this.changePasswordStn).subscribe(data => {
                this.profileService.accountCondReset(this.changePasswordStn);
                //apiKey переназначается но сессия все равно заканчивается, нужно инвестигейтить
                this.ApiKey = data;
                this.ApiKey = JSON.parse(this.ApiKey._body);
                this.frontlineService.session.auth.api_key = this.ApiKey.apiKey;
                this.modals.modals.settings.close();
            });
        }
    }

    hasChanges(): boolean {
        return false;
    }
}