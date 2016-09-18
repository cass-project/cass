import {Observable} from "rxjs/Observable";
import {FeedEntity} from "./entity";

import {FeedRequest} from "../../definitions/request/FeedRequest";
import {Success200} from "../../../common/definitions/common";

export interface Source
{
    fetch(request: FeedRequest): Observable<FeedResponse>
}

export interface FeedResponse extends Success200 {
    entities: FeedEntity[];
}