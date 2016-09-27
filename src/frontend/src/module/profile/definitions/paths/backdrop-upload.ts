import {Success200} from "../../../common/definitions/common";

export interface ProfileBackdropUploadRequest
{
    file: Blob;
}

export interface ProfileBackdropUploadResponse200 extends Success200
{
    backdrop: {
        public: string;
        storage: string;
    }
}