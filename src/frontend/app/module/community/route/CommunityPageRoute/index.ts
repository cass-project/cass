import {Component} from "angular2/core";
import {RouteParams} from "angular2/router";

import {CommunityEnity} from "./../../enity/Community";
import {CommunityService} from "../../service/CommunityService";
import {ModalComponent} from "../../../modal/component";
import {ModalBoxComponent} from "../../../modal/component/box";
import {LoadingLinearIndicator} from "../../../util/component/LoadingLinearIndicator";
import {CommunityComponentService} from "../../service";

@Component({
    selector: "community-page",
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        LoadingLinearIndicator
    ]
})
export class CommunityPage
{
    public isLoading:boolean = false;
    private community:CommunityEnity;
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
            }
        );
    }

    reset() {
        this.service.community = undefined;
        this.service.isAdmin = false;
    }
}