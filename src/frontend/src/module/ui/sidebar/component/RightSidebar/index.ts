import {Component, HostListener} from "@angular/core";

import {ViewOptionService} from "../../../../public/component/Options/ViewOption/service";
import {ContentPlayerService} from "../../../../player/service/ContentPlayerService/service";
import {UINavigationObservable} from "../../../service/navigation";

@Component({
    selector: 'cass-right-sidebar',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class RightSidebar
{
    constructor(
        private viewOption: ViewOptionService,
        private player: ContentPlayerService,
        private navigator: UINavigationObservable
    ) {}
    
    

    @HostListener('document:keydown', ['$event']) globalKeyDown($event){
        if($event.key === 'Enter'){
            if($event.target.nodeName.toLowerCase() != 'textarea' &&  $event.target.nodeName.toLowerCase() != 'input' && $event.target.nodeName.toLowerCase() != 'select'){
                $event.preventDefault();
                this.navigator.emitEnter();
            }
        }

        if($event.key === 'ArrowUp'){
            if($event.target.nodeName.toLowerCase() != 'textarea' &&  $event.target.nodeName.toLowerCase() != 'input' && $event.target.nodeName.toLowerCase() != 'select'){
                $event.preventDefault();
                this.navigator.emitUp();
            }
        }

        if($event.key === 'ArrowDown'){
            if($event.target.nodeName.toLowerCase() != 'textarea' &&  $event.target.nodeName.toLowerCase() != 'input' && $event.target.nodeName.toLowerCase() != 'select'){
                $event.preventDefault();
                this.navigator.emitDown();
            }
        }

        if($event.key === 'ArrowLeft'){
            if($event.target.nodeName.toLowerCase() != 'textarea' &&  $event.target.nodeName.toLowerCase() != 'input' && $event.target.nodeName.toLowerCase() != 'select') {
                $event.preventDefault();
                this.navigator.emitLeft();
            }
        }

        if($event.key === 'ArrowRight'){
            if($event.target.nodeName.toLowerCase() != 'textarea' &&  $event.target.nodeName.toLowerCase() != 'input' && $event.target.nodeName.toLowerCase() != 'select') {
                $event.preventDefault();
                this.navigator.emitRight();
            }
        }
    }
}