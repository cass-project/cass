import {Injectable} from 'angular2/core';

@Injectable()
export class AvatarCropperService{

    file: Blob;

    public isAvatarFormVisibleFlag: boolean = false;
}