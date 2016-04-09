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

    greetingsAsFL(profileId ,firsname, lastname){
        return this.http.post('backend/api/protected/profile/' + profileId + '/greetings-as/fl/', JSON.stringify({first_name: firsname, last_name: lastname}));
    }

    greetingsAsFLM(profileId ,firstname, lastname, midlename){
        return this.http.post('backend/api/protected/profile/' + profileId + '/greetings-as/lfm/', JSON.stringify({last_name : lastname, first_name: firstname, middle_name: midlename}));
    }

    greetingsAsN(profileId, nick){
        return this.http.post('backend/api/protected/profile/' + profileId + '/greetings-as/n/', JSON.stringify({nickname: nick}));
    }
}