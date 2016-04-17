import {Profile, ProfileEntity} from "./../../profile/entity/Profile";

export interface AccountEntity
{
    id: string;
    email: string;
    disabled: {
        is_disabled: boolean;
        reason: string
    }
}

export class Account
{
    public profiles: Profiles;

    constructor(public entity: Account, profiles: Array<ProfileEntity>) {
        this.profiles = new Profiles(profiles.map(entity => {
            return new Profile(this, entity);
        }));
    }
}

class Profiles
{
    constructor(public profiles: Array<Profile>) {}

    getCurrent() {
        for(let profile of this.profiles) {
            if(profile.isCurrent()) {
                return profile;
            }
        }

        return this.setProfileAsCurrent(this.profiles[0].getId());
    }

    setProfileAsCurrent(profileId: number): Profile {
        let selectedProfile: Profile;

        if(! this.containsProfileWithId(profileId)) {
            throw new Error(`There is known profile with id '${profileId}'`);
        }

        for(let profile of this.profiles) {
            if(profile.entity.id === profileId) { /* profile to set as current */
                selectedProfile = profile.setAsCurrent();
            }else{
                profile.unsetAsCurrent();
            }
        }

        return selectedProfile;
    }

    containsProfileWithId(profileId: number) {
        for(let profile of this.profiles) {
            if(profile.entity.id === profileId) {
                return true;
            }
        }

        return false;
    }

    containsProfile(search: Profile) {
        for(let profile of this.profiles) {
            if(profile.entity.id === search.entity.id) {
                return true;
            }
        }

        return false;
    }
}