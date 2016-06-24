import {Component, Input, Output, EventEmitter} from "angular2/core";
import {Router} from "angular2/router";
import {ProfileRESTService} from "../../service/ProfileRESTService";
import {ProfileComponent} from "../../index";
import {AuthService} from "../../../auth/service/AuthService";
import {FrontlineService} from "../../../frontline/service";
import {ProfileComponentService} from "../../service";

@Component({
    selector: 'cass-profile-menu',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ProfileComponent
    ]
})
export class ProfileMenuComponent
{
    @Input('profile') profile: any;
    @Output('create_collection') create_collection = new EventEmitter();


    openCollectionSettings(collection){
        this.pService.currentCollection = collection;
        console.log(this.pService.currentCollection);


        this.pService.modals.collectionSettings.open();
    }

    constructor(private profileRESTService: ProfileRESTService, private router: Router, private pService: ProfileComponentService){
        if(!AuthService.isSignedIn()) {
            this.router.navigate(['Landing']);
        }
    }
}