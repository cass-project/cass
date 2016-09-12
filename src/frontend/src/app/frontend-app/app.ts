/// <reference path="./../../../typings/main/index.d.ts" />

import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';
import 'rxjs/Rx';

require('zone.js');

require('./../../../node_modules/reset.css/reset.css');
require('./../../styles/index.head.scss');

import {platformBrowserDynamic} from "@angular/platform-browser-dynamic";
import {Injectable, enableProdMode, SecurityContext} from '@angular/core';
import {DomSanitizer} from '@angular/platform-browser';

import {FrontlineService, frontline} from "../../module/frontline/service";
import {AuthToken} from "../../module/auth/service/AuthToken";
import {AppModule} from "./app.module";

enableProdMode();

@Injectable()
export class NoSanitizationService {
    sanitize(ctx: SecurityContext, value: any): string {
        return value;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    frontline(session => {
        var frontline = new FrontlineService(session);

        platformBrowserDynamic().bootstrapModule(AppModule, [
            {provide: FrontlineService, useValue: frontline},
            {provide: DomSanitizer, useClass: NoSanitizationService},
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
            }
            ]).catch((err) => {
            console.log(err.message);
        });

        document.getElementById('CASSAppFrontendLoadingStatus').remove();
    });
});