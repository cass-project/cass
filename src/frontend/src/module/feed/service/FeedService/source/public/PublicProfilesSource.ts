import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";

import {Source, FeedResponse} from "../../source";
import {FeedRESTService} from "../../../FeedRESTService";
import {FeedRequest} from "../../../../definitions/request/FeedRequest";

@Injectable()
export class PublicProfilesSource implements Source
{
    public collectionId: number;
    private source: PublicProfilesSources = PublicProfilesSources.InterestingIn;

    constructor(private feed: FeedRESTService) {}

    fetch(request: FeedRequest): Observable<FeedResponse> {
        switch(this.source) {
            default:
                throw new Error(`Invalid source "${this.source}"`);

            case PublicProfilesSources.InterestingIn:
                return this.feed.getPublicProfilesFeed(request);

            case PublicProfilesSources.Experts:
                return this.feed.getPublicExpertsFeed(request);
        }
    }

    getCurrentSource(): PublicProfilesSources {
        return this.source;
    }

    switchToInterestingIn() {
        this.source = PublicProfilesSources.InterestingIn;
    }

    switchToExperts() {
        this.source = PublicProfilesSources.Experts;
    }
}

export enum PublicProfilesSources
{
    InterestingIn = <any>"profiles",
    Experts = <any>"experts",
};