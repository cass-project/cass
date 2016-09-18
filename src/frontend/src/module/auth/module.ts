import {NgModule} from '@angular/core';

import {AuthModalsService} from "./component/Auth/modals";
import {AuthRESTService} from "./service/AuthRESTService";
import {AuthService} from "./service/AuthService";

@NgModule({
    declarations: [],
    providers: [
        AuthModalsService,
        AuthRESTService,
        AuthService,
    ]
})
export class CASSAuthModule {}