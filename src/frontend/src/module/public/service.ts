import {Injectable} from "angular2/core";
import {CriteriaManager} from "../feed/service/FeedService/criteria";
import {FeedService} from "../feed/service/FeedService/index";

@Injectable()
export class PublicService
{
    static DEFAULT_PAGE_SIZE = 30;

    public source: string;
    public criteria: CriteriaManager;
    
    private feedService: FeedService<any>;

    constructor() {
        this.criteria = new CriteriaManager();
        this.criteria.attach({
            code: 'sort',
            params: {
                'field': '_id',
                'order': 'desc'
            }
        });

        this.criteria.attach({
            code: 'seek',
            params: {
                'limit': PublicService.DEFAULT_PAGE_SIZE
            }
        });
    }
    
    public injectFeedService(service: FeedService<any>) {
        this.feedService = service;
    }
    
    public update() {
        if(this.feedService !== undefined) {
            this.feedService.update();
        }
    }
}