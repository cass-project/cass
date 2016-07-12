import {Injectable} from "angular2/core";

import {Source} from "./source";
import {CriteriaManager} from "./criteria";
import {Stream} from "./stream";

@Injectable()
export class FeedService<T>
{
    private status: LoadingStatus[] = [];

    public source: Source;
    public criteria: CriteriaManager = new CriteriaManager();
    public stream: Stream<T>;

    public provide(source: Source, stream: Stream<T>) {
        this.source = source;
        this.stream = stream;
    }

    public isLoading(): boolean {
        return this.status.filter(input => input.is).length > 0;
    }

    public update() {
        let status = { is: true };

        this.status.push(status);
        this.source.fetch(this.criteria.createFeedRequest()).subscribe(
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