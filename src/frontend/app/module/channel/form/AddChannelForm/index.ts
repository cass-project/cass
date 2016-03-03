import {Component} from 'angular2/core';
import {ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {COMMON_DIRECTIVES} from 'angular2/common';

import {ChannelRESTService} from './../../service/ChannelRESTService';

@Component({
    selector: 'create-channel-form',
    template: require('./template.html'),
    directives: [
        COMMON_DIRECTIVES,
        ROUTER_DIRECTIVES
    ],
})

export class AddChannelFormComponent
{
    public name:string;
    public theme:number;

    constructor(
        private channelRESTService:ChannelRESTService,
        private router: Router
    ){}

    public submit(){
        this.channelRESTService.addChannel(this.name, this.theme);
    }

    public close(){
        this.router.navigate(['Channels']);
    }
}