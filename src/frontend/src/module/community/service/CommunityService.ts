import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Rx";

import {AuthToken} from "../../auth/service/AuthToken";
import {CommunityRESTService} from "./CommunityRESTService";
import {CommunityExtendedEntity} from "../definitions/entity/CommunityExtended";
import {GetCommunityBySIDResponse200} from "../definitions/paths/get-by-sid";
import {LoadingManager} from "../../common/classes/LoadingStatus";
import {MessageBusService} from "../../message/service/MessageBusService/index";


@Injectable()
export class CommunityService extends CommunityRESTService
{
    public communityResponsesCache: GetCommunityBySIDResponse200[] = [];
    public communityObservable:Observable<GetCommunityBySIDResponse200>;
    public community:CommunityExtendedEntity;
    public loading: LoadingManager = new LoadingManager();
    public communityLoading = this.loading.addLoading();

    constructor(protected http: Http,
                protected token: AuthToken,
                protected messages: MessageBusService,
                protected rest: CommunityRESTService) {
        super(http, token, messages);
    }

    public isCommunityLoaded() : boolean
    {
        return !this.communityLoading.is;
    }
    
    public getCommunityBySid(sid:string) : Observable<GetCommunityBySIDResponse200>
    {
        this.communityObservable = Observable.create(observer => {
            try {
                let communityResponse  = this.tryGetCommunityBySidFromCache(sid);
                this.community = JSON.parse(JSON.stringify(communityResponse.entity));
                observer.next(communityResponse);
                observer.complete();
                this.communityLoading.is = false;
            } catch (error) {
                this.rest.getCommunityBySid(sid).subscribe(
                    communityResponse => {
                        this.communityResponsesCache.push(JSON.parse(JSON.stringify(communityResponse)));
                        this.community = communityResponse.entity;
                        observer.next(communityResponse);
                        observer.complete();
                        this.communityLoading.is = false;
                    },
                    error => observer.error(error)
                );
            }
        });
        return this.communityObservable;
    }

    tryGetCommunityBySidFromCache(sid:string) : GetCommunityBySIDResponse200
    {
        let communityResponseCache = this.communityResponsesCache.filter(
            reponse => { return reponse.entity.community.sid === sid; }
        );
        
        if(communityResponseCache.length > 0) {
            return communityResponseCache[0];
        } else {
            throw new Error(`Community '${sid}' not cached.`);
        }
    }
    
}