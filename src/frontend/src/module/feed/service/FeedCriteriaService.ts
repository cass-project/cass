import {Injectable} from "angular2/core";

import {FeedRequest} from "../definitions/request/FeedRequest";
import {Criteria} from "../definitions/request/Criteria";

@Injectable()
export class FeedCriteriaService
{
    private criteria: { [code: string]: Criteria<any> } = {};

    attach(criteria: Criteria<any>) {
        if(this.has(criteria)) {
            throw new Error(`Criteria ${criteria.code} is already attached`);
        }

        this.criteria[criteria.code] = criteria;
    }

    detach(criteria: Criteria<any>) {
        if(this.has(criteria)) {
            delete this.criteria[criteria.code];
        }
    }

    getByCode(code: string): Criteria<any> {
        if(this.criteria[code]) {
            return this.criteria[code];
        }else{
            throw new Error(`Criteria ${code} does not exists`);
        }
    }

    has(criteria: Criteria<any>) {
        return !!this.criteria[criteria.code];
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