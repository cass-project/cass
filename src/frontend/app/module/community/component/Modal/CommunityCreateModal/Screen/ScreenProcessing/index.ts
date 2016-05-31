import {Component} from "angular2/core";

import {Screen} from "../../screen";
import {LoadingLinearIndicator} from "../../../../../../util/component/LoadingLinearIndicator/index";
import {CommunityRESTService} from "../../../../../service/CommunityRESTService";
import {CommunityCreateModalModel} from "../../model";
import {CommunityComponentService} from "../../../../../service";

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

    constructor(
        private communityRESTService: CommunityRESTService,
        protected model: CommunityCreateModalModel
    ) {
        super(model);
    }

    ngOnInit(){
        this.communityRESTService.create(this.model).map(data => data.json()).subscribe(data => {
            if(this.model.uploadImage){
                this.communityRESTService.imageUpload(
                    data['entity'].id,
                    this.model.uploadImage,
                    this.model.uploadImageCrop,
                    () => { this.next(); }
                );
            }else{
                this.next();
            }
        });
    }
}