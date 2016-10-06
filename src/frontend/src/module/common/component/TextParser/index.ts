var md = require('markdown-it')({
    breaks: true,
    linkify: true,
    quotes: ">"
});

import {Component, Input} from "@angular/core";

@Component({
    selector: 'cass-text-parser',
    template: require('./template.jade')
})

export class TextParser
{
    @Input('text') text: string;

    parseText(){
        return md.render(this.text);
    }
}