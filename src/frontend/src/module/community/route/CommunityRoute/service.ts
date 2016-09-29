import {Injectable} from "@angular/core";

import {CollectionEntity} from "../../../collection/definitions/entity/collection";
import {GetCommunityBySIDResponse200} from "../../definitions/paths/get-by-sid";
import {CommunityEntity} from "../../definitions/entity/Community";
import {CommunityExtendedEntity} from "../../definitions/entity/CommunityExtended";

@Injectable()
export class CommunityRouteService
{
    private response: GetCommunityBySIDResponse200;

    public exportResponse(response: GetCommunityBySIDResponse200) {
        this.response = response;
    }

    public getResponse(): GetCommunityBySIDResponse200 {
        if(! this.response) {
            throw new Error('No response available');
        }

        return this.response;
    }

    public getCommunity(): CommunityEntity {
        return this.getResponse().entity.community;
    }

    public getCollections(): CollectionEntity[] {
        return this.getResponse().entity.collections;
    }

    public getEntity(): CommunityExtendedEntity {
        return this.getResponse().entity;
    }

    public isOwnCommunity(): boolean {
        return this.getResponse().entity.is_own;
    }
}