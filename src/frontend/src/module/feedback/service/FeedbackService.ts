import {Injectable} from "angular2/core";
import {Observable} from "rxjs/Rx";

import {FeedbackRESTService} from "./FeedbackRESTService";
import {FeedbackCreateRequest, FeedbackCreateResponse200} from "../definitions/paths/create";
import {ListFeedbackResponse200, ListFeedbackQueryParams} from "../definitions/paths/list";
import {FeedbackCreateResponseRequest} from "../definitions/paths/create-response";

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

    public list(offset:number,limit:number, qp?: ListFeedbackQueryParams) : Observable<ListFeedbackResponse200>
    {
        return Observable.create(observer => {
            this.rest.listFeedbackEntities(offset, limit, qp||{}).map(data => data.json()).subscribe(
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
    
    public response(request: FeedbackCreateResponseRequest) {
        return Observable.create(observer => {
            this.rest.createResponse(request).map(data => data.json()).subscribe(
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