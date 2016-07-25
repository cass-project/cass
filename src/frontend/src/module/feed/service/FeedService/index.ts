import {Injectable} from "angular2/core";
import {Subscription} from "rxjs/Subscription";

import {Source} from "./source";
import {Stream} from "./stream";
import {LoadingManager} from "../../../common/classes/LoadingStatus";
import {FeedRequest} from "../../definitions/request/FeedRequest";
import {FeedCriteriaService} from "../FeedCriteriaService";
import {FeedOptionsService} from "../FeedOptionsService";
import {AppService} from "../../../../app/frontend-app/service";

@Injectable()
export class FeedService<T>
{
    static DEFAULT_PAGE_SIZE = 30;

    private status: LoadingManager = new LoadingManager();
    private subscription: Subscription;

    public stream: Stream<T>;
    public source: Source;
    
    constructor(
        private criteria: FeedCriteriaService,
        private options: FeedOptionsService,
        private appService: AppService
    ) {}

    public provide(source: Source, stream: Stream<T>) {
        this.source = source;
        this.stream = stream;
    }

    public isLoading(): boolean {
        this.appService.feedIsLoading = this.status.isLoading();
        return this.status.isLoading();
    }

    isNothingFound(): boolean {
        return !this.isLoading() && (this.stream.size() === 0);
    }

    private createFeedRequest(): FeedRequest {
        return {
            criteria: this.criteria.createFeedCriteriaRequest()
        };
    };

    public update() {
        this.stream.empty();

        let status = this.status.addLoading();

        if(this.subscription) {
            this.subscription.unsubscribe();
        }
        
        this.subscription = this.source.fetch(this.createFeedRequest()).subscribe(
            (response) => {
                this.stream.replace(<any>response.entities);
                status.is = false;
            },
            (error) => {
                status.is = false;
            }
        )
    }

    public next() {
        let status = this.status.addLoading();

        if(this.subscription) {
            this.subscription.unsubscribe();
        }

        this.subscription = this.source.fetch(this.createFeedRequest()).subscribe(
            (response) => {
                this.stream.push(<any>response.entities);
                status.is = false;
            },
            (error) => {
                status.is = false;
            }
        )
    }
}
