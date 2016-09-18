import {NgModule} from '@angular/core';

import {AccountComponent} from "./component/Account/index";
import {AccountRESTService} from "./service/AccountRESTService";
import {AccountDeleteWarning} from "./component/AccountDeleteWarning/index";

@NgModule({
    declarations: [
        AccountComponent,
        AccountDeleteWarning,
    ],
    providers: [
        AccountRESTService,
    ]
})
export class CASSAccountModule {}