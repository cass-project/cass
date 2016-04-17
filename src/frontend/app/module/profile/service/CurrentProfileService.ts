import {Injectable} from 'angular2/core';


@Injectable()
export class CurrentProfileService
{
    public profile: Profile;
    public currentAvatar: string;

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
        this.currentAvatar = this.profile.avatar.publicUrl;
        console.log(this.currentAvatar);
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