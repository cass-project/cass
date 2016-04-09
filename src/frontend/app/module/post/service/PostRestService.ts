import {ResponseInterface} from '../../../module/common/ResponseInterface.ts';
import {Http, Response} from 'angular2/http';
import {Observable} from 'rxjs/Observable';
import {Injectable} from 'angular2/core';
import {URLSearchParams} from 'angular2/http';
import {Headers} from "angular2/http";
import {RequestOptions} from "angular2/http";

@Injectable()
export class PostRestService{
    constructor(public http:Http) {}

    public getPost(id){
        return this.http.get('backend/api/protected/post/read/' + id);
    }

    public createPost(postMessage){
        return this.http.put('backend/api/protected/post/create', JSON.stringify({
            description: postMessage
        }));
    }

    public updatePost(postId, accountId, title, postMessage){
        return this.http.post('backend/api/protected/post/update', JSON.stringify({
            id: postId,
            account_id: accountId,
            name: title,
            description: postMessage,
            status: "1"
        }));
    }
}