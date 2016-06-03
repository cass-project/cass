import {Component} from "angular2/core";
import {CommunityModel} from "./model";
import {RouteParams, Router} from "angular2/router";
import {CommunityRESTService} from "../../service/CommunityRESTService";
import {ModalComponent} from "../../../modal/component/index";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {LoadingLinearIndicator} from "../../../util/component/LoadingLinearIndicator/index";

@Component({
    selector: "community-page",
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        LoadingLinearIndicator
    ],
    providers:[CommunityModel]
})
export class CommunityPage
{
    isAdmin:boolean = false;
    isLoaded:boolean = false;

    constructor(
        private community:CommunityModel,
        private routeParams: RouteParams,
        private service: CommunityRESTService
    ){

    }

    ssngOnInit() {
        this.service
            .getBySid(this.routeParams.get('sid'))
            .map(data => data.json())
            .subscribe(
                data => {
                    this.isAdmin = data.access.admin;
                    this.community = data.entity;
                    this.isLoaded = true;
                }
            )
    }
}