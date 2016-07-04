import {ImageCollection} from "../definitions/ImageCollection";
import {Image} from "../definitions/Image";

export enum QueryTarget {
    Biggest,
    Smallest,
    Avatar,
    Card
}

export function queryImage(target: QueryTarget, images: ImageCollection): Image {
    let sizes = ['16', '32', '64', '128', '256', '512'];

    if(target === QueryTarget.Biggest) {
        sizes.reverse();
    }else if(target === QueryTarget.Avatar) {
        sizes = ['32', '64'];
    }else if(target === QueryTarget.Card) {
        sizes = ['256', '128', '64'];
    }

    for(let size of sizes) {
        if(images.variants.hasOwnProperty(size)) {
            return images.variants[size];
        }
    }

    return images.variants['default'];
}