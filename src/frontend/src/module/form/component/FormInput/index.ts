import {Component, Input, ElementRef, ViewChild, Output,EventEmitter} from "@angular/core";




@Component({
    selector: 'cass-form-input',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]

})

export class FormInput{

    @Input('type') type: FormInputType;
    @Input('placeholder') placeholder: string;
    @Input('disabled') disabled: boolean;
    @Input('required') required: string;
    @Input('name') name: string;
    @Input('maxlength') maxlength: number;
    @Input('minlength') minlength: number;
    @Input('autocomplete') autocomplete: string;
    @Input('readonly') readonly: boolean;
    @Input('class') style: string;
    @ViewChild('input') input: ElementRef;
    @Output() valueChange = new EventEmitter<any>();
    @Output('focus') focusEvent: EventEmitter<any> = new EventEmitter<any>();

    private _value: string;

    @Input()
    set value(val) {
        this._value = val;
        this.valueChange.emit(this._value);
    }

    get value() {
        return this._value;
    }

    getTypeInput() {
        return <any>this.type;
    }

    getText() {
        if (!this.placeholder) {
            return "";
        } else {
            return this.placeholder;
        }
    }

    getDisabled():boolean {
        return this.disabled;
    }

    getRequired():boolean {
        if(this.required == "true") {
            return true;
        } else {
            return false;
        }
    }

    getName() {
        return this.name;
    }

    getMinLength() {
        return this.minlength;
    }

    getMaxLength() {
        return this.maxlength;
    }

    getAutocomplete() {
        return this.autocomplete;
    }

    getReadonly() {
        return this.readonly;
    }

    getCSSClasses() {
        return  this.style;
    }

    putFocus() {
        this.input.nativeElement.focus();
    }

    select() {
        this.input.nativeElement.focus();
        this.input.nativeElement.select();
    }

    focus($event) {
        this.focusEvent.emit($event);
    }


}

export enum FormInputType {
    Text = <any>'text',
    Password = <any>'password',
    Email = <any>'email'
}