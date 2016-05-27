import {Injectable} from "angular2/core";
import {Http} from 'angular2/http';

@Injectable()
export class CommunityRESTService
{
    constructor(private http:Http) {}

    public create(modal) {
        return this.http.put("/backend/api/protected/community/create", JSON.stringify({modal}))
    }
}