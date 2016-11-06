var md = require('markdown-it')({
    breaks: true,
    linkify: true,
    quotes: ">"
});

import {Component, Input, ViewEncapsulation} from "@angular/core";

@Component({
    selector: 'cass-text-parser',
    styles: [
        require('./style.shadow.scss')
    ],
    encapsulation: ViewEncapsulation.None,
    template: require('./template.jade')
})

export class TextParser
{
    @Input('text') text: string;

    private whiteList = [
        "p\/home.*"  
    ];

    parseText() {
        md.validateLink = (link) => { return this.validateLink(link) };
        return md.render(this.text);
    }
    
    isInternalLink(link): boolean {
        return new RegExp("^http:\/\/"+window.location.host+"\/.*$").test(link);
    }
    
    isInWhiteList(link) : boolean {
        for(let whiteLink of this.whiteList) {
            let whiteLinkRegExp:RegExp = new RegExp("^http:\/\/"+window.location.host+"\/" + whiteLink + "$");
            if(whiteLinkRegExp.test(link)) {
                return true;
            }
        }
        return false;   
    }
    
    validateLink(link) : boolean {
        if(this.isInternalLink(link)) {
            return this.isInWhiteList(link) 
        }
        return true;
    }
}