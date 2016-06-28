import {Injectable} from "angular2/core";
import {PROFILE_GENDER_LIST, ProfileGender, ProfileEntity} from "../../../definitions/entity/Profile";
import {queryImage, QueryTarget} from "../../../../avatar/functions/query";
import {Image} from "../../../../avatar/definitions/Image";

@Injectable()
export class ProfileSetupModel
{
    static DEFAULT_GREETINGS_METHOD = 'fl';

    private profile: ProfileEntity;
    
    public gender: ProfileGender = PROFILE_GENDER_LIST[0];
    public interestingIn: Array<number> = [];
    public expertIn: Array<number> = [];

    greetings: {
        method: string,
        firstName: string;
        lastName: string;
        middleName: string;
        nickName: string
    } = {
        method: ProfileSetupModel.DEFAULT_GREETINGS_METHOD,
        firstName: '',
        lastName: '',
        middleName: '',
        nickName: '',
    };

    specifyProfile(profile: ProfileEntity) {
        this.profile = profile;
    }

    getProfile(): ProfileEntity {
        return this.profile;
    }

    getProfileImage(): Image {
        return queryImage(QueryTarget.Biggest, this.profile.image);
    }

    isGreetingsChecked(method: string): boolean {
        return this.greetings.method === method;
    }

    setGreetingsMethod(method: string) {
        this.greetings.method = method;
    }

    normalizeGreetings() {
        let notReset = this.greetings.method.split('');

        if (!~notReset.indexOf('f')) this.greetings.firstName = '';
        if (!~notReset.indexOf('l')) this.greetings.lastName = '';
        if (!~notReset.indexOf('m')) this.greetings.middleName = '';
        if (!~notReset.indexOf('n')) this.greetings.nickName = '';
    }
    
    useGender(gender: ProfileGender) {
        if(!~PROFILE_GENDER_LIST.indexOf(gender)) {
            throw new Error("We don't care about SJW.");
        }

        this.gender = gender;
    }

    setInterestingIn(themeIds: Array<number>) {
        this.interestingIn = themeIds.filter((input) => {
            return typeof input === "number";
        })
    }

    setExpertIn(themeIds: Array<number>) {
        this.expertIn = themeIds.filter((input) => {
            return typeof input === "number";
        })
    }
}