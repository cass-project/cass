import {Input, Component, Directive} from "@angular/core";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-collection-select'})
export class CollectionSelect
{
    @Input("collections") collections: string;
}