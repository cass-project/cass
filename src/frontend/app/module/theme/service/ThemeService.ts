import {Injectable} from 'angular2/core';
import {Http, URLSearchParams} from 'angular2/http';
import {FrontlineService} from "../../frontline/service";

@Injectable()
export class ThemeService
{
    constructor(public http: Http){}

    getThemeListAll(){
        let url = 'backend/api/theme/get/list-all';

        return this.http.get(url);
    }

    getThemeTreeList(){
        let url = 'backend/api/theme/get/tree';

        return this.http.get(url);
    }

    getThemeById(themeId){
        let url = `backend/api/theme/${themeId}/get`;

        return this.http.get(url);
    }

}

