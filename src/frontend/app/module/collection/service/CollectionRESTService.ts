import {Injectable} from "angular2/core";
import {Http} from "angular2/http";

@Injectable()
export class CollectionRESTService
{
    constructor(private http: Http) {}

    public putCreate(profileId: number, body: PUTCreateCollection) {
        return this.http.put(`/backend/api/protected/profile/${profileId}/collection/create`, JSON.stringify(body));
    }
}

export interface PUTCreateCollection
{
    parent_id: number;
    theme_id: number;
    title: string;
    description: string
}