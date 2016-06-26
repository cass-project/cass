import {Component} from "angular2/core";
import {Router} from "angular2/router";
import {ProfileComponentService} from "./service";
import {ProfileModal} from "./component/ProfileModal/index";
import {ModalComponent} from "../modal/component/index";
import {ProfileSwitcher} from "./component/ProfileSwitcher/index";
import {ProfileSetup} from "./component/ProfileSetup/index";
import {AuthService} from "../auth/service/AuthService";
import {ModalBoxComponent} from "../modal/component/box/index";
import {CollectionCreateMaster} from "../collection/component/CollectionCreateMaster/index";
import {CollectionSettings} from "../collection/component/CollectionSettings/index";

@Component({
    selector: 'cass-profile',
    template: require('./template.html'),
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ProfileModal,
        ProfileSwitcher,
        ProfileSetup,
        CollectionCreateMaster,
        CollectionSettings
    ]
})
export class ProfileComponent
{
    constructor(private service: ProfileComponentService, private router: Router) {
        if(AuthService.isSignedIn()) {
            console.log(AuthService.getAuthToken().getCurrentProfile(), 'collections');
            this.service.currentProfileCollections = AuthService.getAuthToken().getCurrentProfile().entity.collection;
        }
    }
}