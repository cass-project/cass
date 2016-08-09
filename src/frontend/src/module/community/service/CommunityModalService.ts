import {Injectable} from "@angular/core";

import {ModalControl} from "../../common/classes/ModalControl";

@Injectable()
export class CommunityModalService
{
    public modals = {
        route: new ModalControl(),
        join: new ModalControl(),
        create: new ModalControl(),
        settings: new ModalControl()
    };
}