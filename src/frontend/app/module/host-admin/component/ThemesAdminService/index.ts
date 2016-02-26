import {Injectable} from 'angular2/core';
import {Http, RequestOptions} from 'angular2/http';
import {Headers} from "angular2/http";
import {ControlGroup} from "angular2/common";
import {Control} from "angular2/common";


@Injectable()
export class ManageThemes {
    themes;
    themeId;
    public http:Http;
    active: boolean = true;
    showAdd: boolean = false;
    showUpdate: boolean = false;

    constructor(public http:Http) {
        this.http = http;
    }

    public loadThemes() {
        return this.http.get('/backend/api/protected/host-admin/theme-editor/read/entities/')
            .map(res => res.json())
            .subscribe(data => this.themes = data.entities);
    }

    takeTheme(theme){
        this.themeId = theme.id;
    }

    putThemeClick() {
       this.showAdd = !this.showAdd;
    }
    putTheme(tittle, parrentId){
        var headers = new Headers();
        headers.append('Content-type', 'application/json');
        var options = new RequestOptions({
            headers: headers
        });
        if(parrentId == undefined) parrentId = 0;
        return this.http.put('/backend/api/protected/host-admin/theme-editor/entity/create', JSON.stringify({title: tittle, parent_id: parrentId}), options).subscribe(
            data =>{console.log(data); this.loadThemes();},
            err => {console.log(err);}
        );
    }

    updateThemeClick(){
        this.showUpdate = !this.showUpdate;
    }
    updateTheme(id, value, parrentId){
        var headers = new Headers();
        headers.append('Content-type', 'application/json');
        var options = new RequestOptions({
            headers: headers
        });
        if(parrentId == undefined) parrentId = 0;
        this.http.post('/backend/api/protected/host-admin/theme-editor/entity/update/' + id, JSON.stringify({title: value, parent_id: parrentId}), options).subscribe(
            data =>{ console.log(data); this.loadThemes();},
            err => {console.log(err);}
        );
    }

    deleteTheme(id) {
        var headers = new Headers();
        headers.append('Content-type', 'application/json');
        var options = new RequestOptions({
            headers: headers
        });
        this.http.delete('/backend/api/protected/host-admin/theme-editor/entity/delete/' + id, options).subscribe(
            data =>{ console.log(data); this.loadThemes();},
            err => {console.log(err);}
        );
    }

    openDialog(type){

    }
};