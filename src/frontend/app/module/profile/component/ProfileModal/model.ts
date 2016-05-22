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

    needToSave: boolean = false;
    passwordData;

    reset(){
        this.profileService.accountCondReset();
        this.profileService.personalCondReset();
        this.profileService.interestCondReset();
    }

    canSave(){
        if(this.profileService.accountCondToSave() ||
            this.profileService.personalCondToSave() ||
            this.profileService.interestCondToSave()){
            return true;
        } else {
            return false;
        }
    }

    saveAllChanges(){

        if(this.profileService.personalCondToSave() && this.profileService.interestCondToSave() && this.profileService.accountCondToSave()){
            this.profileRESTService.editPersonal().subscribe(data => {this.profileService.personalCondReset();
                this.profileRESTService.updateInterestThemes().subscribe(data => {
                    this.profileRESTService.updateExpertThemes().subscribe(data => {this.profileService.interestCondReset();
                        this.profileRESTService.changePassword().subscribe(data => {
                            this.profileService.accountCondReset();
                            //apiKey переназначается но сессия все равно заканчивается, нужно инвестигейтить
                            this.passwordData = data;
                            this.passwordData = JSON.parse(this.passwordData._body);
                            this.frontlineService.session.auth.api_key = this.passwordData.apiKey;
                            this.modals.modals.settings.close();});
                    });
                });
            })
        } else if(this.profileService.personalCondToSave() && this.profileService.interestCondToSave()){
            this.profileRESTService.editPersonal().subscribe(data => {this.profileService.personalCondReset();
                this.profileRESTService.updateInterestThemes().subscribe(data => {
                    this.profileRESTService.updateExpertThemes().subscribe(data => {this.profileService.interestCondReset(); this.modals.modals.settings.close();});
                });
            });
        } else if(this.profileService.interestCondToSave() && this.profileService.accountCondToSave()){
            this.profileRESTService.updateInterestThemes().subscribe(data => {
                this.profileRESTService.updateExpertThemes().subscribe(data => {
                    this.profileService.interestCondReset();
                    this.profileRESTService.changePassword().subscribe(data => {
                        this.profileService.accountCondReset();
                        //apiKey переназначается но сессия все равно заканчивается, нужно инвестигейтить
                        this.passwordData = data;
                        this.passwordData = JSON.parse(this.passwordData._body);
                        this.frontlineService.session.auth.api_key = this.passwordData.apiKey;
                        this.modals.modals.settings.close();
                    });
                });
            });
        } else if(this.profileService.personalCondToSave() && this.profileService.accountCondToSave()) {
            this.profileRESTService.editPersonal().subscribe(data => {
                this.profileService.personalCondReset();
                this.profileRESTService.changePassword().subscribe(data => {
                    this.profileService.accountCondReset();
                    this.passwordData = data;
                    this.passwordData = JSON.parse(this.passwordData._body);
                    this.frontlineService.session.auth.api_key = this.passwordData.apiKey;
                    this.modals.modals.settings.close();
                });
            });
        } else if (this.profileService.personalCondToSave()){
            this.profileRESTService.editPersonal().subscribe(data => {this.profileService.personalCondReset(); this.modals.modals.settings.close();})

        } else if(this.profileService.interestCondToSave()){
            this.profileRESTService.updateInterestThemes().subscribe(data => {
                this.profileRESTService.updateExpertThemes().subscribe(data => {this.profileService.interestCondReset(); this.modals.modals.settings.close();});
            });
        } else if(this.profileService.accountCondToSave()){
            this.profileRESTService.changePassword().subscribe(data => {
                this.profileService.accountCondReset();
                //apiKey переназначается но сессия все равно заканчивается, нужно инвестигейтить
                this.passwordData = data;
                this.passwordData = JSON.parse(this.passwordData._body);
                this.frontlineService.session.auth.api_key = this.passwordData.apiKey;
                this.modals.modals.settings.close();
            });
        }
    }

    hasChanges(): boolean {
        return false;
    }
}