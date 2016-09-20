import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";

import {GetCommunityBySIDResponse200} from "../../definitions/paths/get-by-sid";
import {CommunityExtendedEntity} from "../../definitions/entity/CommunityExtended";
import {ModalControl} from "../../../common/classes/ModalControl";
import {CommunityRESTService} from "../../service/CommunityRESTService";

@Injectable()
export class  CurrentCommunityService
{
    constructor(
        private api: CommunityRESTService,
    ) {}

    private request: string;

    public modals: {
        settings: ModalControl,
        createCollection: ModalControl
    } = {
        settings: new ModalControl(),
        createCollection: new ModalControl()
    };

    private community: CommunityExtendedEntity;
    private loading: boolean = false;
    private observable: Observable<GetCommunityBySIDResponse200>;

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
    
    public getObservable() {
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