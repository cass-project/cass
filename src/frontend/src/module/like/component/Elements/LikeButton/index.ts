import {Component,Input,Output,EventEmitter} from "@angular/core"

@Component({
    selector : "cass-like-button",
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class LikeButton
{

}