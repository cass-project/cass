import {ProfileEntity} from "../../../profile/definitions/entity/Profile";

export interface ContactEntity
{
    id: number;
    sid: string;
    date_created_on: string;
    source_profile: ProfileEntity;
    target_profile: ProfileEntity;
    permanent: {
        is: boolean;
        date?: string;
    },
    last_message: {
        has: boolean;
        date?: string;
        message?: string;
    }
}