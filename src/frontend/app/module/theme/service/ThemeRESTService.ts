import {ResponseInterface} from '../../main/ResponseInterface.ts';
import {Http, Response} from 'angular2/http';
import {Observable} from 'rxjs/Observable';
import {Injectable} from 'angular2/core';
import {URLSearchParams} from 'angular2/http';
import {Headers} from "angular2/http";
import {RequestOptions} from "angular2/http";
import {ThemeTree, Theme, ThemeHost} from '../Theme';
import {ThemeEditorComponent} from '../../host-admin/component/ThemeEditorComponent/component';

@Injectable()
export class ThemeRESTService
{
    constructor(public http:Http) {}

    public getThemes() {
        return this.http.get('/backend/api/protected/host-admin/theme-editor/read/entities/');
    }

    public getThemesTree() {
        return this.http.get('/backend/api/protected/host-admin/theme-editor/read/entities-tree/');
    }

    public getThemeById(id: number) {
        let params = new URLSearchParams();
        params.set('themeId', id.toString());

        return this.http.get('/backend/api/protected/host-admin/theme-editor/read/entity/{themeId}', {
            search: params
        });
    }

    public createTheme(tittle: string, parentId: number){
           let headers = new Headers();
        headers.append('Content-type', 'application/json');
        let options = new RequestOptions({
            headers: headers
        });
        if(!parentId) parentId = 0;
        return this.http.put('/backend/api/protected/host-admin/theme-editor/entity/create', JSON.stringify({title: tittle, parent_id: parentId}), options).subscribe(
            data => {console.log(data)},
            err => {console.log(err)}
        );
    }

    public updateTheme(id, title, parentId){
        let headers = new Headers();
        headers.append('Content-type', 'application/json');
        let options = new RequestOptions({
            headers: headers
        });
        console.log(parentId);
        if(parentId == undefined || null) parentId = 0;
        this.http.post('/backend/api/protected/host-admin/theme-editor/entity/update/' + id, JSON.stringify({title: title, parent_id: parseInt(parentId)}), options).subscribe(
            data => {console.log(data)},
            err => {console.log(err)});
    }

    public deleteTheme(id) {
        return this.http.delete('/backend/api/protected/host-admin/theme-editor/entity/delete/' + id, {
        }).subscribe(data => {console.log(data)},
        err => {console.log(err)});
    }
}

export interface ReadThemeEntityResponse extends ResponseInterface
{
    entity: Theme;
}

export interface ReadThemeEntitiesResponse extends ResponseInterface
{
    total: number;
    entities: Theme[]
}