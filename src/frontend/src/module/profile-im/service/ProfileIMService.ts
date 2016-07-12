import {Injectable} from "angular2/core";
import {ProfileIMRESTService} from "./ProfileIMRESTService";
import {Observable} from "rxjs/Rx";
import {UnreadProfileMessagesResponse200} from "../definitions/paths/unread";

@Injectable()
export class ProfileIMService 
{
    constructor(private rest:ProfileIMRESTService) {}

    getUnreadMessages() : Observable<UnreadProfileMessagesResponse200> 
    {
        return Observable.create(observer => {
            this.rest.getUnreadMessages().subscribe(
                data => {
                    observer.next(data);
                    observer.complete();
                },
                error => {
                    observer.error(error);
                }
            );
        });
    }
}
