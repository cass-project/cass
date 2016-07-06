import {Component} from "angular2/core";
declare var jQuery;

@Component({
    selector: 'cass-feedback-landing-sidebar-toggler',
    template: require('./template.jade'),
})
export class SidebarTogglerComponent {

    toggleMenu() {
        jQuery('.row-offcanvas').toggleClass('active');
    }

}