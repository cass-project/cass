import {Component, Input, Output, EventEmitter} from "@angular/core";
import {PostEntity} from "../../../definitions/entity/Post";


@Component({
    selector: 'cass-delete-post',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class DeletePost
{
    @Input('post') post: PostEntity;
}