import {OpenGraphEntity} from "../../../../opengraph/definitions/entity/og";

export interface YouTubeLinkAttachment
{
    url: string;
    metadata: {
        og: OpenGraphEntity,
        youtube: {
            id: string;
        }
    };
}