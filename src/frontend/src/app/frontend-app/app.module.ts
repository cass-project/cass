import {NgModule}       from '@angular/core';
import {ROUTER_PROVIDERS} from "@angular/router";
import {BrowserModule} from '@angular/platform-browser';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HttpModule} from "@angular/http";
import {App}   from './app.component';
import {routing, appRoutingProviders} from "./app.routing";


@NgModule({
    declarations: [App],
    imports: [
        BrowserModule,
        routing,
        FormsModule, 
        ReactiveFormsModule,
        HttpModule],
    providers: [
        /*{provide: FrontlineService, useValue: frontline},
               /!*{provide: DomSanitizationService, useClass: NoSanitizationService},*!/
               {provide: Window, useValue: session},
               {provide: AuthToken, useFactory: () => {
                   let token = new AuthToken();
                   let hasAuth = frontline.session.auth
                       && (typeof frontline.session.auth.api_key == "string")
                       && (frontline.session.auth.api_key.length > 0);

                   if (hasAuth) {
                       let auth = frontline.session.auth;
                       token.setToken(frontline.session.auth.api_key);
                   }

                   return token;}
               },*/
               ROUTER_PROVIDERS, HttpModule, appRoutingProviders
    ],
    bootstrap: [App],
})

export class AppModule {}

