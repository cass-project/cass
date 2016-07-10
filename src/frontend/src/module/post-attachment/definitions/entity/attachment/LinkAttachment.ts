import {OpenGraphEntity} from "../../../../opengraph/definitions/entity/og";

export interface LinkAttachment
{
    url: string;
    metadata: {
        og: OpenGraphEntity
    };
}