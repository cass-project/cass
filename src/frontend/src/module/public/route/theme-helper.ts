import {Injectable} from "@angular/core";

import {Theme} from "../../theme/definitions/entity/Theme";
import {FeedCriteriaService} from "../../feed/service/FeedCriteriaService";
import {ThemeService} from "../../theme/service/ThemeService";
import {SwipeService} from "../../swipe/service/SwipeService";
import {FeedService} from "../../feed/service/FeedService/index";

@Injectable()
export class PublicThemeHelper
{
    constructor(
        private theme: ThemeService,
        private criteria: FeedCriteriaService,
        private swipe: SwipeService,
        private service: FeedService<any>,
    ) {}

    getThemeRoot(): Theme {
        let criteria = this.criteria.criteria.theme;

        if(criteria.enabled) {
            return this.theme.findById(criteria.params.id);
        }else{
            return this.theme.getRoot();
        }
    }

    getThemePanelRoot(): Theme {
        let criteria = this.criteria.criteria.theme;

        if(criteria.enabled) {
            let current = this.theme.findById(criteria.params.id);

            if(current.children !== undefined && current.children.length > 0) {
                return current;
            }else if(current.parent_id){
                return this.theme.findById(current.parent_id);
            }else{
                return this.theme.getRoot();
            }
        }else{
            return this.theme.getRoot();
        }
    }

    goTheme(theme: Theme) {
        let criteria = this.criteria.criteria.theme;

        criteria.enabled = true;
        criteria.params.id = theme.id;

        if(theme.children.length === 0) {
            this.swipe.switchToContent();
        }

        this.service.update();
    }
}