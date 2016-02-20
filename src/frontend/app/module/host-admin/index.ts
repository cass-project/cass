import {Component, enableProdMode, Injectable, OnInit} from 'angular2/core';
import {Injectable} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {Http, Headers, HTTP_PROVIDERS, URLSearchParams} from 'angular2/http';
import {BaseRequestOptions} from "angular2/http"

@Component({
    selector: 'host-admin',
    template: require('./template.html'),
    directives: [ROUTER_DIRECTIVES],
})

@Injectable()
export class HostAdminComponent {
    themes;
    data;
    constructor(http:Http) {

        http.get('/backend/api/protected/host-admin/theme-editor/read/entities/')
            .map(res => res.json())
            .subscribe(data => this.themes = data.entities);
        function create(value){
            http.put('/backend/api/protected/host-admin/theme-editor/entity/create', JSON.stringify({title: value}))
        }
    }
   createTheme(value: string){

    }
    deleteTheme(value: string){

    }
    updateTheme(value: string){

    }
}
