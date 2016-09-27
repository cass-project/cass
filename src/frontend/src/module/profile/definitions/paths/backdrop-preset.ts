import {Success200} from "../../../common/definitions/common";

export interface ProfileBackdropPresetRequest
{
    presetId: string;
}

export interface ProfileBackdropPresetResponse200 extends Success200
{
    backdrop: {
        public: string;
        storage: string;
    }
}