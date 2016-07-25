import {Injectable} from "angular2/core";

import {Criteria} from "../definitions/request/Criteria";
import {SeekCriteriaParams} from "../definitions/request/criteria/SeekCriteriaParams";
import {SortCriteriaParams} from "../definitions/request/criteria/SortCriteriaParams";
import {ThemeIdCriteriaParams} from "../definitions/request/criteria/ThemeIdCriteriaParams";
import {QueryStringCriteriaParams} from "../definitions/request/criteria/QueryStringCriteriaParams";
import {ContentTypeCriteriaParams, ContentType} from "../definitions/request/criteria/ContentTypeCriteriaParams";

@Injectable()
export class FeedCriteriaService
{
    static DEFAULT_LIMIT = 30;

    public criteria: FeedCriteriaList = {
        seek: {
            code: 'seek',
            enabled: true,
            params: {
                limit: FeedCriteriaService.DEFAULT_LIMIT
            }
        },
        sort: {
            code: 'sort',
            enabled: true,
            params: {
                field: '_id',
                order: 'desc'
            }
        },
        theme: {
            code: 'theme_id',
            enabled: false,
            params: {
                id: -1
            }
        },
        query: {
            code: 'query_string',
            enabled: false,
            params: {
                query: ''
            }
        },
        contentType: {
            code: 'content_type',
            enabled: false,
            params: {
                type: undefined
            }
        }
    };

    public enable(code: string) {
        if(! this.hasCriteria(code)) {
            throw new Error(`Unknown criteria with code '${code}'`);
        }

        this.criteria[code].enabled = true;
    }

    public isEnabled(code: string): boolean {
        if(! this.hasCriteria(code)) {
            throw new Error(`Unknown criteria with code '${code}'`);
        }

        return this.criteria[code].enabled;
    }

    public disable(code: string) {
        if(! this.hasCriteria(code)) {
            throw new Error(`Unknown criteria with code '${code}'`);
        }

        this.criteria[code].enabled = false;
    }

    public hasCriteria(code: string) {
        return this.criteria.hasOwnProperty(code);
    }

    createFeedCriteriaRequest(): Criteria<any>[] {
        let criteria = [];

        for(var n in this.criteria) {
            if(this.criteria.hasOwnProperty(n)) {
                if(this.criteria[n].enabled) {
                    criteria.push(this.criteria[n]);
                }
            }
        }

        return criteria;
    }
}

interface FeedCriteriaList {
    seek: Criteria<SeekCriteriaParams>;
    sort: Criteria<SortCriteriaParams>;
    theme: Criteria<ThemeIdCriteriaParams>;
    query: Criteria<QueryStringCriteriaParams>;
    contentType: Criteria<ContentTypeCriteriaParams>;
}