import {Injectable} from "angular2/core";

import {ThemeIdCriteria} from "./criteria/ThemeIdCriteria";
import {QueryStringCriteria} from "./criteria/QueryStringCriteria";
import {FeedCriteria} from "./criteria/FeedCriteria";
import {SeekCriteria} from "./criteria/SeekCriteria";

@Injectable()
export class SearchCriteriaService
{
    public criteria: {
        theme: ThemeIdCriteria,
        queryString: QueryStringCriteria,
        feed: FeedCriteria,
        seek: SeekCriteria
    } = {
        theme: new ThemeIdCriteria(),
        queryString: new QueryStringCriteria(),
        feed: new FeedCriteria(),
        seek: new SeekCriteria()
    };
    
    update() {}
}