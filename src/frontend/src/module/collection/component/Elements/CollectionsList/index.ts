import {Component, Input} from "angular2/core";

import {Collection} from "../../../definitions/entity/collection";
import {CollectionCard} from "../CollectionCard/index";
import {CreateCollectionCard} from "../CreateCollectionCard/index";

@Component({
    selector: 'cass-collections-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        CollectionCard,
        CreateCollectionCard,
    ]
})
export class CollectionsList
{
    @Input('is-own') isOwn: boolean = false;
    @Input('collections') collections: Collection[];

    constructor() {}
}