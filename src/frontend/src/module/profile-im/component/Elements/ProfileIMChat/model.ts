import {Injectable} from "angular2/core";

import {ProfileExtendedEntity} from "../../../../profile/definitions/entity/Profile";

@Injectable()
export class ProfileIMMessagesModel {
    history: ProfileIMMessageModel[] = [];
    unread: ProfileIMMessageModel[] = [];
}

export class ProfileIMMessageModel {
    source_profile:ProfileExtendedEntity;
    target_profile_id:number;
    content:string;
    date:Date;
    is_sended:boolean;
    has_error:boolean;
}
