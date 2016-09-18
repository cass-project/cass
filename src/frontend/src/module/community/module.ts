import {NgModule} from '@angular/core';

import {CommunityRESTService} from "./service/CommunityRESTService";
import {CommunityFeaturesService} from "./service/CommunityFeaturesService";
import {CommunityModalService} from "./service/CommunityModalService";

@NgModule({
    declarations: [],
    providers: [
        CommunityRESTService,
        CommunityFeaturesService,
        CommunityModalService,
    ]
})
export class CASSCommunityModal {}