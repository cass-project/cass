import {Component} from "@angular/core";
import {SubscribeRESTService} from "../../../../../subscribe/service/SubscribeRESTService";
import {ProfileRouteService} from "../../../ProfileRoute/service";
import {ProfileEntity} from "../../../../definitions/entity/Profile";
import {ListProfiles} from "../../../../../subscribe/definitions/paths/list-profiles";
import {ListProfileRequest} from "../../../../../subscribe/definitions/paths/list-profiles";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfilesSubscriptionsRoute
{ /*
    private profile: ProfileEntity;
    private response: ListProfiles;
    private request: ListProfileRequest = {
        limit: 50,
        offset: 0
    };

    constructor(private subscribe: SubscribeRESTService,
                private service: ProfileRouteService
    ){}


    ngOnInit(){
      this.service.getProfile().subscribe(response => {
            this.profile = response.profile
        })

        this.subscribe.listProfiles(this.profile.id, this.request).subscribe(entity => {
            this.response = entity;
        })
    }
    */
}
