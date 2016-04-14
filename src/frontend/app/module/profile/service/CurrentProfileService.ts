import {Injectable} from 'angular2/core';

@Injectable()
export class CurrentProfileService
{
    private profile: Profile;

    isAvailable(): boolean {
        return !!this.profile;
    }

    set(profile: Profile) {
        this.profile = profile;
    }

    empty() {
        this.profile = null;
    }

    get(): Profile {
        if(!this.isAvailable()) {
            throw new Error('No profile available');
        }

        return this.profile;
    }
}

export class ProfileWelcomeInfo
{
    nickname: string;
    firstname: string;
    lastname: string;
    middlename: string;
}

export interface Profile
{
    id: number;
    name: string;
    email: string;
    avatar: {
        publicUrl: string;
        size: {
            width: number;
            height: number;
        }
    }
}