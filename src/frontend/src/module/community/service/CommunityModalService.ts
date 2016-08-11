import {Injectable} from "@angular/core";

import {ModalControl} from "../../common/classes/ModalControl";

@Injectable()
export class CommunityModalService
{
    route: ModalControl = new ModalControl();
    join: ModalControl = new ModalControl();
    create: ModalControl = new ModalControl();
    settings: ModalControl = new ModalControl();
    createCollection: ModalControl = new ModalControl();
}