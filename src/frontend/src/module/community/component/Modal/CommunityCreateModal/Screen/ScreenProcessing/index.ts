import {Component} from "angular2/core";

import {Screen} from "../../screen";
import {CommunityRESTService} from "../../../../../service/CommunityRESTService";
import {CommunityCreateModalModel} from "../../model";
import {CommunityCreateRequestModel} from "../../../../../model/CommunityCreateRequestModel";
import {CommunityImageUploadRequestModel} from "../../../../../model/CommunityImageUploadRequestModel";
import {CommunityControlFeatureRequestModel} from "../../../../../model/CommunityActivateFeatureModel";
import {LoadingLinearIndicator} from "../../../../../../form/component/LoadingLinearIndicator/index";

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
        public model: CommunityCreateModalModel,
        private service: CommunityRESTService
    ) {
        super();

        let model = this.model;

        this.service.create(<CommunityCreateRequestModel>{
                "title"       : model.title,
                "description" : model.description,
                "theme_ids"   : model.theme_ids
            })
            .subscribe(data => {
                console.log(data);
                let communityId = data['entity'].community.id;
                let requests:Promise<any>[] = [];
                this.model.sid = data['entity'].community.sid;

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
                    this.next();
                });
            });
    }
}