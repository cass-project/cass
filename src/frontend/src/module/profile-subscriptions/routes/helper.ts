import {ProfileExtendedEntity, ProfileEntity} from "../../profile/definitions/entity/Profile";

export class ProfileSubscriptionsHelper
{
    private _current: ProfileExtendedEntity;

    get current(): ProfileExtendedEntity {
        return this._current;
    }

    set current(value: ProfileExtendedEntity) {
        this._current = value;
    }

    getCurrentProfileEntity(): ProfileExtendedEntity {
        return this.current
    }
}