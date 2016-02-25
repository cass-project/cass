import {Component, enableProdMode, Injectable, OnInit} from 'angular2/core';
import {Injectable} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {Http, Headers, HTTP_PROVIDERS, URLSearchParams, RequestOptions} from 'angular2/http';
import {BaseRequestOptions} from "angular2/http"
import {ManageThemes} from "./component/ThemesAdminService/index";

@Component({
    selector: 'host-admin',
    template: require('./template.html'),
    directives: [ROUTER_DIRECTIVES],
    providers: [ManageThemes]
})

export class HostAdminComponent {
    manageThemes: ManageThemes;

    constructor(manageThemes: ManageThemes) {
        this.manageThemes = manageThemes;
        this.manageThemes.loadThemes();
    }
};
