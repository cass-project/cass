import {NgModule} from '@angular/core';

import {ProfileComponent} from "./component/Elements/Profile/index";
import {ProfileModals} from "./component/Elements/Profile/modals";
import {ProfileCard} from "./component/Elements/ProfileCard/index";
import {ProfileCachedIdentityMap} from "./service/ProfileCachedIdentityMap";
import {ProfileRESTService} from "./service/ProfileRESTService";

@NgModule({
    declarations: [
        ProfileComponent,
        ProfileCard,
    ],
    providers: [
        ProfileModals,
        ProfileCachedIdentityMap,
        ProfileRESTService,
    ]
})
export class CASSProfileModule {}