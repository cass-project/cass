import {Injectable} from "angular2/core";

import {Source} from "./source";
import {CriteriaManager} from "./criteria";
import {Stream} from "./stream";
import {Subscription} from "rxjs/Subscription";

@Injectable()
export class FeedService<T>
{
    static DEFAULT_PAGE_SIZE = 30;

    private status: LoadingStatus[] = [];
    private subscription: Subscription;

    public source: Source;
    public criteria: CriteriaManager;
    public stream: Stream<T>;

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
                'limit': FeedService.DEFAULT_PAGE_SIZE
            }
        });
    }

    public provide(source: Source, stream: Stream<T>) {
        this.source = source;
        this.stream = stream;
    }

    public isLoading(): boolean {
        return this.status.filter(input => input.is).length > 0;
    }

    isNothingFound(): boolean {
        return !this.isLoading() && (this.stream.size() === 0);
    }

    public update() {
        let status = { is: true };

        this.status = [];
        this.status.push(status);
        this.stream.empty();

        if(this.subscription) {
            this.subscription.unsubscribe();
        }
        
        this.subscription = this.source.fetch(this.criteria.createFeedRequest()).subscribe(
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
        let status = { is: true };

        this.status.push(status);
        this.source.fetch(this.criteria.createFeedRequest()).subscribe(
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

interface LoadingStatus
{
    is: boolean;
}