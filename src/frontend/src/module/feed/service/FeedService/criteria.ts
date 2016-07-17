import {FeedRequest} from "../../definitions/request/FeedRequest";

export class CriteriaManager
{
    private criteria: { [code: string]: Criteria<any> } = {};

    attach(criteria: Criteria<any>) {
        if(this.has(criteria.code)) {
            throw new Error(`Criteria ${criteria.code} is already attached`);
        }

        this.criteria[criteria.code] = criteria;
    }

    detach(criteria: Criteria<any>) {
        if(this.has(criteria.code)) {
            delete this.criteria[criteria.code];
        }
    }
    
    detachByCode(code: string) {
        if(this.has(code)) {
            delete this.criteria[code];
        }
    }

    getByCode(code: string): Criteria<any> {
        if(this.criteria[code]) {
            return this.criteria[code];
        }else{
            throw new Error(`Criteria ${code} does not exists`);
        }
    }

    has(code: string) {
        return !!this.criteria[code];
    }

    doWith(code: string, callback: { (criteria: Criteria<any>) }) {
        if(this.has(code)) {
            callback(this.getByCode(code));
        }
    }

    requireWith(code: string, callback: { (criteria: Criteria<any>) }) {
        if(this.has(code)) {
            callback(this.getByCode(code));
        }else{
            throw new Error(`Criteria ${code} is required but not exists`);
        }
    }

    createFeedRequest(): FeedRequest {
        let criteria = [];

        for(var n in this.criteria) {
            if(this.criteria.hasOwnProperty(n)) {
                criteria.push(this.criteria[n]);
            }
        }

        return {
            criteria: criteria
        };
    }
}

export interface Criteria<T>
{
    code: string;
    params: T;
}