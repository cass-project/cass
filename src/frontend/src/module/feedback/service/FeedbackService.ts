import {Injectable} from "angular2/core";
import {Observable} from "rxjs/Rx";

import {FeedbackRESTService} from "./FeedbackRESTService";
import {FeedbackCreateRequest, FeedbackCreateResponse200} from "../definitions/paths/create";

@Injectable()
export class FeedbackService
{
    constructor(private rest: FeedbackRESTService) {}

    public create(request: FeedbackCreateRequest) : Observable<FeedbackCreateResponse200>
    {
        return Observable.create(observer => {
            this.rest.create(request).map(data => data.json()).subscribe(
                data => {
                    observer.next(data);
                    observer.complete();
                },
                error => {
                    observer.error(error);
                }
            )
        })
    }
}