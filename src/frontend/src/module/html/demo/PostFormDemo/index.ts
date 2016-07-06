import {Component} from "angular2/core";

@Component({
    selector: 'cass-post-form-demo',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
})
export class PostFormDemo 
{
    isFocused: boolean;
    model: PostFormModel = {
        content: ''
    };
    
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