import {Component, enableProdMode, Injectable, OnInit} from 'angular2/core';
import {Injectable} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {Http, Headers, HTTP_PROVIDERS, URLSearchParams, RequestOptions} from 'angular2/http';
import {BaseRequestOptions} from "angular2/http"
import {GetThemes} from "./component/ThemesAdminService/index";
import {CreateTheme} from "./component/ThemesAdminService/index";
import {UpdateTheme} from "./component/ThemesAdminService/index";
import {DeleteTheme} from "./component/ThemesAdminService/index";

@Component({
    selector: 'host-admin',
    template: require('./template.html'),
    directives: [ROUTER_DIRECTIVES],
    providers: [GetThemes, CreateTheme]
})

export class HostAdminComponent {
    themes;
    getThemes: GetThemes;
    createTheme: CreateTheme;
    constructor(getThemes:GetThemes, createTheme: CreateTheme) {
        this.themes = getThemes.themes;
        this.getThemes = getThemes;
        this.createTheme = createTheme;
        this.load();
   }
    load(){
        this.getThemes.loadThemes()
    }
    newTheme(value){
        this.createTheme.putTheme(value)
    }
};
