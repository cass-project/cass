import {BaseRequestOptions} from "angular2/http";
import {AuthService} from "./service/AuthService";

export class AuthRequestOptions extends BaseRequestOptions {
    constructor () {
        super();

        this.headers.append('Content-type', 'application/json');

        let token = AuthService.token;

        if(token) {
            console.log('Do you even try?', token.apiKey);
            this.headers.set('X-Api-Key', token.apiKey);
        }
    }
}