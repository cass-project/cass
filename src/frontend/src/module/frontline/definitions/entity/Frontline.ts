import {Success200} from "../../../common/definitions/common";
import {AccountEntity} from "../../../account/definitions/entity/Account";
import {ProfileExtendedEntity} from "../../../profile/definitions/entity/Profile";
import {Palette} from "../../../colors/definitions/entity/Palette";
import {Theme} from "../../../theme/definitions/entity/Theme";

export interface FrontlineEntity extends Success200
{
    auth?: {
        api_key: string,
        account: AccountEntity,
        profiles: Array<ProfileExtendedEntity>,
    },
    themes: Theme[];
    config: {
        account: {
            delete_account_request_days: number
        },
        profile: {
            max_profiles: number
        },
        palettes: Palette[],
        community: {
            features: {
                code: string;
                is_development_ready: boolean,
                is_production_ready: boolean,
            }[]
        },
        feedback: {
            types: {
                code: {
                    int:number,
                    string:string
                },
                title:string,
                description:string
            }[]
        }
    }
}