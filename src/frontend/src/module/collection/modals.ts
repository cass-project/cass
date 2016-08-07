import {Injectable} from "angular2/core";

import {ModalControl} from "../common/classes/ModalControl";

@Injectable()
export class CollectionModals
{
    public create: ModalControl;
    public settings: ModalControl;
}