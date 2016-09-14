import {Component, Input, Directive} from "@angular/core";

@Component({
    selector: 'cass-collection-image',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class CollectionImage
{
    @Input('url') url: string;
    @Input('border') border: string = 'circle';

    static allowedBorders = ['circle', 'square'];

    getURL() {
        return this.url;
    }

    getCSSClasses() {
        let border = this.border;

        if(!~CollectionImage.allowedBorders.indexOf(border)) {
            throw new Error(`Invalid border ${border}`);
        }

        return `collection-image-border collection-image-border-${border}`;
    }
}