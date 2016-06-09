import {Component} from "angular2/core";
import {RouteParams, Router} from "angular2/router";

import {CommunityModel} from "./../../model";
import {CommunityService} from "../../service/CommunityService";
import {ModalComponent} from "../../../modal/component/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {ProfileMenuComponent} from "../../../profile/component/ProfileMenu/index";
import {LoadingLinearIndicator} from "../../../util/component/LoadingLinearIndicator/index";
import {ModalControl} from "../../../util/classes/ModalControl";
import {CommunityComponentService} from "../../service";

@Component({
    selector: "community-page",
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ProfileMenuComponent,
        LoadingLinearIndicator
    ]
})
export class CommunityPage
{
    public isLoading:boolean = false;

    constructor(
        private routeParams: RouteParams,
        private service: CommunityService,
        private modalsService: CommunityComponentService
    ){}

    ngOnInit() {
        let timeout = setTimeout(()=>{ this.isLoading=true;}, 1000);
        this.service.getBySid(this.routeParams.get('sid')).subscribe(
            data => {
                this.isLoading = false;
                clearTimeout(timeout);
                console.log(data);
            }
        );
    }

    reset() {
        this.service.community = undefined;
        this.service.isAdmin = false;
    }
}