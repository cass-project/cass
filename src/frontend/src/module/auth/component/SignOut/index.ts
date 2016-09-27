import {Component, Output, EventEmitter, ElementRef, ViewChild} from "@angular/core";

import {AuthService} from "../../service/AuthService";
import {LoadingManager} from "../../../common/classes/LoadingStatus";

@Component({
    selector: 'cass-auth-sign-out',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class SignOutComponent
{
    @Output('close') closeEvent: EventEmitter<Boolean> = new EventEmitter<Boolean>();
    @Output('success') successEvent: EventEmitter<Boolean> = new EventEmitter<Boolean>();
    @ViewChild('yesButton') private yesButton: ElementRef;

    private status: LoadingManager = new LoadingManager();

    constructor(private authService: AuthService) {}

    ngOnViewInit() {
        this.yesButton.nativeElement.focus();
    }

    yes() {
        let loading = this.status.addLoading();

        this.authService.signOut().subscribe(
            success => {
                loading.is = false;
                window.location.href = '/';
                this.successEvent.emit(true);
            },
            error => {
                loading.is = false;
            }
        )
    }

    no() {
        this.closeEvent.emit(true);
    }

    cancel() {
        this.closeEvent.emit(true);
    }
}