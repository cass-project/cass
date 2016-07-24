import {PostAttachmentEntity} from "../../../../post-attachment/definitions/entity/PostAttachment";
import {CreatePostRequest} from "../../../definitions/paths/create";

export class PostFormModel
{
    public content: string = '';
    public attachments: PostAttachmentEntity<any>[] = [];

    constructor(
        public postType: number,
        public profileId: number,
        public collectionId: number
    ) {}

    createRequest(): CreatePostRequest {
        // ...
        return {
            post_type: this.postType,
            profile_id: this.profileId,
            collection_id: this.collectionId,
            content: this.content,
            attachments: this.attachments.map((attachment) => {
                return attachment.id;
            }),
        }
    }

    reset() {
        this.content = '';
        this.deleteAttachments();
    }

    isEmpty(): boolean {
        let testHasContent = this.content.length > 0;
        let testHasAttachments = this.attachments.length > 0;

        return ! (testHasContent || testHasAttachments);
    }

    isValid(): boolean {
        return ! this.isEmpty();
    }

    hasAttachments(): boolean
    {
        return this.attachments.length > 0;
    }

    getAllAttachments(): PostAttachmentEntity<any>[]
    {
        return this.attachments;
    }

    getAttachment(): PostAttachmentEntity<any>
    {
        return this.attachments[0];
    }

    addAttachment(attachment: PostAttachmentEntity<any>) {
        this.attachments = [];
        this.attachments.push(attachment);
    }

    deleteAttachments() {
        this.attachments = [];
    }
}