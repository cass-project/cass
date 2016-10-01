import {Attachment} from "./component/Elements/Attachment/index";
import {AttachmentError} from "./component/Elements/AttachmentError/index";
import {AttachmentLinkImage} from "./component/Elements/AttachmentLinkImage/index";
import {ATTACHMENT_LINK_DIRECTIVES} from "./component/Elements/AttachmentLink/index";
import {ATTACHMENT_WEBM_DIRECTIVES} from "./component/Elements/AttachmentWebm/index";
import {ATTACHMENT_YOUTUBE_DIRECTIVES} from "./component/Elements/AttachmentYouTube/index";
import {AttachmentRESTService} from "./service/AttachmentRESTService";
import {ATTACHMENT_PAGE_DIRECTIVES} from "./component/Elements/AttachmentPage/index";

export const CASSAttachmentModule = {
    declarations: [
        Attachment,
        AttachmentError,
        AttachmentLinkImage,
        ATTACHMENT_PAGE_DIRECTIVES,
        ATTACHMENT_LINK_DIRECTIVES,
        ATTACHMENT_WEBM_DIRECTIVES,
        ATTACHMENT_YOUTUBE_DIRECTIVES,
    ],
    providers: [
        AttachmentRESTService,
    ]
};