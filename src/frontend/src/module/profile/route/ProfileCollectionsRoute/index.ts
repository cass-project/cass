import {Component, ModuleWithProviders} from "@angular/core";
import {Routes, RouterModule, RouterOutlet} from '@angular/router';

import {ProfileCollectionsListRoute} from "../ProfileCollectionsListRoute/index";
import {ProfileCollectionRoute} from "../ProfileCollectionRoute/index";
import {ProfileCollectionNotFoundRoute} from "../ProfileCollectionNotFoundRoute/index";


@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class ProfileCollectionsRoute
{

}