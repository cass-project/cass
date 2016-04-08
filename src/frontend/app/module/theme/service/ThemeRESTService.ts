import {ResponseInterface} from '../../../module/common/ResponseInterface.ts';
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

    public preViewLink(link: string){
        let metadata;
        return this.http.post('/backend/api/protected/post/link/parse/', JSON.stringify({url: link}));
    }

    public getThemeById(id: number) {
        return this.http.get('/backend/api/protected/host-admin/theme-editor/read/entity/' + id);
    }

    public createTheme(tittle: string, parentId: number){
        if(!parentId) parentId = 0;
        return this.http.put('/backend/api/protected/host-admin/theme-editor/entity/create', JSON.stringify({title: tittle, parent_id: parentId}));
    }

    public updateTheme(id, title, parentId){
        if(!parentId) parentId = 0;
        return this.http.post('/backend/api/protected/host-admin/theme-editor/entity/update/' + id, JSON.stringify({title: title, parent_id: parseInt(parentId)}));
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