import {Attachment} from "./component/Elements/Attachment/index";
import {AttachmentError} from "./component/Elements/AttachmentError/index";
import {AttachmentLinkImage} from "./component/Elements/AttachmentLinkImage/index";
import {AttachmentLinkUnknown} from "./component/Elements/AttachmentLinkUnknown/index";
import {AttachmentLinkWebm} from "./component/Elements/AttachmentLinkWebm/index";
import {ATTACHMENT_YOUTUBE_DIRECTIVES} from "./component/Elements/AttachmentYouTube/index";
import {AttachmentRESTService} from "./service/AttachmentRESTService";
import {ATTACHMENT_PAGE_DIRECTIVES} from "./component/Elements/AttachmentPage/index";

export const CASSAttachmentModule = {
    declarations: [
        Attachment,
        AttachmentError,
        AttachmentLinkImage,
        ATTACHMENT_PAGE_DIRECTIVES,
        AttachmentLinkUnknown,
        AttachmentLinkWebm,
        ATTACHMENT_YOUTUBE_DIRECTIVES,
    ],
    providers: [
        AttachmentRESTService,
    ]
};