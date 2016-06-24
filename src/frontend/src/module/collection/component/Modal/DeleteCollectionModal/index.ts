import {Component} from "angular2/core";
import {ModalComponent} from "../../../../modal/component/index";
import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {CollectionSelect} from "../../Elements/CollectionSelect/index";

@Component({
    selector: 'cass-collection-delete-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        CollectionSelect,
    ]
})
export class DeleteCollectionModal
{}