import {Component, Input} from "@angular/core";

@Component({
    selector: 'cass-feedback-pagination',
    template: require('./template.jade')
})

export class PaginationComponent {
    @Input('current') current:number;
    @Input('total') total:number;
    
    public pages() {
        return new Array(this.total);
    }
    
}