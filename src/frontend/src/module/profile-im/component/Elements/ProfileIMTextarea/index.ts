import {Component, ElementRef, ViewChild, Output, EventEmitter} from "angular2/core";

@Component({
    selector: 'cass-profile-im-textarea',
    template: require('./template.jade')
})

export class ProfileIMTextarea
{
    @ViewChild('textarea') textarea:ElementRef;
    @Output('send') sendEvent = new EventEmitter<string>();
    private hiddenDiv:HTMLDivElement = document.createElement('div');

    ngAfterViewInit() {
         this.hiddenDiv.style.cssText = window.getComputedStyle(this.textarea.nativeElement, null).cssText;
         this.hiddenDiv.style.width = this.hiddenDiv.style.height = "auto";
         this.hiddenDiv.style.visibility = "hidden";
         this.hiddenDiv.style.position = "absolute";
         this.textarea.nativeElement.parentElement.insertBefore(this.hiddenDiv, this.textarea.nativeElement);
         this.adjust("");
    }
    
    submit(e: Event) {
        e.preventDefault();
        this.sendEvent.emit(this.textarea.nativeElement.value);
        this.textarea.nativeElement.value = "";
    }

    adjust(value: string) {
        this.hiddenDiv.innerHTML = value.replace(/[<>]/g, '_') + "\n";
        let maxRows = 4,
            height = this.hiddenDiv.offsetHeight,
            maxHeight = parseInt(this.hiddenDiv.style.lineHeight, 10) * maxRows;

        this.textarea.nativeElement.style.height = Math.min(maxHeight, height) + 'px';
    }

}
