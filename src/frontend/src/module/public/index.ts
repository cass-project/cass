import {Component, Directive} from "@angular/core";
import {PublicService} from "./service";
import {FeedCriteriaService} from "../feed/service/FeedCriteriaService";
import {FeedOptionsService} from "../feed/service/FeedOptionsService";
import {AppService} from "../../app/frontend-app/service";

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
    ]
})
export class PublicComponent
{
    constructor(private service: PublicService,
                private appService: AppService) {}

    onScroll($event){
        this.appService.onScroll($event)
    }

    isPostCriteriaAvailable() {
        return ~[
            "content",
        ].indexOf(this.service.source);
    }
}
