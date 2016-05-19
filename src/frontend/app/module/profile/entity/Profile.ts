import {Account} from "./../../account/entity/Account";

export interface ProfileEntity
{
    id: number;
    account_id: number;
    is_current: boolean;
    is_initialized: boolean;
    greetings: ProfileGreetingsEntity;
    image: ProfileImageEntity;
    expert_in: any;
    interesting_in: any;
}

export interface ProfileGreetingsEntity
{
    id: number;
    profile_id: number;
    greetings_method: string;
    greetings: string;
    first_name: string;
    last_name: string;
    middle_name: string;
    nickname: string;
}

export interface ProfileImageEntity
{
    id: string;
    profile_id: number;
    public_path: string;
}

export class Profile
{
    static AVATAR_DEFAULT = '/public/assets/profile-default.png';

    constructor(public owner: Account, public entity: ProfileEntity) {}

    getId(): number {
        return this.entity.id;
    }

    greetings(): string {
        return this.entity.greetings.greetings;
    }

    public isCurrent(): boolean {
        return !!this.entity.is_current;
    }

    public setAsCurrent(): Profile {
        this.entity.is_current = true;

        return this;
    }

    public unsetAsCurrent(): Profile {
        this.entity.is_current = false;

        return this;
    }
}