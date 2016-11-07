import {Component, Input} from "@angular/core";
import {PostEntity} from "../../../definitions/entity/Post";


@Component({
    selector: 'cass-edit-post',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class EditPost
{
    @Input('post') post: PostEntity;
}
