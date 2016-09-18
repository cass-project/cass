import {Injectable} from "@angular/core";

import {RESTService} from "../../common/service/RESTService";
import {Observable} from "rxjs/Rx";
import {ListTreeResponse200} from "../definitions/paths/list-tree";
import {ListAllThemesResponse200} from "../definitions/paths/list-all";
import {GetThemeResponse200} from "../definitions/paths/get";
import {UpdateThemeRequest, UpdateThemeResponse200} from "../definitions/paths/update";
import {MoveThemeRequest, MoveThemeResponse200} from "../definitions/paths/move";
import {CreateThemeRequest, CreateThemeResponse200} from "../definitions/paths/create";
import {DeleteThemeResponse200} from "../definitions/paths/delete";

export interface ThemeRESTServiceInterface
{
    getThemeTree(): Observable<ListTreeResponse200>;
    getThemeList(): Observable<ListAllThemesResponse200>;
    getTheme(themeId:number): Observable<GetThemeResponse200>;
    updateTheme(themeId:number, request: UpdateThemeRequest): Observable<UpdateThemeResponse200>;
    moveTheme(themeId:number, request: MoveThemeRequest): Observable<MoveThemeResponse200>;
    createTheme(request: CreateThemeRequest): Observable<CreateThemeResponse200>;
    deleteTheme(themeId:number): Observable<DeleteThemeResponse200>;
}

@Injectable()
export class ThemeRESTService implements ThemeRESTServiceInterface
{
    constructor(
        private rest: RESTService
    ) {}

    getThemeTree(): Observable<ListTreeResponse200> {
        return this.rest.get(`/backend/api/theme/get/tree`);
    }

    getThemeList(): Observable<ListAllThemesResponse200> {
        return this.rest.get(`/backend/api/theme/get/list-all`);
    }

    getTheme(themeId:number): Observable<GetThemeResponse200> {
        return this.rest.get(`/backend/api/theme/${themeId}/get`);
    }

    updateTheme(themeId:number, request: UpdateThemeRequest): Observable<UpdateThemeResponse200> {
        return this.rest.post(`/backend/apiPOST /protected/theme/${themeId}/update`, request);
    }

    moveTheme(themeId:number, request: MoveThemeRequest): Observable<MoveThemeResponse200> {
        return this.rest.post(`/backend/api/protected/theme/${themeId}/move/under/${request.parent_theme_id}/in-position/${request.position}`, {});
    }

    createTheme(request: CreateThemeRequest): Observable<CreateThemeResponse200> {
        return this.rest.put(`/backend/api/protected/theme/create`, request);
    }

    deleteTheme(themeId:number): Observable<DeleteThemeResponse200> {
        return this.rest.delete(`/backend/api/protected/theme/${themeId}/delete`);
    }
}