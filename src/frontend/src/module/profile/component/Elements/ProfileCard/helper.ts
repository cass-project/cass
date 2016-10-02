import {Injectable} from "@angular/core";

import {ProfileEntity} from "../../../definitions/entity/Profile";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {Theme} from "../../../../theme/definitions/entity/Theme";
import {ProfileThemeListMode} from "./index";
import {ThemeService} from "../../../../theme/service/ThemeService";
import {TranslationService} from "../../../../i18n/service/TranslationService";
import moment = require("moment");

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
            this.themes = this.themeService.getThemesNoFault(profile.expert_in_ids);
        }else if(themesMode === ProfileThemeListMode.InterestingIn) {
            this.themes = this.themeService.getThemesNoFault(profile.interesting_in_ids);
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

    getDescription(): string {
        return this.themesMode === ProfileThemeListMode.ExpertIn
            ? this.getExpertInDescription()
            : this.getInterestingInDescription();
    }

    hasInterests(): boolean {
        return this.profile.interesting_in_ids.length > 0;
    }

    hasExpertsIn(): boolean {
        return this.profile.expert_in_ids.length > 0;
    }

    getExpertInDescription(): string {
        let themes = this.themeService.getThemesNoFault(this.profile.expert_in_ids);

        if(themes.length) {
            return themes.map(theme => theme.title).join(', ');
        }else{
            return '';
        }
    }

    getInterestingInDescription(): string {
        let themes = this.themeService.getThemesNoFault(this.profile.interesting_in_ids);

        if(themes.length) {
            return themes.map(theme => theme.title).join(', ');
        }else{
            return '';
        }
    }

    getRegistrationDate(): string {
        return moment(new Date(this.profile.date_created_on)).format();
    }
}