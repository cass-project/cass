import {Success200} from "../../../common/definitions/common";
import {OpenGraphEntity} from "../entity/og";

export interface GetOpenGraphResponse200 extends Success200
{
    entity: OpenGraphEntity;
}