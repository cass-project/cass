import {Injectable} from "@angular/core";
import {Http, Response, Headers, URLSearchParams} from "@angular/http";
import {Observable} from "rxjs/Rx";

import {FeedbackCreateRequest} from "../definitions/paths/create";
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {AuthToken} from "../../auth/service/AuthToken";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {ListFeedbackQueryParams} from "../definitions/paths/list";
import {FeedbackCreateResponseRequest} from "../definitions/paths/create-response";

@Injectable()
export class FeedbackRESTService extends AbstractRESTService {
    constructor(protected http: Http,
                protected token: AuthToken,
                protected messages: MessageBusService) {
        super(http, token, messages)
    }

    public create(request: FeedbackCreateRequest): Observable<Response> {
        let authHeader = new Headers();

        if (this.token.hasToken()) {
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.put("/backend/api/feedback/create", JSON.stringify(request), {headers: authHeader}));
    }

    public createResponse(request: FeedbackCreateResponseRequest ) {
        let authHeader = new Headers();

        if (this.token.hasToken()) {
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.put("/backend/api/protected/feedback-response/create", JSON.stringify(request), {headers: authHeader}));
    }

    public cancel(feedbackId: number) {
        let authHeader = new Headers();

        if (this.token.hasToken()) {
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.delete(`/backend/api/protected/feedback/${feedbackId}/cancel`, {headers: authHeader}));
    }

    public getById(feedbackId: number) {
        let authHeader = new Headers();

        if (this.token.hasToken()) {
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.get(`/backend/api/protected/feedback/${feedbackId}/get`, {headers: authHeader}));
    }

    public listFeedbackEntities(request: ListFeedbackQueryParams) {
        let params = new URLSearchParams();
        let authHeader = new Headers();

        if (this.token.hasToken()) {
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        if (request.profileId !== undefined) params.set('profileId', request.profileId.toString());
        if (request.read !== undefined) params.set('read', String(request.read));
        if (request.answer !== undefined) params.set('answer', String(request.answer));

        return this.handle(this.http.get(`/backend/api/protected/feedback/list/offset/${request.offset}/limit/${request.limit}`, {
            headers: authHeader,
            search: params
        }));
    }

    public markAsRead(feedbackId: number) {
        let authHeader = new Headers();

        if (this.token.hasToken()) {
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.post(`/backend/api/protected/feedback/${feedbackId}/mark-as-read`, '', {headers: authHeader}));
    }
}
