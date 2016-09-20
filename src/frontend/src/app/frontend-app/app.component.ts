import {Component, ViewChild, ElementRef} from "@angular/core";

@Component({
    selector: 'cass-frontend-app',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: []
})
export class App
{
    static version(): string {
        return require('./../../../package.json').version;
    }
}

console.log(`CASS Frontend App: ver${App.version()}`);