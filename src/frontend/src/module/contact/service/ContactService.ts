import {Injectable} from "angular2/core";

import {ContactRESTService} from "./ContactRESTService";
import {Observable, Observer} from "rxjs/Rx";
import {ContactListResponse200} from "../definitions/path/contact-list";
import {AuthService} from "../../auth/service/AuthService";


@Injectable()
export class ContactService
{
    public listContactsCache:ContactListResponse200;
    constructor(
        private rest:ContactRESTService,
        private authService:AuthService
    ){}


    listContacts(nocache?:boolean) : Observable<ContactListResponse200> 
    {
        return Observable.create((observer: Observer<ContactListResponse200>) => {

            if(!this.authService.isSignedIn()){
                throw new Error("You are not signed in");
            }
            
            if(this.listContactsCache===undefined || nocache) {
                let profileId:number = this.authService.getCurrentAccount().getCurrentProfile().getId();
                
                this.rest.listContacts(profileId).subscribe(
                    data => {
                        this.listContactsCache = data;
                        observer.next(data);
                        observer.complete();
                    }
                )
            } else {
                observer.next(this.listContactsCache);
                observer.complete();
            }
        });
    }
}