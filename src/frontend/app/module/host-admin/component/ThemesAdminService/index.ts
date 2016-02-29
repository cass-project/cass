import {Injectable} from 'angular2/core';
import {Http, RequestOptions} from 'angular2/http';
import {Headers} from "angular2/http";
import {ControlGroup} from "angular2/common";
import {Control} from "angular2/common";



@Injectable()
export class ManageThemes {
    themes;
    dirictories = [];
    parentThemes = [];
    childThemes = [];
    themeId: number;
    active: boolean = true;
    showAdd: boolean = false;
    showUpdate: boolean = false;
    showChild: boolean = false;
    crudShow: boolean = false;
    checked: boolean = false;
    public http:Http;

    constructor(public http:Http) {
        this.http = http;

    }

    public loadThemes() {
        return this.http.get('/backend/api/protected/host-admin/theme-editor/read/entities/')
            .map(res => res.json())
            .subscribe(data => {this.themes = data.entities;
                for(var i = 0; i < this.themes.length; i++){
                if(this.themes[i].parent_id){
                    this.dirThemes(this.themes[i].id, this.themes[i].parent_id)
                } else this.parentThemes.push(this.themes[i]);
            }});

    }

    getIcon(){

        if(this.showChild){
            return '-';
        }

        return '+';
    }

    eraseArrays(){
        this.parentThemes = [];
        this.childThemes = [];
        this.showChild = false;
    }

    dirThemes(id, parentId){

    }

    takeTheme(theme){
        this.themeId = theme.id;

    }


    putTheme(tittle, parrentId){
        var headers = new Headers();
        headers.append('Content-type', 'application/json');
        var options = new RequestOptions({
            headers: headers
        });
        if(parrentId == undefined) parrentId = 0;
        return this.http.put('/backend/api/protected/host-admin/theme-editor/entity/create', JSON.stringify({title: tittle, parent_id: parrentId}), options).subscribe(
            data =>{console.log(data); this.eraseArrays(); this.loadThemes();},
            err => {console.log(err);}
        );
    }

    updateTheme(id, value, parrentId){
        var headers = new Headers();
        headers.append('Content-type', 'application/json');
        var options = new RequestOptions({
            headers: headers
        });
        if(parrentId == undefined) parrentId = 0;
        this.http.post('/backend/api/protected/host-admin/theme-editor/entity/update/' + id, JSON.stringify({title: value, parent_id: parrentId}), options).subscribe(
            data =>{console.log(data); console.log(this.themes, this.parentThemes); this.eraseArrays(); this.loadThemes();},
            err => {console.log(err);}
        );
    }

    deleteTheme(id) {
        this.crudShow = !this.crudShow;
        var headers = new Headers();
        headers.append('Content-type', 'application/json');
        var options = new RequestOptions({
            headers: headers
        });
        this.http.delete('/backend/api/protected/host-admin/theme-editor/entity/delete/' + id, options).subscribe(
            data =>{ console.log(data); this.eraseArrays(); this.loadThemes();},
            err => {console.log(err);}
        );
    }

    openDialog(type){

    }
};