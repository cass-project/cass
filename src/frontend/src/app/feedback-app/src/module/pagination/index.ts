import {Component, Input} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";

@Component({
    selector: 'cass-feedback-pagination',
    template: require('./template.jade'),
    directives:[ ROUTER_DIRECTIVES ]
})

export class PaginationComponent {
    @Input('current') current:number;
    @Input('total') total:number;
    
    public pages() {
        return new Array(this.total);
    }
    
}