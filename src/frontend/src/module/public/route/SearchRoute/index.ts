import {Component} from "angular2/core";

import {QueryStringCriteria} from "../../component/Criteria/QueryStringCriteria/index";
import {FeedCriteria} from "../../component/Criteria/FeedCriteria/index";
import {SeekCriteria} from "../../component/Criteria/SeekCriteria/index";
import {ThemeCriteria} from "../../component/Criteria/ThemeCriteria/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        QueryStringCriteria,
        FeedCriteria,
        SeekCriteria,
        ThemeCriteria,
    ]
})
export class SearchRoute
{

}