import {Input, Component} from "@angular/core";

@Component({
    selector: 'cass-collection-select',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CollectionSelect
{
    @Input("collections") collections: string;
}