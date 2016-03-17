import {Component, ViewChild, ElementRef} from 'angular2/core';
import {ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {COMMON_DIRECTIVES, FORM_DIRECTIVES, FormBuilder, ControlGroup, Control, Validators} from 'angular2/common';

import {ChannelRESTService} from './../../service/ChannelRESTService';
import {ThemeRESTService} from "../../../theme/service/ThemeRESTService";
import {Theme} from "../../../theme/Theme";

@Component({
    selector: 'create-channel-form',
    template: require('./template.html'),
    directives: [
        COMMON_DIRECTIVES,
        FORM_DIRECTIVES //,ROUTER_DIRECTIVES
    ],
    styles:["select,input[type='text']{border-left-width:5px;}"]
})

export class AddChannelFormComponent
{
    @ViewChild('focusInput')
    public focusInput:ElementRef;
    public channelFormModel:ControlGroup;
    public themes:Theme[];
    public loading:boolean=false;

    constructor(
        private channelRESTService:ChannelRESTService,
        private router:Router,
        private builder:FormBuilder,
        private themeRESTService:ThemeRESTService
    ){}


    public submit() {
        if (this.channelFormModel.valid) {
            this.loading = true;
            this.channelRESTService.addChannel(this.channelFormModel.value).subscribe(
                success => {
                    console.log(success);
                    this.loading = false;
                    this.close()
                }
            );
        }
    }

    public close() {
        this.router.navigate(['Channels']);
    }

    public isValid(control:Control):boolean {
        return control.untouched || control.valid;
    }

    ngOnInit() {
        this.channelFormModel = this.builder.group({
            name: new Control('', Validators.required),
            theme: new Control('', Validators.required)
        });

        this.themeRESTService.getThemes().subscribe(data => {
            //this.isFormReady = true;
            this.themes = data.json()['entities'];
        });

    }
    public ngAfterViewInit() {
        this.focusInput.nativeElement.focus();
    }
}