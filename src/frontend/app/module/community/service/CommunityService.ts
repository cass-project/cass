import {Injectable} from "angular2/core";
import {Observable} from "rxjs/Observable";

import {CommunityRESTService} from "./CommunityRESTService";
import {CommunityModel, CommunityResponseModel} from "../model";


@Injectable()
export class CommunityService {
    public community:CommunityModel;
    public communityResponsesCache:CommunityResponseModel[] = [];

    public isAdmin:boolean   = false;

    constructor(private communityRESTService:CommunityRESTService) {}

    public getBySid(sid:string) : Observable<CommunityResponseModel> {
        return Observable.create(observer => {
            if(this.isCached(sid)) {
                let communityResponse: CommunityResponseModel  = this.getFromCache(sid);
                this.isAdmin = communityResponse.access.admin;
                this.community = JSON.parse(JSON.stringify(communityResponse.entity));
                observer.next(communityResponse);
                observer.complete();
            } else {
                this.communityRESTService.getBySid(sid)
                    .map(data => data.json())
                    .subscribe(
                        communityResponse => {
                            this.communityResponsesCache.push(JSON.parse(JSON.stringify(communityResponse)));
                            this.isAdmin = communityResponse.access.admin;
                            this.community = communityResponse.entity;
                            observer.next(communityResponse);
                            observer.complete();
                        }
                    );
            }
        });
    }

    isCached(sid:string) {
        return this.communityResponsesCache.filter((input) => {
            return input.entity.sid === sid;
        }).length > 0;
    }

    getFromCache(sid:string) : CommunityResponseModel {
        if(!this.isCached(sid)){
            throw new Error(`Community '${sid}' not cached yet.`);
        }

        return this.communityResponsesCache.filter(
            (input) => { return input.entity.sid === sid; }
        )[0];
    }
}