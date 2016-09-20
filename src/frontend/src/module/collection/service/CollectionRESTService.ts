import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";

import {CreateCollectionResponse200, CreateCollectionRequest} from "../definitions/paths/create";
import {RESTService} from "../../common/service/RESTService";
import {DeleteCollectionResponse200} from "../definitions/paths/delete";
import {EditCollectionRequest, EditCollectionResponse200} from "../definitions/paths/edit";
import {DeleteCollectionImageResponse200} from "../definitions/paths/image-delete";
import {SetPublicOptionsRequest, SetPublicOptionsResponse200} from "../definitions/paths/set-public-optionts";
import {
    UploadCollectionImageRequest, UploadCollectionImageProgress,
    UploadCollectionImageResponse200
} from "../definitions/paths/image-upload";
import {AuthToken} from "../../auth/service/AuthToken";

export interface CollectionRESTServiceInterface
{
    createCollection(request: CreateCollectionRequest): Observable<CreateCollectionResponse200>;
    deleteCollection(collectionId: number): Observable<DeleteCollectionResponse200>;
    editCollection(collectionId: number, request: EditCollectionRequest): Observable<EditCollectionResponse200>;
    deleteImageCollection(collectionId: number): Observable<DeleteCollectionImageResponse200>;
    setPublicOptionsCollection(collectionId: number, request: SetPublicOptionsRequest): Observable<SetPublicOptionsResponse200>;
    imageUpload(collectionId: number, request: UploadCollectionImageRequest): Observable<UploadCollectionImageProgress|UploadCollectionImageResponse200>;
    imageDelete(collectionId: number): Observable<DeleteCollectionImageResponse200>;
}

@Injectable()
export class CollectionRESTService implements CollectionRESTServiceInterface
{
    constructor(
        private rest: RESTService,
        private token: AuthToken
    ) {}

    createCollection(request: CreateCollectionRequest): Observable<CreateCollectionResponse200> {
        return this.rest.put('/backend/api/protected/collection/create', request);
    }

    deleteCollection(collectionId: number): Observable<DeleteCollectionResponse200> {
        return this.rest.delete(`/backend/api/protected/collection/${collectionId}/delete`);
    }

    editCollection(collectionId: number, request: EditCollectionRequest): Observable<EditCollectionResponse200> {
        return this.rest.post(`/backend/api/protected/collection/${collectionId}/edit`, request);
    }

    deleteImageCollection(collectionId: number): Observable<DeleteCollectionImageResponse200> {
        return this.rest.delete(`/backend/api/protected/collection/${collectionId}/image-delete`);
    }

    setPublicOptionsCollection(collectionId: number, request: SetPublicOptionsRequest): Observable<SetPublicOptionsResponse200> {
        return this.rest.post(`/backend/api/protected/collection/${collectionId}/set-public-options`, request);
    }

    imageUpload(collectionId: number, request: UploadCollectionImageRequest): Observable<UploadCollectionImageProgress|UploadCollectionImageResponse200> {
        return Observable.create(observer => {
            let xmlRequest = new XMLHttpRequest();
            let url = `/backend/api/protected/collection/${collectionId}/image-upload/crop-start/${request.crop.x1}/${request.crop.y1}/crop-end/${request.crop.x2}/${request.crop.y2}`;
            let formData = new FormData();

            formData.append("file", request.file);

            xmlRequest.open("POST", url);
            xmlRequest.setRequestHeader('Authorization', this.token.apiKey);
            xmlRequest.send(formData);

            xmlRequest.upload.onprogress = (e) => {
                if (e.lengthComputable) {
                    observer.next({
                        progress: Math.floor((e.loaded / e.total) * 100)
                    });
                }
            };

            xmlRequest.onreadystatechange = () => {
                if (xmlRequest.readyState === 4) {
                    if (xmlRequest.status === 200) {
                        observer.complete(JSON.parse(xmlRequest.response));
                    }else{
                        observer.error(xmlRequest.response);
                    }
                }
            }
        });
    }

    imageDelete(collectionId: number): Observable<DeleteCollectionImageResponse200> {
        return this.rest.delete(`/backend/api/protected/collection/${collectionId}/image-delete`);
    }
}