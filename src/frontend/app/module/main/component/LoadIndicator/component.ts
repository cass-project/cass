import {Component, Input} from 'angular2/core';

@Component({
    selector: 'load-indicator',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class LoadIndicator
{
    @Input() public text:string;
    @Input() public size:string;
    @Input() public modal:boolean = false;
}