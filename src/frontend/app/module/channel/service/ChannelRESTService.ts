import {Http, Headers, RequestOptions, RequestOptionsArgs} from 'angular2/http';
import {Injectable} from 'angular2/core';

@Injectable()
export class ChannelRESTService
{
    private API_PATH           = "/backend/api";
    private API_PATH_PROTECTED = "/backend/api/protected";

    constructor(public http:Http) {
    }

    public addChannel(name: string, themeId: number){
        if (name && themeId) {
            let headers = new Headers();

            headers.append('Content-Type', 'application/json');

            let options = new RequestOptions({headers: headers});
            let body = JSON.stringify({
                    name: name,
                    theme_id: themeId
                });
            //this.http.put(this.API_PATH_PROTECTED + '/channel/add', body, options).map(res=>res.json())
            this.put('/channel/add', body, options).subscribe(
                success => console.log,
                error => {
                    console.log(error.json());
                }
            );
        } else {
            alert("Some required fields are blank.")
        }
    }

    private get(uri:string, options?: RequestOptionsArgs) {
        return this.http.get(this.API_PATH_PROTECTED + uri, options||null).map(res => res.json());
    }

    private post(uri:string, body: string, options?: RequestOptionsArgs) {
        return this.http.post(this.API_PATH_PROTECTED + uri, body, options||null).map(res => res.json());
    }

    private put(uri:string, body: string, options?: RequestOptionsArgs) {
        return this.http.put(this.API_PATH_PROTECTED + uri, body, options||null).map(res => res.json());
    }
}