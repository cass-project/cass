import {NgModule, CUSTOM_ELEMENTS_SCHEMA, SecurityContext, Injectable} from '@angular/core';
import {BrowserModule, DomSanitizer} from '@angular/platform-browser';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HttpModule} from "@angular/http";
import {App}   from './app.component';
import {routing, appRoutingProviders} from "./app.routing";
import {CASS_MODULES} from "./../../module/modules.ts";
import {FrontlineService} from "../../module/frontline/service/FrontlineService";
import {AuthToken} from "../../module/auth/service/AuthToken";

@Injectable()
export class NoSanitizationService {
    sanitize(ctx: SecurityContext, value: any): string {
        return value;
    }
}

@NgModule({
    declarations: [
        App,
    ],
    schemas: [CUSTOM_ELEMENTS_SCHEMA],
    imports: [
        BrowserModule,
        routing,
        FormsModule, 
        ReactiveFormsModule,
        HttpModule,
        CASS_MODULES,
    ],
    providers: [
        appRoutingProviders,
        {provide: DomSanitizer, useClass: NoSanitizationService},
        {provide: FrontlineService, useFactory: function() {
            return window['frontline'];
        }},
        {provide: AuthToken, useFactory: () => {
            let frontline = window['frontline'];
            let token = new AuthToken();
            let hasAuth = frontline.session.auth
                && (typeof frontline.session.auth.api_key == "string")
                && (frontline.session.auth.api_key.length > 0);

            if (hasAuth) {
                let auth = frontline.session.auth;
                token.setToken(frontline.session.auth.api_key);
            }

            return token;}
        }
    ],
    bootstrap: [App]
})

export class AppModule {}

