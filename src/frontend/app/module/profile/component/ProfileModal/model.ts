import {Injectable} from "angular2/core";
import {ProfileRESTService} from "../../service/ProfileRESTService";
import {ProfileService} from "../../service/ProfileService";
import {ProfileComponentService} from "../../service";
import {ThemeSelect} from "../../../theme/component/ThemeSelect/index";
import {AuthService} from "../../../auth/service/AuthService";
import {AuthRESTService} from "../../../auth/service/AuthRESTService";


@Injectable()
export class ProfileModalModel
{
    constructor(private profileRESTService: ProfileRESTService,
                private profileService: ProfileService,
                private modals: ProfileComponentService,
                private authRESTService: AuthRESTService) {}

    changePasswordStn = {old_password: '', new_password: '', repeat_password: ''};
    profile = JSON.parse(JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity.profile));

    expertIn = JSON.parse(JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity.profile.expert_in_ids));
    interestingIn = JSON.parse(JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity.profile.interesting_in_ids));

    loading: boolean = false;
    ApiKey;

    signOut(){
        this.authRESTService.signOut();
    }

    reset(){
        this.profileService.accountCondReset(this.changePasswordStn);
        this.profileService.personalCondReset(this.profile);
        this.profileService.interestCondReset(this.expertIn, this.interestingIn);
        this.authRESTService.signOut()
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

    saveAllChanges() {
        this.loading = true;
        if(this.profileService.personalCondToSave(this.profile) && this.profileService.interestCondToSave(this.expertIn, this.interestingIn) && this.profileService.accountCondToSave(this.changePasswordStn)){
            this.profileRESTService.editPersonal(this.profile).subscribe(data => {
                    this.profileService.personalCondReset(this.profile);
                    this.profileRESTService.updateInterestThemes(this.interestingIn).subscribe(data => {
                    this.profileRESTService.updateExpertThemes(this.expertIn).subscribe(data => {this.profileService.interestCondReset(this.expertIn, this.interestingIn);
                        this.profileRESTService.changePassword(this.changePasswordStn).subscribe(data => {
                            this.profileService.accountCondReset(this.changePasswordStn);
                            this.ApiKey = data;
                            this.ApiKey = JSON.parse(this.ApiKey._body);
                            AuthService.getAuthToken().apiKey = this.ApiKey.apiKey;
                            this.modals.modals.settings.close();
                            this.loading = false;
                        });
                    });
                });
            });;
        } else if(this.profileService.personalCondToSave(this.profile) && this.profileService.interestCondToSave(this.expertIn, this.interestingIn)){
            this.profileRESTService.editPersonal(this.profile).subscribe(data => {
                    this.profileService.personalCondReset(this.profile);
                this.profileRESTService.updateInterestThemes(this.interestingIn).subscribe(data => {
                    this.profileRESTService.updateExpertThemes(this.expertIn).subscribe(data => {
                        this.profileService.interestCondReset(this.expertIn, this.interestingIn); this.modals.modals.settings.close();
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
                        AuthService.getAuthToken().apiKey = this.ApiKey.apiKey;
                        this.modals.modals.settings.close();
                    });
                });
            });
        } else if(this.profileService.personalCondToSave(this.profile) && this.profileService.accountCondToSave(this.changePasswordStn)) {
            this.profileRESTService.editPersonal(this.profile).subscribe(data => {
                    this.profileService.personalCondReset(this.profile);
                this.profileRESTService.changePassword(this.changePasswordStn).subscribe(data => {
                    this.profileService.accountCondReset(this.changePasswordStn);
                    this.ApiKey = data;
                    this.ApiKey = JSON.parse(this.ApiKey._body);
                    AuthService.getAuthToken().apiKey = this.ApiKey.apiKey;
                    this.modals.modals.settings.close();
                });
            });
        } else if (this.profileService.personalCondToSave(this.profile)){
            this.profileRESTService.editPersonal(this.profile).subscribe(data => {
                    this.profileService.personalCondReset(this.profile); this.modals.modals.settings.close();
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
                AuthService.getAuthToken().apiKey = this.ApiKey.apiKey;
                this.modals.modals.settings.close();
            });
        }
    }

    hasChanges(): boolean {
        return false;
    }
}