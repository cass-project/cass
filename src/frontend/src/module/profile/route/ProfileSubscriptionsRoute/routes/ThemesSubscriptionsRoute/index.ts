import {Component} from "@angular/core";
import {Theme} from "../../../../../theme/definitions/entity/Theme";
import {SubscriptionEntity} from "../../../../../subscribe/definitions/entity/Subscription";
import {ListSubscribeThemesRequest} from "../../../../../subscribe/definitions/paths/list-themes";
import {SubscribeRESTService} from "../../../../../subscribe/service/SubscribeRESTService";
import {ThemeService} from "../../../../../theme/service/ThemeService";
import {LoadingManager} from "../../../../../common/classes/LoadingStatus";
import {ViewOptionValue} from "../../../../../feed/service/FeedService/options/ViewOption";
import {ViewOptionService} from "../../../../../public/component/Options/ViewOption/service";
import {Router} from "@angular/router";


@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ThemesSubscriptionsRoute
{
    private status: LoadingManager = new LoadingManager();
    private theme:  Theme;
    private subscribes: SubscriptionEntity<Theme>[];
    private request: ListSubscribeThemesRequest = {
        limit: 50,
        offset: 0
    };

    constructor(
        private subscribe: SubscribeRESTService,
        private service: ThemeService,
        private viewOptions: ViewOptionService,
        private router: Router,
    ) {}

    ngOnInit() {

        this.theme = this.service.getRoot();

        let loading = this.status.addLoading();

        this.subscribe.listTheme(this.theme.id, this.request).subscribe(
            response => {
                this.subscribes = response.subscribes;

                loading.is = false;
            },

            error => {
                loading.is = false;
            }
        )
    }

    getThemes() {
        return this.subscribes.map(subscription => subscription.entity);
    }

    openCommunity(theme: Theme) {
        this.router.navigate(['/profile/current/personal/themes']);
    }

    getViewMode(): ViewOptionValue {
        return this.viewOptions.option.current;
    }
}