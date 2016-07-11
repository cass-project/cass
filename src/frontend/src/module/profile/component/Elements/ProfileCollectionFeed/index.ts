import {Component, Input} from "angular2/core";

import {FeedRESTService} from "../../../../feed/service/FeedRESTService";
import {FeedCriteriaService} from "../../../../feed/service/FeedCriteriaService";
import {PostCard} from "../../../../post/component/Forms/PostCard/index";
import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {FeedEntitiesService} from "../../../route/ProfileCollectionRoute/service";

@Component({
    selector: 'cass-profile-collection-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        PostCard,
        LoadingIndicator,
    ]
})
export class ProfileCollectionFeed
{
    private loading: boolean = false;

    @Input('collection-id') collectionId: string;
    
    constructor(
        private service: FeedRESTService, 
        private criteria: FeedCriteriaService,
        private entities: FeedEntitiesService
    ) {}

    ngOnInit() {
        this.next();
    }

    next() {
        if(this.loading) return;
        
        this.loading = true;
        
        this.service.getCollectionFeed(parseInt(this.collectionId, 10), this.criteria.createFeedRequest()).subscribe(
            (response) => {
                this.entities.push(response.entities);
                this.loading = false;
            },
            (error) => {
                this.loading = false;
            }
        )
    }
}