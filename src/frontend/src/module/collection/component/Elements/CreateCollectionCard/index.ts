import {Component, EventEmitter, Output, Directive} from "@angular/core";

import {CollectionModals} from "../../../modals";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-create-collection-card'})
export class CreateCollectionCard
{
    @Output('click') clickEvent = new EventEmitter<Event>();
    
    constructor(private modals: CollectionModals) {}

    private click($event) {
        this.clickEvent.emit($event);
    }
}