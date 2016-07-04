import {Injectable} from "angular2/core";
import {Http, Response, Headers, URLSearchParams} from "angular2/http";
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

        return this.handle(this.http.put("/backend/api/feedback-response/create", JSON.stringify(request), {headers: authHeader}));
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

    public listFeedbackEntities(offset: number, limit: number, qp: ListFeedbackQueryParams) {
        let params = new URLSearchParams();
        let authHeader = new Headers();

        if (this.token.hasToken()) {
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        if (qp.profileId !== undefined) params.set('profileId', qp.profileId.toString());
        if (qp.read !== undefined) params.set('read', String(qp.read));
        if (qp.answer !== undefined) params.set('answer', String(qp.answer));

        return this.handle(this.http.get(`/backend/api/protected/feedback/list/offset/${offset}/limit/${limit}`, {
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
