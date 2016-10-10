import {Injectable} from "@angular/core";
import {CollectionEntity} from "../../../definitions/entity/collection";
import {QueryTarget, queryImage} from "../../../../avatar/functions/query";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {CollectionService} from "../../../service/CollectionService";
import {Theme} from "../../../../theme/definitions/entity/Theme";

@Injectable()
export class CollectionCardHelper
{
    private collection: CollectionEntity;

    constructor(
        private theme: ThemeService,
        private service: CollectionService
    ) {}

    setCollection(collection: CollectionEntity) {
        this.collection = collection;
    }

    getCollectionName(): string {
        return this.collection.title;
    }

    getImageURL(): string {
        return queryImage(QueryTarget.Card, this.collection.image).public_path;
    }

    hasTheme(): boolean {
        return this.collection.theme_ids.length > 0;
    }

    getThemes(): Theme[] {
        let result = [];

        this.collection.theme_ids.forEach(id => {
            if(this.theme.hasWithId(id)) {
                result.push(this.theme.findById(id));
            }
        });

        return result;
    }

    getThemeTitle(): string {
        if(this.hasTheme()) {
            return this.theme.findById(this.collection.theme_ids[0]).title;
        }else{
            return 'N/A';
        }
    }

    getRouterParams(entity: CollectionEntity) {
        return this.service.getRouterParams(entity);
    }
}