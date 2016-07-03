import {CollectionEntity} from "../../collection/definitions/entity/collection";

export class ProfileCollectionsService
{
    private entities: CollectionEntity[] = [];

    public setEntities(entities: CollectionEntity[]) {
        this.entities = entities;
    }

    public getEntities(): CollectionEntity[] {
        return this.entities;
    }
}