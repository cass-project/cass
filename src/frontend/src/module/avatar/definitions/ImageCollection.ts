import {Image} from "./Image";

export interface ImageCollection {
    uid?: string;
    is_auto_generated: boolean;
    variants: { [size: string]: Image };
}