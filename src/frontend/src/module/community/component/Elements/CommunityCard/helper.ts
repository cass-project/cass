import {Injectable} from "@angular/core";

import {ThemeService} from "../../../../theme/service/ThemeService";
import {CommunityEntity} from "../../../definitions/entity/Community";
import {QueryTarget, queryImage} from "../../../../avatar/functions/query";
import {CommunityService} from "../../../service/CommunityService";
import {Theme} from "../../../../theme/definitions/entity/Theme";

@Injectable()
export class CommunityCardHelper
{
    private community:CommunityEntity;
    
    constructor(
        private theme: ThemeService,
        private service: CommunityService
    ) {}

    setCommunity(community: CommunityEntity) {
        this.community = community;
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

    getThemeTitle() : string {
        if(this.hasTheme()) {
            return this.theme.findById(this.community.theme.id).title;
        }else{
            return 'N/A';
        }
    }

    getRouterParams() {
        return this.service.getRouterParams(this.community);
    }    
}