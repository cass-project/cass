import {Component} from 'angular2/core';
import {ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {COMMON_DIRECTIVES} from 'angular2/common';
import {FORM_DIRECTIVES} from 'angular2/common';

import {ChannelRESTService} from './../../service/ChannelRESTService';
import {Validators} from "angular2/common";
import {Control} from "angular2/common";
import {ControlGroup} from "angular2/common";
import {FormBuilder} from "angular2/common";


@Component({
    selector: 'create-channel-form',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    directives: [
        COMMON_DIRECTIVES,
        FORM_DIRECTIVES,
        ROUTER_DIRECTIVES
    ]
})

export class AddChannelFormComponent
{
    public name:Control;
    public theme:Control;
    public form: ControlGroup;

    constructor(
        private channelRESTService:ChannelRESTService,
        private router: Router,
        private builder: FormBuilder
    ){
        this.name = new Control('', Validators.required);
        this.theme = new Control('', Validators.required);
        this.form = builder.group({
            name: this.name,
            theme: this.theme
        });
    }

    public submit(){
        this.channelRESTService.addChannel(this.form.value);
    }

    public close(){
        this.router.navigate(['Channels']);
    }
}