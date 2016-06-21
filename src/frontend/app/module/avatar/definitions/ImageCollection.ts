import {Image} from "./Image";

export interface ImageCollection {
    uid?: string;
    variants: { [size: string]: Image };
}