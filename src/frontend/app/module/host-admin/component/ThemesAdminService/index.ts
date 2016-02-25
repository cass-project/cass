import {Injectable} from 'angular2/core';
import {Http, RequestOptions} from 'angular2/http';
import {Headers} from "angular2/http";


@Injectable()
export class ManageThemes {
    themes;
    public http:Http;
    active: boolean = true;
    show: boolean = false;
   public clicked(){
        this.show = !this.show;
    }
    constructor(public http:Http) {
        this.http = http;
    }

    public loadThemes() {
        return this.http.get('/backend/api/protected/host-admin/theme-editor/read/entities/')
            .map(res => res.json())
            .subscribe(data => this.themes = data.entities);
    }
      putTheme(value){
        var headers = new Headers();
        headers.append('Content-type', 'application/json');
        var options = new RequestOptions({
            headers: headers
        });
          return this.http.put('/backend/api/protected/host-admin/theme-editor/entity/create', JSON.stringify({title: value}), options).subscribe(
            data =>{console.log(data); this.loadThemes();},
            err => {console.log(err);}
        );
    }

    updateTheme(id, value){
        var headers = new Headers();
        headers.append('Content-type', 'application/json');
        var options = new RequestOptions({
            headers: headers
        });
        this.http.post('/backend/api/protected/host-admin/theme-editor/entity/update/' + id, JSON.stringify({title: value}), options).subscribe(
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
};