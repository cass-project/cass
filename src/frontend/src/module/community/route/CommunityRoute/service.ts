import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";

import {CommunityExtendedEntity} from "../../definitions/entity/Community";
import {GetCommunityBySIDResponse200} from "../../definitions/paths/get-by-sid";
import {CommunityRESTService} from "../../service/CommunityRESTService";
import {CommunityModals} from "../../modals";

@Injectable()
export class  CommunityRouteService
{
    private request: string;

    private community: CommunityExtendedEntity;
    private loading: boolean = false;
    private observable: Observable<GetCommunityBySIDResponse200>;

    constructor(
        private api: CommunityRESTService,
        public modals: CommunityModals
    ) {}

    public getCommunity(): CommunityExtendedEntity {
        if(!this.community) {
            throw new Error('Community is not loaded');
        }

        return this.community;
    }
    
    public isCommunityLoaded(): boolean {
        return typeof this.community == "object";
    }
    
    public isLoading(): boolean {
        return this.loading;
    }
    
    public getObservable(): Observable<GetCommunityBySIDResponse200> {
        return this.observable;
    }

    public getCommunityRouteComponents() {
        return ['/', 'Community', { 'sid': this.request }];
    }

    public loadCommunityBySID(sid: string) {
        this.request = sid;

        this.loadCommunity(<any>this.api.getCommunityBySid(sid));
    }
    
    private loadCommunity(observable: Observable<GetCommunityBySIDResponse200>) {
        this.community = undefined;
        this.loading = true;
        this.observable = observable;
        this.observable.subscribe(
            (response: GetCommunityBySIDResponse200) => {
                this.community = response.entity;
                this.loading = false;
            },
            (error) => {
                this.loading = false;
            }
        )
    }

    public getCommunityObservable() {
        return this.observable;
    }
}