import {Injectable} from "@angular/core";
import {Http, Headers} from "@angular/http";
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";

@Injectable()
export class ThemeRESTService extends AbstractRESTService
{
    constructor(protected http:Http,
                protected token:AuthToken,
                protected messages:MessageBusService) {
        super(http, token, messages);
    }

    getThemeTree() {
        let authHeader = new Headers();
        if(this.token.isAvailable()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.get(`/backend/api/theme/get/tree`, {headers: authHeader}));
    }

    getThemeList() {
        let authHeader = new Headers();
        if(this.token.isAvailable()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.get(`/backend/api/theme/get/list-all`, {headers: authHeader}));
    }

    getTheme(themeId:number) {
        let authHeader = new Headers();
        if(this.token.isAvailable()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.get(`/backend/api/theme/${themeId}/get`, {headers: authHeader}));
    }

    updateTheme(themeId:number, title:string, description:string) {
        let authHeader = new Headers();
        if(this.token.isAvailable()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.post(`/backend/apiPOST /protected/theme/${themeId}/update`, JSON.stringify({
            title: title,
            description: description
        }), {headers: authHeader}))
    }

    moveTheme(themeId:number, parentThemeId:number, position:number) {
        let authHeader = new Headers();
        if(this.token.isAvailable()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.post(`/backend/api/protected/theme/${themeId}/move/under/${parentThemeId}/in-position/${position}`, '', {headers: authHeader}))
    }

    createTheme(parent_id:number, title:string, description:string) {
        let authHeader = new Headers();
        if(this.token.isAvailable()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.put(`/backend/api/protected/theme/create`, JSON.stringify({
            parent_id: parent_id,
            title: title,
            description: description
        }), {headers: authHeader}));
    }

    deleteTheme(themeId:number) {
        let authHeader = new Headers();
        if(this.token.isAvailable()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.delete(`/backend/api/protected/theme/${themeId}/delete`, {headers: authHeader}));
    }

}