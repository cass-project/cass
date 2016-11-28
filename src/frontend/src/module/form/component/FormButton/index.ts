import {Component, Input, Output, EventEmitter} from "@angular/core";



@Component({
    selector: 'cass-form-button',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]

})

export class FormButton {

    @Input('title') title:string;
    @Input('type') type:FormButtonType;
    @Input('styles') styles: FormButtonStyles;
    @Input('color') color: string;
    @Input('icon') icon:string;
    @Input('disabled') disabled: boolean;
    @Output('click') clickEvent: EventEmitter<any> = new EventEmitter<any>();


    getCSSClasses(): any {

        if (this.styles === FormButtonStyles.Text) {
            return {
                'form-text-button': true,
                'form-button': false
            }
        } else {
           return {
               'form-button': true,
               'form-text-button': false
           }
        }

    }

    getTypeButton(): string {
        return <any>this.type;
    }

    getIcon() {
        let icon = this.icon;

        if(icon) {
            return "<i class =" + icon + "aria-hidden='true'"+"></i>";
        } else {
            return "";
        }

    }

    getDisabled(): boolean {
        return this.disabled;
    }

    click($event) {
        $event.stopPropagation();

        if(!this.disabled) {
            this.clickEvent.emit($event);
        }

    }

    getBgColor():any {

     let bgColor = {
         'backgroundColor': this.color
     };

        return bgColor;
    }

}

enum FormButtonType {
    Button = <any>"button",
    Submit = <any>"submit",
}

enum FormButtonStyles {
    Text = <any>"text",
    Solid = <any>"solid",
}


