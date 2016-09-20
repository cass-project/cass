import {Component, ViewChild, ElementRef} from "@angular/core";

import {FeedService} from "../../service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";
import {FeedScrollService} from "./service";

@Component({
    selector: 'cass-feed-scroll-detector',
    template: require('./template.jade')
})

export class FeedScrollDetector
{
    @ViewChild('feedUpdateButton') feedUpdateButton: ElementRef;

    constructor(
        private service: FeedScrollService,
        private feed: FeedService<PostEntity>
    ) {}

    ngOnInit(){
        this.service.getObservable().subscribe((scrollEvent) => {
            if(this.detectElem(scrollEvent.html)) {
                this.feed.next();
            }
        })
    }

    detectElem(html) {
        if(this.feed.shouldLoad){
            let elem = this.feedUpdateButton.nativeElement;

            if(elem && !this.feed.isLoading()){
                let rect = elem.getBoundingClientRect();

                if(!!rect
                    && rect.bottom > 0
                    && rect.right > 0
                    && rect.top > 0
                    && rect.left > 0
                    && rect.top < html.clientHeight
                    && rect.left < html.clientWidth){
                    return true;
                }
            } else if(!this.feed.isLoading()){
                throw new Error("Cant find Elem");
            }
        }
    }
}