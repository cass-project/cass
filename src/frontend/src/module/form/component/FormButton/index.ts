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
    @Input('styles') styles:FormButtonStyles;
    @Input('color') color: FormButtonColor;
    @Input('icon') icon:string;
    @Input('disabled') disabled:boolean;
    @Output('click') clickEvent:EventEmitter<any> = new EventEmitter<any>();


    getCSSClasses():any {

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

    getTypeButton():string {
        return <any>this.type;
    }

    getIcon() {
        let icon = this.icon;

        if (icon) {
            return "<i class =" + icon + "aria-hidden='true'" + "></i>";
        } else {
            return "";
        }

    }

    getDisabled():boolean {
        return this.disabled;
    }

    click($event) {
        $event.stopPropagation();

        if (!this.disabled) {
            this.clickEvent.emit($event);
        }

    }

    getBgColor():any {

        let color = this.color;

        if (FormButtonColor[color]) {
            return {
                'backgroundColor': FormButtonColor[color]
            }
        }

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

enum FormButtonColor {
    Тransparent = <any>"primary",
    '#81C784'= <any>"success",//зеленый
    '#9E9E9E'= <any>"default",// серый
    '#D32F2F' = <any>"error", // красный
    '#FDD835' = <any>"warning",// желтый
    Green = <any>"green",
    '#2196F3' = <any>"#2196F3", // голубой
    Red = <any>"red",
    Pink = <any>"pink",
    Purple = <any>"purple",
    '#7E57C2'= <any>"deep-purple",
    LightBlue = <any>"light-blue",
    '#3F51B5' = <any>"indigo",
    '#42A5F5' = <any>"blue",
    '#00BCD4' = <any> "cyan",
    Teal = <any>"teal",
    LightGreen = <any>"light-green",
    '#CDDC39' = <any>"lime",
    '#FFEE58'= <any>"yellow",
    Orange = <any>"orange",
    Brown = <any>"brown",
    '#FFC107' = <any>"amber",
    Grey = <any>"grey",
    '#9d223c'= <any>'#9d223c'//бордовый на кнопке удалить
}
