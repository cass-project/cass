import {Component, Injectable, Input, Output, EventEmitter} from "angular2/core";
import {PostRESTService} from "../service/PostRESTService";

@Component({
    selector: 'cass-post-form',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})

@Injectable()
export class PostForm
{
    constructor(private postRESTService: PostRESTService){}

    isFocused: boolean;
    model: PostFormModel = {
        content: ''
    };

    @Input('collection_id') collection_id: number;
    @Output('postEvent') postEvent = new EventEmitter();


    isExpanded(): boolean {
        let testHasContent = this.model.content.length > 0;
        let testIsFocused = this.isFocused;
        
        return testHasContent || testIsFocused;
    }
    
    focus() {
        this.isFocused = true;
    }
    
    blur() {
        this.isFocused = false;
    }
}

export interface PostFormModel
{
    content: string;
}