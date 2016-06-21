import {ProfileEntity, Profile} from "../../../profile/definitions/entity/Profile";

export interface AccountEntity {
    id: string;
    email: string;
    disabled: AccountDisabledEntity,
    delete_request: AccountDeleteRequestEntity;
}

export interface AccountDeleteRequestEntity {
    has: boolean;
    date: string;
}

export interface AccountDisabledEntity {
    is_disabled: boolean;
    reason: string
}

export class Account {
    public profiles: AccountProfiles;

    constructor(public entity: AccountEntity, profiles: Array<ProfileEntity>) {
        this.profiles = new AccountProfiles(profiles.map(entity => {
            return new Profile(this, entity);
        }));
    }
}

export class AccountProfiles {
    constructor(public profiles: Array<Profile>) {
    }

    getCurrent(): Profile {
        for (let profile of this.profiles) {
            if (profile.isCurrent()) {
                return profile;
            }
        }

        return this.setProfileAsCurrent(this.profiles[0].getId());
    }

    setProfileAsCurrent(profileId: number): Profile {
        let selectedProfile: Profile;

        if (!this.containsProfileWithId(profileId)) {
            throw new Error(`There is known profile with id '${profileId}'`);
        }

        for (let profile of this.profiles) {
            if (profile.entity.id === profileId) { /* profile to set as current */
                selectedProfile = profile.setAsCurrent();
            } else {
                profile.unsetAsCurrent();
            }
        }

        return selectedProfile;
    }

    containsProfileWithId(profileId: number) {
        for (let profile of this.profiles) {
            if (profile.entity.id === profileId) {
                return true;
            }
        }

        return false;
    }

    containsProfile(search: Profile) {
        for (let profile of this.profiles) {
            if (profile.entity.id === search.entity.id) {
                return true;
            }
        }

        return false;
    }
}