import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES, RouteConfig} from "angular2/router";

import {ContentRoute} from "./route/ContentRoute/index";
import {PublicService} from "./service";
import {ThemeCriteria} from "./component/Criteria/ThemeCriteria/index";
import {QueryStringCriteria} from "./component/Criteria/QueryStringCriteria/index";
import {SeekCriteria} from "./component/Criteria/SeekCriteria/index";
import {SourceSelector} from "./component/Elements/SourceSelector/index";
import {CollectionsRoute} from "./route/CollectionsRoute/index";
import {CommunitiesRoute} from "./route/CommunitiesRoute/index";
import {ExpertsRoute} from "./route/ExpertsRoute/index";
import {ProfilesRoute} from "./route/ProfilesRoute/index";

@Component({
    selector: 'cass-public',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        PublicService,
    ],
    directives: [
        ROUTER_DIRECTIVES,
        ThemeCriteria,
        QueryStringCriteria,
        SeekCriteria,
        SourceSelector,
    ]
})
@RouteConfig([
    {
        path: '/content',
        name: 'Content',
        component: ContentRoute,
        useAsDefault: true
    },
    {
        path: '/collections',
        name: 'Collections',
        component: CollectionsRoute
    },
    {
        path: '/communities',
        name: 'Communities',
        component: CommunitiesRoute
    },
    {
        path: '/experts',
        name: 'Experts',
        component: ExpertsRoute
    },
    {
        path: '/profiles',
        name: 'Profiles',
        component: ProfilesRoute
    },
])
export class PublicComponent
{
}