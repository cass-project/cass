import {ImageCollection} from "../../../avatar/definitions/ImageCollection";
import {Account} from "../../../account/definitions/entity/Account";
import {CollectionEntity} from "../../../collection/definitions/entity/collection";

export interface ProfileExtendedEntity {
    collection: CollectionEntity;
    profile: ProfileEntity;
}

export interface ProfileEntity {
    id:number;
    sid:string;
    account_id:number;
    is_current:boolean;
    is_initialized:boolean;
    interesting_in_ids: Array<number>;
    expert_in_ids: Array<number>;
    image:ImageCollection;
    greetings:ProfileGreetingsEntity;
    gender:ProfileGenderEntity;
    disabled:ProfileDisabledEntity;
}

export interface ProfileGreetingsEntity {
    method:string;
    greetings:string;
    first_name:string;
    last_name:string;
    middle_name:string;
    nick_name:string;
}

export interface ProfileGenderEntity {
    int:number;
    string:string;
}

export interface ProfileGenderEntity {
    id:string;
    profile_id:number;
    public_path:string;
}

export interface ProfileDisabledEntity {
    is_disabled:boolean;
    reason:string;
}

export class Profile {
    static AVATAR_DEFAULT = '/dist/assets/profile-default.png';

    constructor(public owner: Account, public entity: ProfileExtendedEntity) {
    }

    getId():number {
        return this.entity.profile.id
    }

    greetings():string {
        return this.entity.profile.greetings.greetings;
    }

    public isCurrent():boolean {
        return !!this.entity.profile.is_current;
    }

    public setAsCurrent():Profile {
        this.entity.profile.is_current = true;

        return this;
    }

    public unsetAsCurrent():Profile {
        this.entity.profile.is_current = false;

        return this;
    }
}