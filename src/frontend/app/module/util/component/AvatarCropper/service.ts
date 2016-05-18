import {Injectable} from 'angular2/core';

@Injectable()
export class AvatarCropperService{

    crop;
    file: Blob;
    imgPath;


    public communityAvatar: boolean = false;
    public profileAvatar: boolean = false;
    public isAvatarFormVisibleFlag: boolean = false;
}