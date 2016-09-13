import {Component, ViewChild, ElementRef, Renderer} from "@angular/core";
import {RouterOutlet} from '@angular/router';
import {Module} from "../../module/common/classes/Module";
import {AppService} from "./service";


@Component({
    selector: 'cass-frontend-app',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [AppService]
})
export class App
{
    static version(): string {
        return require('./../../../package.json').version;
    }

    @ViewChild('content') content: ElementRef;
    
    constructor(private appService: AppService){}

    
    ngAfterViewInit(){
        this.appService.content = this.content;
    }
}

console.log(`CASS Frontend App: ver${App.version()}`);