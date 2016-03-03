import {Component} from 'angular2/core';
import {ROUTER_DIRECTIVES} from 'angular2/router';
import {COMMON_DIRECTIVES} from 'angular2/common';
import {ChannelEditorService} from './../../service/ChannelEditorService';
import {CreateChannelFormComponent} from './../../component/CreateChannelFormComponent/index';

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        COMMON_DIRECTIVES,
        ROUTER_DIRECTIVES,
        CreateChannelFormComponent
    ]
})

export class ChannelListComponent
{
    constructor(public channelEditorService:ChannelEditorService){}
}