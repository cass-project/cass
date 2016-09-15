import {Injectable} from "@angular/core";
import {Router} from "@angular/router";
import {ProfileRESTService} from "../../../service/ProfileRESTService";
import {Session} from "../../../../session/Session";

@Injectable()
export class ProfileSwitcherService
{
    constructor(
        private profileRESTService: ProfileRESTService,
        private session: Session,
        private router: Router
    ) {}

    disableClick = false;

    switchProfile(profileId){
        if(!this.disableClick && this.session.getCurrentProfile().getId() !== profileId) {
            this.disableClick = true;

            this.session.getCurrentProfile().entity.profile.is_current = false;

            for (let i = 0; i < this.session.getCurrentAccount().profiles.profiles.length; i++) {
                if (profileId === this.session.getCurrentAccount().profiles.profiles[i].entity.profile.id) {
                    this.session.getCurrentAccount().profiles.profiles[i].entity.profile.is_current = true;
                }
            }

            this.profileRESTService.switchProfile(profileId).subscribe(data => {
                this.router.navigate(['Profile/Profile', {id: 'current'}]);
                window.location.reload();
            });
        }
    }

    getProfiles(){
        return this.session.getCurrentAccount().profiles.profiles;
    }
}