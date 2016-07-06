import {Criteria} from "../Criteria";

export enum FeedCriteriaValue {
    people = <any>"people",
    expert = <any>"expert",
    post = <any>"post",
    collection = <any>"collection",
    community = <any>"community"
}

export class FeedCriteria implements Criteria
{
    static DEFAULT_VALUE = FeedCriteriaValue.post;

    private feed: FeedCriteriaValue = FeedCriteria.DEFAULT_VALUE;
    
    getValue(): FeedCriteriaValue {
        return this.feed;
    }
    
    setValue(feedType: FeedCriteriaValue) {
        this.feed = feedType;
    }

    getName(): string {
        return 'feed';
    }

    isAvailable(): boolean {
        return true;
    }

    getParams(): any {
        return {
            'feed': this.feed
        }
    }
}