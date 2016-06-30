import {Injectable} from "angular2/core";
import {FeedbackRESTService} from "./FeedbackRESTService";
import {Observable} from "rxjs/Rx";
import {CreateFeedbackRequest, CreateCommunityResponse404, CreateCommunityResponse200} from "../definitions/paths/create";

@Injectable()
export class FeedbackService
{
    constructor(private rest: FeedbackRESTService) {}

    public create(request: CreateFeedbackRequest) : Observable<CreateCommunityResponse200>
    {
        return Observable.create(observer => {
            this.rest.create(request).map(data => data.json()).subscribe(
                data => {
                    observer.next(data);
                    observer.complete();
                },
                error =>{
                    observer.error(error);
                }
            )
        })
    }
}
