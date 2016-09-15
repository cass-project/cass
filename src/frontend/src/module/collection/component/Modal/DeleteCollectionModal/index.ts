import {Component} from "@angular/core";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-collection-delete-modal'})
export class DeleteCollectionModal
{}