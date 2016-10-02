import {Injectable} from "@angular/core";
import {Subscription} from "rxjs/Subscription";

import {Source} from "./source";
import {Stream} from "./stream";
import {LoadingManager} from "../../../common/classes/LoadingStatus";
import {FeedRequest} from "../../definitions/request/FeedRequest";
import {FeedCriteriaService} from "../FeedCriteriaService";
import {FeedEntity} from "./entity";
import {Observable, Observer} from "rxjs";

@Injectable()
export class FeedService<T extends FeedEntity>
{
    public shouldLoad: boolean = true;

    private status: LoadingManager = new LoadingManager();
    private subscription: Subscription;

    public stream: Stream<T>;
    public source: Source;

    public observable: Observable<T[]>;
    private observer: Observer<T[]>;
    
    constructor(
        private criteria: FeedCriteriaService
    ) {
        this.observable = Observable.create(observer => {
            this.observer = observer;
        }).publish().refCount();
    }

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
        if(this.subscription) {
            this.subscription.unsubscribe();
        }

        if(this.source) {
            this.stream.empty();
            delete this.criteria.criteria.seek.params.last_id;

            let limit = this.criteria.criteria.seek.params.limit - 1;
            let status = this.status.addLoading();

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

                    if(this.observer) {
                        this.observer.next(<any>response.entities);
                    }

                    status.is = false;
                },
                (error) => {
                    status.is = false;
                }
            )
        }
    }

    public hasMoreEntities(): boolean {
        return this.shouldLoad;
    }

    public next() {
        let status = this.status.addLoading();
        let limit = this.criteria.criteria.seek.params.limit - 1;

        this.source.fetch(this.createFeedRequest()).subscribe(
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
