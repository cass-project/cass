import {NgModule} from '@angular/core';

import {AuthModalsService} from "./component/Auth/modals";
import {AuthRESTService} from "./service/AuthRESTService";
import {AuthService} from "./service/AuthService";
import {AuthComponent} from "./component/Auth/index";
import {OAuth2Component} from "./component/OAuth2/index";
import {SignInComponent} from "./component/SignIn/index";
import {SignUpComponent} from "./component/SignUp/index";
import {SignInByAPIKeyComponent} from "./component/SignInByAPIKey/index";

@NgModule({
    declarations: [
        AuthComponent,
        OAuth2Component,
        SignInComponent,
        SignUpComponent,
        SignInByAPIKeyComponent,
    ],
    providers: [
        AuthModalsService,
        AuthRESTService,
        AuthService,
    ]
})
export class CASSAuthModule {}