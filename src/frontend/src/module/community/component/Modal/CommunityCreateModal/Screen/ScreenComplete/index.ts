import {Component, Output, EventEmitter} from "angular2/core";
import {Router} from "angular2/router";

import {Screen} from "../../screen";
import {CommunityCreateModalModel} from "../../model";

@Component({
    selector: 'cass-community-create-modal-screen-complete',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ScreenComplete
{
    @Output("close") closeEvent = new EventEmitter<ScreenComplete>();

    constructor(public model: CommunityCreateModalModel, private router: Router){}

    close() {
        this.closeEvent.emit(this);
    }

    goToCommunity() {
        this.close();
        this.router.navigate([`/Community`, this.model.sid]);
    }

}