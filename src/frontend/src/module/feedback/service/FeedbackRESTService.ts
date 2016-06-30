import {Injectable} from "angular2/core";
import {Http, Response} from "angular2/http";
import {CreateFeedbackRequest} from "../definitions/paths/create";
import {Observable} from "rxjs/Rx";


@Injectable()
export class FeedbackRESTService
{
    constructor(private http: Http) {}
    
    public create(request: CreateFeedbackRequest) : Observable<Response>
    {
        return this.http.put("/backend/api/feedback/create", JSON.stringify(request));
    }

}
