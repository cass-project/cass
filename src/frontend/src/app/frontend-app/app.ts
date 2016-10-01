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
import {AppModule} from "./app.module";
import {FrontlineService, frontline} from "../../module/frontline/service/FrontlineService";

enableProdMode();

document.addEventListener('DOMContentLoaded', () => {
    frontline(session => {
        window['frontline'] = new FrontlineService(session);

        platformBrowserDynamic().bootstrapModule(AppModule).then(() => {
            document.getElementById('CASSAppFrontendLoadingStatus').remove();
        });
    });
});