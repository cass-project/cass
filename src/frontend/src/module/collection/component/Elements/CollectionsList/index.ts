import {Component, Input} from "angular2/core";

import {Collection, CollectionEntity} from "../../../definitions/entity/collection";
import {CollectionCard} from "../CollectionCard/index";
import {CreateCollectionCard} from "../CreateCollectionCard/index";
import {Router} from "angular2/router";

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

    constructor(private router: Router) {}

    go(entity: CollectionEntity) {
        console.log(entity);
        this.router.navigate(['View', { sid: entity.sid }]);
    }
}