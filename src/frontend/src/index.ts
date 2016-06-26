/// <reference path="./../typings/main/index.d.ts" />
/// <reference path="./../node_modules/angular2/typings/browser.d.ts" />

import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';
import 'rxjs/Rx';

require('zone.js');

require('./../node_modules/reset.css/reset.css');
require('./styles/index.head.scss');

import {provide} from "angular2/core";
import {RequestOptions, HTTP_PROVIDERS} from "angular2/http";
import {ROUTER_PROVIDERS} from "angular2/router";

import {App} from "./app";
import {frontline} from "./module/frontline/service";
import {FrontlineService} from "./module/frontline/service";
import {AuthRequestOptions} from "./module/auth/AuthRequestOptions";
import {bootstrap} from "angular2/platform/browser";

document.addEventListener('DOMContentLoaded', () => {
    frontline(session => {
        bootstrap(
            <any>App, [
                provide(FrontlineService, {useValue: new FrontlineService(session)}),
                ROUTER_PROVIDERS,
                HTTP_PROVIDERS,
                provide(RequestOptions, {useClass: AuthRequestOptions}),
                provide(Window, {useValue: session})
            ]).then(() => {
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

        document.getElementById('loading').remove();
    });
});