import {Success200} from "../../../common/definitions/common";
import {ImageCollection} from "../../../avatar/definitions/ImageCollection";

export interface DeleteCommunityImageResponse200 extends Success200
{
    image: ImageCollection;
}