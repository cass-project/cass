import {Injectable} from "@angular/core";
import {Router} from "@angular/router";

import {ThemeService} from "../../../../theme/service/ThemeService";
import {CommunityEntity} from "../../../definitions/entity/Community";
import {QueryTarget, queryImage} from "../../../../avatar/functions/query";

@Injectable()
export class CommunityCardHelper
{
    private community:CommunityEntity;
    
    constructor(
        private theme: ThemeService,
        private router: Router
    ) {}

    setCommunity(collection: CommunityEntity) {
        this.community = collection;
    }
    
    getTheme() {
        return this.theme.findById(this.community.theme.id);
    }

    getCommunityTitle(): string {
        return this.community.title;
    }

    getCommunityDescription(): string {
        return this.community.description;
    }

    getImageURL(): string {
        return queryImage(QueryTarget.Card, this.community.image).public_path;
    }

    hasTheme() {
        return this.community.theme.has;
    }

    goCommunity() {
        this.router.navigate(['community', this.community.sid]);
    }
}