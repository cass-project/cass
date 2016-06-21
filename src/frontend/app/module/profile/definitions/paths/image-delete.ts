import {ImageCollection} from "../../../avatar/definitions/ImageCollection";
import {Success200} from "../../../common/definitions/common";

export interface DeleteProfileImageResponse200 extends Success200
{
    image: ImageCollection;
}