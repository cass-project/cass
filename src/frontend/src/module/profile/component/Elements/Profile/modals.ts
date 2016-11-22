import {Injectable} from "@angular/core";

import {ModalControl} from "../../../../common/classes/ModalControl";

@Injectable()
export class ProfileModals
{
    private themeId: number;

    setup: ModalControl = new ModalControl();
    settings: ModalControl = new ModalControl();
    switcher: ModalControl = new ModalControl();
    interests: ModalControl = new ModalControl();
    createCollection: ModalControl = new ModalControl();
    backdrop: ModalControl = new ModalControl();

    openCreateCollection(themeId?: number) {
        this.themeId = themeId || undefined;
        this.createCollection.open();
    };
}