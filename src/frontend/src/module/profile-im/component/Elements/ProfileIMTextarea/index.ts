import {Component, ElementRef, ViewChild} from "angular2/core";
import {RouteParams} from "angular2/router";

import {ProfileIMMessageModel}  from "../ProfileIMChat/model";
import {ProfileIMService}       from "../../../service/ProfileIMService";
import {AuthService}            from "../../../../auth/service/AuthService";
import {MessageBusService} from "../../../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../../../message/component/MessageBusNotifications/model";

@Component({
    selector: 'cass-profile-im-textarea',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]})

export class ProfileIMTextarea
{
    private maxLength = 2000;
    @ViewChild('textarea') textarea:ElementRef;
    private hiddenDiv:HTMLDivElement = document.createElement('div');
    private content:string = "";
    constructor(
        private params: RouteParams,
        private imService:ProfileIMService,
        private authService:AuthService,
        private messageBus: MessageBusService
    ){}
    
    ngAfterViewInit() {
        this.hiddenDiv.style.cssText = window.getComputedStyle(this.textarea.nativeElement, null).cssText;
        this.hiddenDiv.style.height = "auto";
        this.hiddenDiv.style.visibility = "hidden";
        this.hiddenDiv.style.position = "absolute";
        this.textarea.nativeElement.parentElement.insertBefore(this.hiddenDiv, this.textarea.nativeElement);
        this.adjust("");
    }
    
    submit(e: Event) : boolean {
        e.preventDefault();
        if(this.content.length===0) {
            return false;
        }
        
        if(this.content.length > this.maxLength) {
            this.messageBus.push(
                MessageBusNotificationsLevel.Warning,
                `Пожалуйста, сократите ваше сообщение.
                Чтобы сделать общение более приятным для всех участников, мы установили лимит в ${this.maxLength} символов.`
            );
            return false;
        }
        
        this.imService.stream.next(<ProfileIMMessageModel>{
            source_profile: this.authService.getCurrentAccount().getCurrentProfile().entity,
            target_profile_id: parseInt(this.params.get('id')),
            date: new Date(),
            content: this.content,
            is_sended: false,
            has_error: false,
        });
        this.content = "";
        this.adjust("");
        return true;
    }

    adjust(value: string) {
        this.hiddenDiv.innerHTML = value.replace(/[<>]/g, '_') + "\n";
        let maxRows = 4,
            height = this.hiddenDiv.offsetHeight,
            maxHeight = parseInt(this.hiddenDiv.style.lineHeight, 10) * maxRows;

        this.textarea.nativeElement.style.height = Math.min(maxHeight, height) + 'px';
    }

}
