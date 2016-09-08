import {Component, Input} from "@angular/core";
import {ROUTER_DIRECTIVES} from '@angular/router';

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