import {Injectable} from "@angular/core";

import {FeedService} from "../feed/service/FeedService/index";

@Injectable()
export class PublicService
{
    public source: string;
    private feedService: FeedService<any>;

    public injectFeedService(service: FeedService<any>) {
        this.feedService = service;
    }
    
    public update() {
        if(this.feedService !== undefined) {
            this.feedService.update();
        }
    }
    
    public next() {
        if(this.feedService !== undefined) {
            this.feedService.next();
        }
    }
}