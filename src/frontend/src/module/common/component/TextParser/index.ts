var md = require('markdown-it')({
    breaks: true,
    linkify: true,
    quotes: ">"
});


export class TextParser
{
    parseText(text){
        return md.render(text);
    }
}