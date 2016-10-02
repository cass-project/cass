import {Injectable} from "@angular/core";

import {ProfileEntity} from "../../../definitions/entity/Profile";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {Theme} from "../../../../theme/definitions/entity/Theme";
import {ProfileThemeListMode} from "./index";
import {ThemeService} from "../../../../theme/service/ThemeService";

@Injectable()
export class ProfileCardHelper
{
    public profile: ProfileEntity;

    private themes: Theme[] = [];
    private themesMode: ProfileThemeListMode = ProfileThemeListMode.ExpertIn;

    constructor(
        private themeService: ThemeService
    ) {}

    setProfile(profile: ProfileEntity, themesMode: ProfileThemeListMode) {
        this.profile = profile;
        this.themesMode = themesMode;

        if(themesMode === ProfileThemeListMode.ExpertIn) {
            this.themes = [];

            for(let id of profile.expert_in_ids) {
                if(this.themeService.hasWithId(id)) {
                    this.themes.push(this.themeService.findById(id));
                }
            }
        }else if(themesMode === ProfileThemeListMode.InterestingIn) {
            this.themes = [];

            for(let id of profile.interesting_in_ids) {
                if(this.themeService.hasWithId(id)) {
                    this.themes.push(this.themeService.findById(id));
                }
            }
        }else{
            throw new Error(`Unknown themes mode '${themesMode}'`)
        }
    }

    getProfileName(): string {
        return this.profile.greetings.greetings;
    }

    getProfileImageURL(): string {
        return queryImage(QueryTarget.Card, this.profile.image).public_path;
    }

    hasThemes(): boolean {
        return this.themes.length > 0;
    }

    getThemes(): Theme[] {
        return this.themes;
    }
}