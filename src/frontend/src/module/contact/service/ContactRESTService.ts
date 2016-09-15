import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {AuthToken} from "../../auth/service/AuthToken";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {ContactCreateRequest, ContactCreateResponse200} from "../definitions/path/contact-create";
import {ContactDeleteResponse200} from "../definitions/path/contact-delete";
import {ContactGetResponse200} from "../definitions/path/contact-get";
import {ContactListResponse200} from "../definitions/path/contact-list";
import {ContactSetPermanentResponse200} from "../definitions/path/contact-set-permanent";

@Injectable()
export class ContactRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    public createContact(profileId: number, request: ContactCreateRequest): Observable<ContactCreateResponse200>
    {
        let url = `/backend/api/protected/profile/${profileId}/contact/create`;
        
        return this.handle(
            this.http.put(url, JSON.stringify(request), {
                headers: this.getAuthHeaders()
            })
        );
    }

    public deleteContact(profileId: number, contactId: number): Observable<ContactDeleteResponse200>
    {
        let url = `/backend/api/protected/profile/${profileId}/contact/${contactId}/delete`;

        return this.handle(
            this.http.delete(url, {
                headers: this.getAuthHeaders()
            })
        );
    }

    public getContact(profileId: number, contactId: number): Observable<ContactGetResponse200>
    {
        let url = `/backend/api/protected/profile/${profileId}/contact/${contactId}/get`;

        return this.handle(
            this.http.get(url, {
                headers: this.getAuthHeaders()
            })
        );
    }

    public listContacts(profileId: number): Observable<ContactListResponse200>
    {
        let url = `/backend/api/protected/profile/${profileId}/contact/list`;

        return this.handle(
            this.http.get(url, {
                headers: this.getAuthHeaders()
            })
        );
    }

    public setContactPermanent(profileId: number, contactId: number): Observable<ContactSetPermanentResponse200>
    {
        let url = `/backend/api/protected/profile/${profileId}/contact/${contactId}/get`;
        
        return this.handle(
            this.http.post(url, '', {
                headers: this.getAuthHeaders()
            })
        );
    }
}