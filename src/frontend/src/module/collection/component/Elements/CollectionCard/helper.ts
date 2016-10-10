import {Injectable} from "@angular/core";
import {CollectionEntity} from "../../../definitions/entity/collection";
import {QueryTarget, queryImage} from "../../../../avatar/functions/query";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {CollectionService} from "../../../service/CollectionService";

@Injectable()
export class CollectionCardHelper
{
    private collection: CollectionEntity;

    constructor(
        private theme: ThemeService,
        private service: CollectionService
    ) {}

    setCollection(collection: CollectionEntity) {
        console.log('ng changes', collection);
        this.collection = collection;
    }

    getImageURL(): string {
        let image = queryImage(QueryTarget.Card, this.collection.image).public_path;

        return `url('${image}')`;
    }

    hasTheme(): boolean {
        return this.collection.theme_ids.length > 0;
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