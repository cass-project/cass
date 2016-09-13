import {Component, Directive} from "@angular/core";
import {ModalComponent} from "../../../../modal/component/index";
import {ModalBoxComponent} from "../../../../modal/component/box/index";
import {CollectionSelect} from "../../Elements/CollectionSelect/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-collection-delete-modal'})
export class DeleteCollectionModal
{}