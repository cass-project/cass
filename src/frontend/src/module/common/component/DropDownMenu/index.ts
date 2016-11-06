import {Component, Input, Output, EventEmitter, ViewChild, ElementRef} from "@angular/core";

export interface MenuEntity {
    title: string;
    action: string;
    icon?: string;
}

export enum DropDownMenuStyle {
    Small = <any>"small",
    Medium = <any>"medium",
    Large = <any>"large",
}

@Component({
    selector: 'cass-dropdown-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    host: {
        '(document:click)': 'handleClick($event)',
    },
})
export class DropDownMenu {
    @Input('style') private style: DropDownMenuStyle = DropDownMenuStyle.Small;
    @Input('menu') private menu: Array<MenuEntity>;
    @Output('clickInMenu') private clickInMenu: EventEmitter<MenuEntity> = new EventEmitter<MenuEntity>();
    @ViewChild('dropDownMenu') private dropDownMenu: ElementRef;

    private dropDownMenuExpanded: boolean = false;

    hideDropDownMenu() {
        this.dropDownMenuExpanded = false;
    }

    clickOnElement(menuElement: MenuEntity) {
        this.clickInMenu.emit(menuElement);
    }

    getCSSClassName(): string {
        return `drop-down-menu drop-down-menu-${this.style}`;
    }

    handleClick(event: any) {
        let clickedComponent = event.target;
        let inside = false;

        if (this.dropDownMenuExpanded) {
            do {
                if (clickedComponent === this.dropDownMenu.nativeElement) {
                    inside = true;
                }
                clickedComponent = clickedComponent.parentNode;
            } while (clickedComponent);
            if (!inside) {
                this.hideDropDownMenu();
            }
        }
    }

    getIconCSSClass(item: MenuEntity) {
        if(!!item.icon) {
            return `fa fa-fw fa-${item.icon}`;
        }else{
            return `fa fa-fw`;
        }
    }
}
