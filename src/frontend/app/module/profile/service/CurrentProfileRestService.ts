import {ResponseInterface} from '../../../module/common/ResponseInterface.ts';
import {Http, Response} from 'angular2/http';
import {Observable} from 'rxjs/Observable';
import {Injectable} from 'angular2/core';
import {URLSearchParams} from 'angular2/http';
import {Headers} from "angular2/http";
import {RequestOptions} from "angular2/http";


@Injectable()
export class CurrentProfileRestService{
    constructor(public http:Http) {}

    getProfileInfo(login, pass){
        return this.http.post('backend/api/auth/sign-in/', JSON.stringify({email: login, password: pass}));
    }
}