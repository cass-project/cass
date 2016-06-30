import {Component, Input, Output, EventEmitter, Injectable} from "angular2/core";
import {PostEntity} from "../definitions/entity/Post";
import {CreatePostRequest} from "../definitions/paths/create";

@Component({
    selector: 'cass-post-form',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

@Injectable()
export class PostForm
{
    @Input('collectionId') collectionId;

    @Output('postEvent') postEvent = new EventEmitter<PostEntity>();

    postEntity: PostEntity;




}