import {NgModule} from '@angular/core';

import {ContentTypeCriteria} from "./component/Criteria/ContentTypeCriteria/index";
import {QueryStringCriteria} from "./component/Criteria/QueryStringCriteria/index";
import {SeekCriteria} from "./component/Criteria/SeekCriteria/index";
import {ThemeCriteria} from "./component/Criteria/ThemeCriteria/index";
import {PublicComponent} from "./component/Public/index";
import {ViewOption} from "../feed/service/FeedService/options/ViewOption";
import {SourceSelector} from "./component/Elements/SourceSelector/index";
import {NothingFound} from "./component/Elements/NothingFound/index";

@NgModule({
    declarations: [
        PublicComponent,
        ContentTypeCriteria,
        QueryStringCriteria,
        SeekCriteria,
        ThemeCriteria,
        NothingFound,
        SourceSelector,
        ViewOption,
    ],
    providers: []
})
export class CASSPublicComponent {}