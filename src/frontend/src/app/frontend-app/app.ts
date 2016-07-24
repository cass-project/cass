/// <reference path="./../../../typings/main/index.d.ts" />
/// <reference path="./../../../node_modules/angular2/typings/browser.d.ts" />

import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';
import 'rxjs/Rx';

require('zone.js');

require('./../../../node_modules/reset.css/reset.css');
require('./../../styles/index.head.scss');

import {provide} from "angular2/core";
import {bootstrap} from "angular2/platform/browser";
import {enableProdMode} from 'angular2/core';
import {HTTP_PROVIDERS} from "angular2/http";
import {ROUTER_PROVIDERS} from "angular2/router";

import {App} from "./index";
import {FrontlineService, frontline} from "../../module/frontline/service";
import {AuthToken} from "../../module/auth/service/AuthToken";

enableProdMode();

document.addEventListener('DOMContentLoaded', () => {
    frontline(session => {
        var frontline = new FrontlineService(session);

        bootstrap(
            <any>App, [
                provide(FrontlineService, {useValue: frontline}),
                ROUTER_PROVIDERS,
                HTTP_PROVIDERS,
                provide(Window, {useValue: session}),
                provide(AuthToken, {useFactory: () => {
                    let token = new AuthToken();
                    let hasAuth = frontline.session.auth
                        && (typeof frontline.session.auth.api_key == "string")
                        && (frontline.session.auth.api_key.length > 0);

                    if(hasAuth) {
                        let auth = frontline.session.auth;
                        token.setToken(frontline.session.auth.api_key);
                    }

                    return token;
                }})
            ]).catch((err) => {
                console.log(err.message);
            }
        );

        document.getElementById('CASSAppFrontendLoadingStatus').remove();
    });
});