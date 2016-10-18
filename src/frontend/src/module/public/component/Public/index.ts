import {Component, Directive, ElementRef, ViewChild} from "@angular/core";

import {PublicService} from "../../service";
import {FeedCriteriaService} from "../../../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../../../feed/service/FeedOptionsService";
import {FeedScrollService} from "../../../feed/component/FeedScrollDetector/service";

@Directive({
    selector: 'cass-public'
})
@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        PublicService,
        FeedCriteriaService,
        FeedOptionsService,
        FeedScrollService,
    ]
})
export class PublicComponent
{
    @ViewChild('contentArea') contentArea: ElementRef;

    constructor(
        private service: PublicService,
        private scroll: FeedScrollService
    ) { }

    onScroll($event: Event) {
        this.scroll.emit({
            html: this.contentArea.nativeElement
        });
    }

    isPostCriteriaAvailable() {
        return ~[
            "content",
        ].indexOf(this.service.source);
    }
}

interface ContainerScrollEvent
{
    html: ElementRef
}