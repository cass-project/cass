/// <reference path="./../../../typings/main/index.d.ts" />

import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';
import 'rxjs/Rx';

require('zone.js');

require('./../../../node_modules/reset.css/reset.css');
require('./../../styles/index.head.scss');

import {platformBrowserDynamic} from "@angular/platform-browser-dynamic";
import {enableProdMode} from '@angular/core';

import {FrontlineService, frontline} from "../../module/frontline/service";
import {AuthToken} from "../../module/auth/service/AuthToken";
import {AppModule} from "./app.module";

enableProdMode();

document.addEventListener('DOMContentLoaded', () => {
    frontline(session => {
        window['frontline'] = new FrontlineService(session);

        platformBrowserDynamic().bootstrapModule(AppModule).then(() => {
            document.getElementById('CASSAppFrontendLoadingStatus').remove();
        });
    });
});