import {Component} from 'angular2/core';
import {ROUTER_DIRECTIVES} from 'angular2/router';
import {COMMON_DIRECTIVES} from 'angular2/common';
import {ChannelRESTService} from './../../service/ChannelRESTService';
import {ChannelEditorService} from './../../service/ChannelEditorService';

@Component({
    selector: 'create-channel-form',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        COMMON_DIRECTIVES,
        ROUTER_DIRECTIVES
    ],
})

export class CreateChannelFormComponent
{
   public name:string;
    public theme:number;

    constructor(
        private channelRESTService:ChannelRESTService,
        public channelEditorService:ChannelEditorService
    ){}

    public add(){
        this.channelRESTService.addChannel(this.name, this.theme);
    }

 }