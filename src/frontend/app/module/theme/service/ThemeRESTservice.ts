import {Injectable} from "angular2/core";
import {Http, URLSearchParams} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {Account} from "../../account/definitions/entity/Account";
import {MessageBusService} from "../../message/service/MessageBusService/index";

@Injectable()
export class ThemeRESTService extends AbstractRESTService {
    constructor(protected  http:Http, protected messages:MessageBusService) {
        super(http, messages);
    }

    getThemeTree()
    {
        return this.handle(this.http.get(`/backend/api/theme/get/tree`));
    }

    getThemeList()
    {
        return this.handle(this.http.get(`/backend/api/theme/get/list-all`));
    }

    getTheme(themeId: number)
    {
        return this.handle(this.http.get(`/backend/api/theme/${themeId}/get`));
    }

    updateTheme(themeId: number, title: string, description: string){
        return this.handle(this.http.post(`/backend/apiPOST /protected/theme/${themeId}/update`, JSON.stringify({
            title: title,
            description: description
        })))
    }

    moveTheme(themeId: number, parentThemeId: number, position: number){
        return this.handle(this.http.post(`/backend/api/protected/theme/${themeId}/move/under/${parentThemeId}/in-position/${position}`, JSON.stringify({})))
    }

    createTheme(parent_id: number, title: string, description: string)
    {
        return this.handle(this.http.put(`/backend/api/protected/theme/create`, JSON.stringify({
            parent_id: parent_id,
            title: title,
            description: description
        })));
    }

    deleteTheme(themeId: number)
    {
        return this.handle(this.http.delete(`/backend/api/protected/theme/${themeId}/delete`));
    }

}