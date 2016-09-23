import {Injectable} from "@angular/core";

import {GetProfileByIdResponse200} from "../../definitions/paths/get-by-id";
import {ProfileEntity, ProfileExtendedEntity} from "../../definitions/entity/Profile";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";

@Injectable()
export class ProfileRouteService
{
    private response: GetProfileByIdResponse200;

    public exportResponse(response: GetProfileByIdResponse200) {
        this.response = response;
    }

    public getResponse(): GetProfileByIdResponse200 {
        if(! this.response) {
            throw new Error('No response available');
        }

        return this.response;
    }

    public getProfile(): ProfileEntity {
        return this.getResponse().entity.profile;
    }

    public getCollections(): CollectionEntity[] {
        return this.getResponse().entity.collections;
    }

    public getEntity(): ProfileExtendedEntity {
        return this.getResponse().entity;
    }

    public isOwnProfile(): boolean {
        return this.getResponse().entity.is_own;
    }
}