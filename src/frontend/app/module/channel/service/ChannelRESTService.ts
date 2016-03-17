import {Http, Headers, RequestOptions, RequestOptionsArgs} from 'angular2/http';
import {Injectable} from 'angular2/core';

@Injectable()
export class ChannelRESTService
{
    private API_PATH           = "/backend/api";
    private API_PATH_PROTECTED = "/backend/api/protected";

    constructor(public http:Http) {
    }

    public addChannel(data) {
        return this.put('/channel/create', JSON.stringify(data));
    }

    private get(uri:string, options?: RequestOptionsArgs) {
        return this.http.get(this.API_PATH_PROTECTED + uri, options||null).map(res => res.json());
    }

    private post(uri:string, body:string, options?: RequestOptionsArgs) {
        return this.http.post(this.API_PATH_PROTECTED + uri, body, options||null).map(res => res.json());
    }

    private put(uri:string, body:string, options?: RequestOptionsArgs) {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        let options = options||new RequestOptions({headers: headers});
        return this.http.put(this.API_PATH_PROTECTED + uri, body, options||null).map(res => res.json());
    }
}