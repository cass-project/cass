import {Injectable} from "@angular/core";

import {ModalControl} from "../../common/classes/ModalControl";

@Injectable()
export class SearchModalService
{
    public modal: ModalControl = new ModalControl();
}