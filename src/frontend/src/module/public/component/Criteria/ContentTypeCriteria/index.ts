import {Component} from "angular2/core";
import {Criteria} from "../../../../feed/service/FeedService/criteria";
import {PublicService} from "../../../service";

@Component({
    selector: 'cass-public-criteria-content-type',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ContentTypeCriteria
{
    private contentType: string;

    constructor(private service: PublicService) {}

    setContentType(contentType: string) {
        this.contentType = contentType;

        if(this.service.criteria.has('content_type')) {
            this.service.criteria.doWith('content_type', (criteria: Criteria<any>) => {
                criteria.params.type = this.contentType;
            });
        }else{
            this.service.criteria.attach({
                code: 'content_type',
                params: {
                    type: this.contentType
                }
            })
        }

        this.service.update();
    }

    reset() {
        this.contentType = null;
        this.service.criteria.detachByCode('conttent_type');
        this.service.update();
    }

    is(contentType: string) {
        return this.contentType === contentType;
    }

    isEnabled() {
        return !!this.contentType;
    }
}