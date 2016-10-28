import {Component, Input, Output, EventEmitter, ViewChild, ElementRef} from "@angular/core";

@Component({
    selector: 'cass-dropdown-menu',
    host: {
        '(document:click)': 'handleClick($event)',
    },
    template: require('./template.jade')
})

export class DropDownMenu
{
    @Input('menu') private menu: Array<MenuEntity>;
    @Output('clickInMenu') private clickInMenu: EventEmitter<MenuEntity> = new EventEmitter<MenuEntity>();
    @ViewChild('dropDownMenu') private dropDownMenu: ElementRef;
    
    private dropDownMenuExpanded: boolean = false;
    
    constructor(){}

    hideDropDownMenu(){
        this.dropDownMenuExpanded = false;
    }

    clickOnElement(menuElement: MenuEntity){
        this.clickInMenu.emit(menuElement);
    }

    handleClick(event:any) {
        let clickedComponent = event.target;
        let inside = false;
        
        if(this.dropDownMenuExpanded) {
            do {
                if(clickedComponent === this.dropDownMenu.nativeElement) {
                    inside = true;
                }
                clickedComponent = clickedComponent.parentNode;
            } while (clickedComponent);
            if(!inside) {
                this.hideDropDownMenu();
            }
        }
    }
}

export interface MenuEntity
{
    title: string;
    action: string;
}