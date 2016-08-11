/// <reference path="./../../../typings/main/index.d.ts" />

import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';
import 'rxjs/Rx';

require('zone.js');
require('bootstrap/scss/bootstrap-flex.scss');
require('bootstrap/dist/js/bootstrap.js');
require('font-awesome/css/font-awesome.css');
require('../../styles/feedback.head.scss');

import {provide, enableProdMode} from "@angular/core";
import {HTTP_PROVIDERS} from "@angular/http";
import {ROUTER_PROVIDERS} from "@angular/router-deprecated";
import {Title} from '@angular/platform-browser'
import {bootstrap} from '@angular/platform-browser-dynamic'

import {AuthToken} from "../../module/auth/service/AuthToken";
import {frontline} from "../../module/frontline/service";
import {FrontlineService} from "../../module/frontline/service";
import {App} from "./app";

enableProdMode();

declare var jQuery;
jQuery(()=>frontline(initBootstrap));

function initBootstrap(session) {
    let frontline = new FrontlineService(session);

    bootstrap(
        <any>App, [
            ROUTER_PROVIDERS,
            HTTP_PROVIDERS,
            Title,
            provide(FrontlineService, {useValue: frontline}),
            provide(Window, {useValue: session}),
            provide(AuthToken, {useFactory: () => AuthTokenFactory(frontline)})
        ]).then(() => {
            jQuery('#loading').fadeOut(300, function () {
                this.remove();
            });
            setInterval(() => {
                let cassModalClass = 'cass-has-modals';
                let classList = document.body.classList;
    
                if(document.getElementsByClassName('cass-modal').length > 0) {
                    classList.add(cassModalClass);
                }else if(classList.contains(cassModalClass)) {
                    classList.remove(cassModalClass);
                }
            }, 100);

        }).catch((err) => {
            console.log(err.message);
        }
    );
}

export function AuthTokenFactory(frontline: FrontlineService) {
    let token = new AuthToken();
    let hasAuth = frontline.session.auth
        && (typeof frontline.session.auth.api_key == "string")
        && (frontline.session.auth.api_key.length > 0);

    if(hasAuth) {
        let auth = frontline.session.auth;
        token.setToken(frontline.session.auth.api_key);
    }

    return token;
}