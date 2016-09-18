import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";

import {CreatePostRequest, CreatePostResponse200} from "../definitions/paths/create";
import {RESTService} from "../../common/service/RESTService";
import {GetPostResponse200} from "../definitions/paths/get";
import {EditPostRequest, EditPostResponse200} from "../definitions/paths/edit";
import {DeletePostResponse200} from "../definitions/paths/delete";

export interface PostRESTServiceInterface
{
    getPost(postId: number): Observable<GetPostResponse200>;
    createPost(request: CreatePostRequest): Observable<CreatePostResponse200>;
    editPost(postId: number, request: EditPostRequest): Observable<EditPostResponse200>;
    deletePost(postId: number): Observable<DeletePostResponse200>;
}

@Injectable()
export class PostRESTService implements PostRESTServiceInterface
{
    constructor(private rest: RESTService) {}

    getPost(postId: number): Observable<GetPostResponse200> {
        return this.rest.get(`/backend/api/post/${postId}/get`);
    }

    createPost(request: CreatePostRequest): Observable<CreatePostResponse200> {
        return this.rest.put(`/backend/api/protected/post/create`, request);
    }

    editPost(postId: number, request: EditPostRequest): Observable<EditPostResponse200> {
        return this.rest.post(`/backend/api/protected/post/${postId}/delete`, request);
    }

    deletePost(postId: number): Observable<DeletePostResponse200> {
        return this.rest.delete(`/backend/api/protected/post/${postId}/delete`);
    }
}
