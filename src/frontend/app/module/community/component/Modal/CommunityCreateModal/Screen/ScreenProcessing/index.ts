import {Component} from "angular2/core";

import {Screen} from "../../screen";
import {LoadingLinearIndicator} from "../../../../../../util/component/LoadingLinearIndicator/index";
import {CommunityRESTService} from "../../../../../service/CommunityRESTService";
import {CommunityCreateModalModel} from "../../model";
import {COMMON_DIRECTIVES} from "angular2/common";

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

    ngOnInit() {
        let model = this.model;
        this.communityRESTService.create(model.title, model.description, model.theme_id)
            .map(data => data.json())
            .subscribe(data => {
                let communityId = data['entity'].id;
                let requests:Promise<any>[] = [];

                for(let feature of this.model.features) {
                    if(feature.is_activated && !feature.disabled) {
                        requests.push(
                            this.communityRESTService
                                .activateFeature(communityId, feature.code)
                                .toPromise()
                        );
                    }
                }

                if(model.uploadImage && model.uploadImageCrop) {
                    requests.push(
                        this.communityRESTService
                            .imageUpload(communityId, model.uploadImage, model.uploadImageCrop)
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