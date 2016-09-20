import {Injectable} from "@angular/core";
import {Subscription} from "rxjs/Subscription";

import {Source} from "./source";
import {Stream} from "./stream";
import {LoadingManager} from "../../../common/classes/LoadingStatus";
import {FeedRequest} from "../../definitions/request/FeedRequest";
import {FeedCriteriaService} from "../FeedCriteriaService";
import {FeedEntity} from "./entity";

@Injectable()
export class FeedService<T extends FeedEntity>
{
    static DEFAULT_PAGE_SIZE = 30;
    
    public shouldLoad: boolean = true;

    private status: LoadingManager = new LoadingManager();
    private subscription: Subscription;

    public stream: Stream<T>;
    public source: Source;
    
    constructor(
        private criteria: FeedCriteriaService
    ) {}

    public provide(source: Source, stream: Stream<T>) {
        this.source = source;
        this.stream = stream;
    }

    public isLoading(): boolean {
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
        delete this.criteria.criteria.seek.params.last_id;

        let limit = this.criteria.criteria.seek.params.limit - 1;
        let status = this.status.addLoading();

        if(this.subscription) {
            this.subscription.unsubscribe();
        }

        this.subscription = this.source.fetch(this.createFeedRequest()).subscribe(
            (response) => {
                if(response.entities.length > limit){
                    response.entities.splice(limit, 1);
                    this.shouldLoad = true;
                } else {
                    this.shouldLoad = false;
                }

                this.stream.replace(<any>response.entities);
                if(response.entities.length > 1){
                    this.criteria.criteria.seek.params.last_id = this.stream.all()[this.stream.all().length - 1]._id;
                }

                status.is = false;
            },
            (error) => {
                status.is = false;
            }
        )
    }

    public next() {
        let status = this.status.addLoading();
        let limit = this.criteria.criteria.seek.params.limit - 1;

        if(this.subscription) {
            this.subscription.unsubscribe();
        }

        this.subscription = this.source.fetch(this.createFeedRequest()).subscribe(
            (response) => {
                if(response.entities.length > limit){
                    response.entities.splice(limit, 1);
                    this.shouldLoad = true;
                } else {
                    this.shouldLoad = false;
                }

                this.stream.push(<any>response.entities);

                if(response.entities.length > 1) {
                    this.criteria.criteria.seek.params.last_id = this.stream.all()[this.stream.all().length - 1]._id;
                }

                status.is = false;
            },
            (error) => {
                status.is = false;
            }
        )
    }
}
