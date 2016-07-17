import {Component, Output, EventEmitter} from "angular2/core";

@Component({
    selector: 'cass-public-option-view',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class OptionView
{
}