import {Component, Input, Output, EventEmitter, Injectable} from "angular2/core";

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
}