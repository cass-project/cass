import 'es6-shim';
import 'es6-promise';
import 'reflect-metadata';

import {App} from './app';
import {provide} from 'angular2/core';
import {bootstrap, ELEMENT_PROBE_PROVIDERS} from 'angular2/platform/browser';

document.addEventListener('DOMContentLoaded', () => {
    bootstrap(App).catch(err => console.error(err));
});