import {Component, Input} from "angular2/core";

import {Collection} from "../../../definitions/entity/collection";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
    ]
})
export class CollectionsList
{
    @Input('collections') collections: Collection[];
}