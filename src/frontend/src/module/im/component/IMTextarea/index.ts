import {Component, ElementRef, ViewChild, Input, EventEmitter, Output, Directive} from "@angular/core";

import {MessageBusNotificationsLevel} from "../../../message/component/MessageBusNotifications/model";
import {MessageBusService} from "../../../message/service/MessageBusService/index";
import {IMMessageSourceEntityType} from "../../definitions/entity/IMMessageSource";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]})
@Directive({selector: 'cass-im-textarea'})

export class IMTextarea
{
    @ViewChild('textarea') textarea:ElementRef;
    @Input('max-length') maxLength:number = 2000;
    @Input('disabled') disabled:boolean;
    @Input('greetings') greetings:string;
    @Output('send') onSendEvent = new EventEmitter<IMTextareaModel>();

    private hiddenDiv:HTMLDivElement = document.createElement('div');
    
    public model:IMTextareaModel = {
        content:"",
        attachments:[]
    };

    constructor(private messageBus: MessageBusService){}
    
    ngAfterViewInit() {
        this.hiddenDiv.style.cssText = window.getComputedStyle(this.textarea.nativeElement, null).cssText;
        this.hiddenDiv.style.height = "auto";
        this.hiddenDiv.style.width = "auto"; // fix horisontal scroll on resize window
        this.hiddenDiv.style.visibility = "hidden";
        this.hiddenDiv.style.position = "absolute";
        this.textarea.nativeElement.parentElement.insertBefore(this.hiddenDiv, this.textarea.nativeElement);
        this.adjust("");
    }
    
    submit(e: Event) : boolean {
        e.preventDefault();
        if(this.model.content.length===0) {
            return false;
        }
        
        if(this.model.content.length > this.maxLength) {
            this.messageBus.push(
                MessageBusNotificationsLevel.Warning,
                `Пожалуйста, сократите ваше сообщение.
                Чтобы сделать общение более приятным для всех участников, мы установили лимит в ${this.maxLength} символов.`
            );
            return false;
        }
        this.onSendEvent.emit(this.model);
        this.reset();
        return true;
    }

    adjust(value: string) {
        this.hiddenDiv.innerHTML = value.replace(/[<>]/g, '_') + "\n";
        let maxRows = 4,
            height = this.hiddenDiv.offsetHeight,
            maxHeight = parseInt(this.hiddenDiv.style.lineHeight, 10) * maxRows;

        this.textarea.nativeElement.style.height = Math.min(maxHeight, height) + 'px';
    }
    
    reset() {
        this.model = {
            content: "",
            attachments: []
        };
        this.adjust("");
    }
}

interface IMTextareaModel {
    content:string,
    attachments:number[]
} 
