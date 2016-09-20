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

let moduleDeclaration = {
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
};

for(let module of CASS_MODULES) {
    if(module['declarations']) moduleDeclaration.declarations.push(<any>module['declarations']);
    if(module['routes']) moduleDeclaration.declarations.push(<any>module['routes']);
    if(module['providers']) moduleDeclaration.providers.push(<any>module['providers']);
    if(module['imports']) moduleDeclaration.imports.push(<any>module['imports']);
}

@NgModule(moduleDeclaration)
export class AppModule {}

