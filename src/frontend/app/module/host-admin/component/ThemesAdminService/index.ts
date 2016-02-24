import {Injectable} from 'angular2/core';
import {Http, RequestOptions} from 'angular2/http';
import {Headers} from "angular2/http";

@Injectable()
export class GetThemes {
    themes;
    public http:Http;

    constructor(public http:Http) {
        this.http = http;
    }

    public loadThemes() {
        return this.http.get('/backend/api/protected/host-admin/theme-editor/read/entities/')
            .map(res => res.json())
            .subscribe(data => this.themes = data.entities);

    }
};

@Injectable()
export class CreateTheme {
    show: boolean = false;
    clicked(){
        this.show = !this.show;
    }
    public http:Http;
    constructor(public http:Http) {
        this.http = http;
    }
    putTheme(value){
        //var headers = new Headers();
        //headers.append('Content-type', 'application/json');
        console.log(value);
        console.log(JSON.stringify({title: value}));
        console.log(this.http.put('/backend/api/protected/host-admin/theme-editor/entity/create', JSON.stringify({title: value})).map(res => res.json()));
       return this.http.put('/backend/api/protected/host-admin/theme-editor/entity/create', JSON.stringify({title: value}));
    }
};

@Injectable()
export class UpdateTheme{
    public http:Http;
    constructor(public http:Http) {
        this.http = http;
    }
    updateTheme(id, value){
         this.http.post('/backend/api/protected/host-admin/theme-editor/entity/update/' + id, JSON.stringify({title: value}));
    }
};

@Injectable()
export class DeleteTheme {
    public http:Http;

    constructor(public http:Http) {
        this.http = http;
    }

    deleteTheme(id) {
        this.http.delete('/backend/api/protected/host-admin/theme-editor/entity/delete/' + id);
    }
};