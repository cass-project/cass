import {Component} from "@angular/core";
import {Theme} from "../../../../../theme/definitions/entity/Theme";
import {SubscriptionEntity} from "../../../../../subscribe/definitions/entity/Subscription";
import {ListSubscribeThemesRequest} from "../../../../../subscribe/definitions/paths/list-themes";
import {SubscribeRESTService} from "../../../../../subscribe/service/SubscribeRESTService";
import {ThemeService} from "../../../../../theme/service/ThemeService";
import {LoadingManager} from "../../../../../common/classes/LoadingStatus";


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

    constructor(private subscribe: SubscribeRESTService,
                private service: ThemeService
    ){}


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

}