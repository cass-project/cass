import {Component} from 'angular2/core';
import {RouteParams} from 'angular2/router';

@Component({
    template: require('./template.html'),
    directives: [],
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileChannelComponent
{
    channelId: number;

    constructor(private _routeParams:RouteParams) {
        this.channelId = parseInt(_routeParams.get('channelId'), 10);
    }
}