import {Component, Input, EventEmitter, Output} from "angular2/core";

import {ProfileEntity} from "../../../definitions/entity/Profile";
import {ThemeSelect} from "../../../../theme/component/ThemeSelect/index";
import {ProgressLock} from "../../../../form/component/ProgressLock/index";

@Component({
    selector: 'cass-profile-interests-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ThemeSelect,
        ProgressLock,
    ]
})
export class ProfileInterestsModal
{
    private loading: boolean = false;

    @Input('profile') entity: ProfileEntity;

    @Output('close') closeEvent: EventEmitter<string> = new EventEmitter<string>();
    @Output('success') closeEvent: EventEmitter<string> = new EventEmitter<string>();
}