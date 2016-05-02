import {Injectable} from "angular2/core";
import {Http} from "angular2/http";

@Injectable()
export class PostRESTService
{
    constructor(private http: Http) {}

    public create(request: PostCreateRequest) {
        return this.http.put("/backend/api/protected/post/create", JSON.stringify(request));
    }

    public /* delete */ remove(postId: number) {
        return this.http.delete(`/backend/api/protected/post/${postId}/delete`);
    }

    public edit(postId: number, request: PostEditRequest) {
        return this.http.post(`/backend/api/protected/post/${postId}/edit`, JSON.stringify(request));
    }

    public getById(postId: number) {
        return this.http.get(`/backend/api/protected/post/${postId}/get`);
    }
}

export interface PostCreateRequest
{
    profile_id: number;
    collection_id: number;
    content: string;
}

export interface PostEditRequest
{
    collection_id: number;
    content: string;
}