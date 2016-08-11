import {Component, ViewChild, ElementRef} from "@angular/core";
import {AppService} from "../../../../app/frontend-app/service";
import {FeedService} from "../../service/FeedService/index";
import {PostEntity} from "../../../post/definitions/entity/Post";

@Component({
    selector: 'cass-feed-scroll-detector',
    template: require('./template.jade')
})

export class FeedScrollDetector
{
    constructor(private appService: AppService,
                private feed: FeedService<PostEntity>){}


    @ViewChild('feedUpdateButton') feedUpdateButton: ElementRef;

    ngOnInit(){
        this.appService.scrollObservable.subscribe((scrollEvent) => {
            if(this.detectElem(scrollEvent.html)){
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