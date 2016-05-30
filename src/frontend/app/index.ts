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
import {bootstrap} from "angular2/bootstrap";
import {ROUTER_PROVIDERS} from "angular2/router";

import {App} from "./app";
import {frontline} from "./module/frontline/service";
import {FrontlineService} from "./module/frontline/service";
import {OAuthRequestOptions} from "./module/auth/OAuthRequestOptions";

document.addEventListener('DOMContentLoaded', () => {
    frontline(session => {
        document.getElementById('loading').remove();

        bootstrap(
            <any>App, [
                provide(FrontlineService, {useValue: new FrontlineService(session)}),
                ROUTER_PROVIDERS,
                HTTP_PROVIDERS,
                provide(RequestOptions, {useClass: OAuthRequestOptions}),
                provide(Window, {useValue: session})
            ]).catch((err) => {
                console.log(err.message);
            }
        );
    });
});