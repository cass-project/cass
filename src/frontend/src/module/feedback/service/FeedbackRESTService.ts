import {Injectable} from "angular2/core";
import {Http, Response} from "angular2/http";
import {Observable} from "rxjs/Rx";

import {FeedbackCreateRequest} from "../definitions/paths/create";

@Injectable()
export class FeedbackRESTService
{
    constructor(private http: Http) {}
    
    public create(request: FeedbackCreateRequest) : Observable<Response>
    {
        return this.http.put("/backend/api/feedback/create", JSON.stringify(request));
    }
}
