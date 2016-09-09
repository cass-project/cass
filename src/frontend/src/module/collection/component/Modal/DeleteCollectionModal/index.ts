import {Component} from "@angular/core";
import {ModalComponent} from "../../../../modal/component/index";
import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {CollectionSelect} from "../../Elements/CollectionSelect/index";

@Component({
    selector: 'cass-collection-delete-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class DeleteCollectionModal
{}