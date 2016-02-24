import {Injectable} from 'angular2/core';
import {Http, RequestOptions} from 'angular2/http';

@Injectable()
export class GetThemes {
    themes;
    data;
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
    public http:Http;
    constructor(public http:Http) {
        this.http = http;
    }
    putTheme(value){
        this.http.put('/backend/api/protected/host-admin/theme-editor/entity/create', JSON.stringify({title: value}))
    }
};

@Injectable()
export class UpdateTheme{
    public http:Http;
    constructor(public http:Http) {
        this.http = http;
    }
    updateTheme(id, value){
         this.http.post('/backend/api/protected/host-admin/theme-editor/entity/update/' + id, JSON.stringify({title: value}))
    }
};

@Injectable()
export class DeleteTheme{

};