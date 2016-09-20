import {Success200} from "../../../common/definitions/common";
import {AccountEntity} from "../../../account/definitions/entity/Account";
import {ProfileExtendedEntity} from "../../../profile/definitions/entity/Profile";
import {Palette} from "../../../colors/definitions/entity/Palette";
import {Theme} from "../../../theme/definitions/entity/Theme";
import {PostTypeEntity} from "../../../post/definitions/entity/PostType";
import {CommunityFeatureEntity} from "../../../community/definitions/entity/CommunityFeature";

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
        themes: {
            www: string;
        },
        palettes: Palette[],
        community: {
            features: CommunityFeatureEntity[]
        },
        post: {
            types: PostTypeEntity[]
        }
    }
}