import {Component} from "angular2/core";

import {Screen} from "../../screen";
import {LoadingLinearIndicator} from "../../../../../../util/component/LoadingLinearIndicator/index";
import {CommunityRESTService} from "../../../../../service/CommunityRESTService";
import {CommunityCreateModalModel} from "../../model";

@Component({
    selector: 'cass-community-create-modal-screen-processing',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        LoadingLinearIndicator
    ]
})
export class ScreenProcessing extends Screen
{

    constructor(private service: CommunityRESTService, protected model: CommunityCreateModalModel) {
        super(model);
    }

    ngOnInit(){
        this.service.create(this.model).subscribe(data => {
            console.log(data);
            //this.nextEvent.emit(this);
        });
    }
}