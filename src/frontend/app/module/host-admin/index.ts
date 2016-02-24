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
    providers: [GetThemes, CreateTheme, DeleteTheme]
})

export class HostAdminComponent {
    getThemes: GetThemes;
    createTheme: CreateTheme;
    deleteTheme: DeleteTheme;
    constructor(getThemes: GetThemes, createTheme: CreateTheme, deleteTheme: DeleteTheme) {
        this.getThemes = getThemes;
        this.createTheme = createTheme;
        this.deleteTheme = deleteTheme;
        this.getThemes.loadThemes();
   }
    //newTheme(value){
    //    this.createTheme.putTheme(value);
    //    this.createTheme.clicked();
    //}
    //newClick(){
    //    this.createTheme.clicked();
    //}
};
