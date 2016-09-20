import {Component} from "@angular/core";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ],selector: 'cass-attachment-error'})

export class AttachmentError
{}