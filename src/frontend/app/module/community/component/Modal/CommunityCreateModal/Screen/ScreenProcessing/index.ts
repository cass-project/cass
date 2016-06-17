import {Component} from "angular2/core";

import {Screen} from "../../screen";
import {LoadingLinearIndicator} from "../../../../../../util/component/LoadingLinearIndicator/index";
import {CommunityRESTService} from "../../../../../service/CommunityRESTService";
import {CommunityCreateModalModel} from "../../model";
import {COMMON_DIRECTIVES} from "angular2/common";
import {CommunityCreateRequestModel} from "../../../../../model/CommunityCreateRequestModel";
import {CommunityImageUploadRequestModel} from "../../../../../model/CommunityImageUploadRequestModel";
import {CommunityControlFeatureRequestModel} from "../../../../../model/CommunityActivateFeatureModel";

@Component({
    selector: 'cass-community-create-modal-screen-processing',
    template: require('./template.jade'),
    directives: [
        LoadingLinearIndicator
    ]
})
export class ScreenProcessing extends Screen
{

    constructor (
        private service: CommunityRESTService,
        protected model: CommunityCreateModalModel
    ) {
        super();
    }

    ngOnInit() {
        let model = this.model;

        this.service.create(<CommunityCreateRequestModel>{
                "title"       : model.title,
                "description" : model.description,
                "theme_id"    : model.theme_id
            })
            .map(data => data.json())
            .subscribe(data => {
                let communityId = data['entity'].id;
                let requests:Promise<any>[] = [];

                for(let feature of this.model.features) {
                    if(feature.is_activated && !feature.disabled) {
                        requests.push(
                            this.service
                                .activateFeature(<CommunityControlFeatureRequestModel>{
                                    communityId: communityId,
                                    feature: feature.code
                                })
                                .toPromise()
                        );
                    }
                }

                if(model.uploadImage && model.uploadImageCrop) {
                    requests.push(
                        this.service.imageUpload(<CommunityImageUploadRequestModel>{
                                communityId: communityId,
                                uploadImage: model.uploadImage,
                                x1: model.uploadImageCrop.x,
                                y1: model.uploadImageCrop.y,
                                x2: model.uploadImageCrop.width + model.uploadImageCrop.x,
                                y2: model.uploadImageCrop.height + model.uploadImageCrop.y
                            })
                            .toPromise()
                    );
                }

                Promise.all(requests).then(responses => {
                    console.log(responses);
                    this.next();
                });
            });
    }
}