import {Injectable} from "angular2/core";
import {Response} from "angular2/http";
import {Observable} from "rxjs/Observable";

import {CommunityRESTService} from "./CommunityRESTService";
import {CommunityCreateResponseModel} from "../model/CommunityCreateResponseModel";
import {CommunityEntity} from "../definitions/entity/Community";
import {CommunityImageUploadRequestModel} from "../model/CommunityImageUploadRequestModel";
import {CommunityControlFeatureRequestModel} from "../model/CommunityActivateFeatureModel";
import {CommunityImageDeleteRequest} from "../definitions/paths/image-delete";
import {SetPublicOptionsCommunityRequest} from "../definitions/paths/set-public-options";
import {EditCommunityRequest} from "../definitions/paths/edit";


@Injectable()
export class CommunityService {
    public community:CommunityEntity;
    public communityResponsesCache:CommunityCreateResponseModel[] = [];
    public isAdmin:boolean = false;

    constructor(private communityRESTService:CommunityRESTService) {}

    public getBySid(sid:string) : Observable<CommunityCreateResponseModel>
    {
        return Observable.create(observer => {
            if(this.isCached(sid)) {
                let communityResponse: CommunityCreateResponseModel  = this.getFromCache(sid);
                this.isAdmin = communityResponse.access.admin;
                this.community = JSON.parse(JSON.stringify(communityResponse.entity));
                observer.next(communityResponse);
                observer.complete();
            } else {
                this.communityRESTService.getCommunityBySid(sid)
                    .subscribe(
                        communityResponse => {
                            this.communityResponsesCache.push(JSON.parse(JSON.stringify(communityResponse)));
                            this.isAdmin = communityResponse.entity.is_own;
                            this.community = communityResponse.entity.community;
                            observer.next(communityResponse);
                            observer.complete();
                        },
                        error => {observer.error(error);}
                    );
            }
        });
    }

    public edit(id:number, body: EditCommunityRequest): Observable<Response>
    {
        return this.communityRESTService.edit(id, body);
    }

    public imageUpload(request:CommunityImageUploadRequestModel): Observable<Response>
    {
        return this.communityRESTService.imageUpload(request);
    }

    isCached(sid:string)
    {
        return this.communityResponsesCache.filter((input) => {
            return input.entity.sid === sid;
        }).length > 0;
    }

    getFromCache(sid:string) : CommunityCreateResponseModel
    {
        if(!this.isCached(sid)) {
            throw new Error(`Community '${sid}' not cached yet.`);
        }

        return this.communityResponsesCache.filter(
            (input) => { return input.entity.sid === sid; }
        )[0];
    }

    public imageDelete(request:CommunityImageDeleteRequest): Observable<Response>
    {
        return this.communityRESTService.imageDelete(request);
    }

    public activateFeature(reqeust: CommunityControlFeatureRequestModel) : Observable<Response>
    {
        return this.communityRESTService.activateFeature(reqeust);
    };

    public deactivateFeature(reqeust: CommunityControlFeatureRequestModel)
    {
        return this.communityRESTService.deactivateFeature(reqeust);
    };

    public setPublicOptions(communityId:number, body: SetPublicOptionsCommunityRequest): Observable<Response>
    {
        return this.communityRESTService.setPublicOptions(communityId, body);
    }
}