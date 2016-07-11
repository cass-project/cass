import {Injectable} from "angular2/core";
import {Http, Headers} from "angular2/http"

import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";
import {Collection} from "../definitions/entity/collection";
import {Observable} from "rxjs/Observable";
import {CreateCollectionResponse200} from "../definitions/paths/create";

@Injectable()
export class CollectionRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    private xmlRequest = new XMLHttpRequest();

    public tryNumber:number = 0;
    public progressBar:number = 0;

    createCollection(collection: Collection): Observable<CreateCollectionResponse200>
    {
        let authHeader = new Headers();
        
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.put('/backend/api/protected/collection/create', JSON.stringify({
            owner_sid: collection.owner_sid,
            theme_ids: collection.theme_ids,
            title: collection.title,
            description: collection.description
        }), {headers: authHeader}));
    }

    deleteCollection(collectionId: number)
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.delete(`/backend/api/protected/collection/${collectionId}/delete`, {headers: authHeader}));
    }

    editCollection(collectionId: number, theme_ids: Array<number>, title: string, description: string)
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.post(`/backend/api/protected/collection/${collectionId}/edit`, JSON.stringify({
            theme_ids: theme_ids,
            title: title,
            description: description
        }), {headers: authHeader}));
    }

    deleteImageCollection(collectionId: number)
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.delete(`/backend/api/protected/collection/${collectionId}/image-delete`, {headers: authHeader}));
    }

    setPublicOptionsCollection(collectionId: number, is_private: boolean, public_enabled: boolean, moderation_enabled: boolean)
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.post(`/backend/api/protected/collection/${collectionId}/set-public-options`, JSON.stringify({
            is_private: is_private,
            public_enabled: public_enabled,
            moderation_enabled: moderation_enabled
        }), {headers: authHeader}));
    }

    setImageCollection(collectionId: number ,file, model, modal)
    {
        this.tryNumber++;

        let crop = {
            start: {
                x: model.x,
                y: model.y
            },
            end: {
                x: model.width + model.x,
                y: model.height + model.y
            }
        };

        let url = `/backend/api/protected/collection/${collectionId}/image-upload/crop-start/${crop.start.x}/${crop.start.y}/crop-end/${crop.end.x}/${crop.end.y}`;
        let formData = new FormData();
        formData.append("file", file);


        this.xmlRequest.open("POST", url);
        this.xmlRequest.setRequestHeader('Authorization', this.token.apiKey);
        this.xmlRequest.upload.onprogress = (e) => {
            if (e.lengthComputable) {
                this.progressBar = Math.floor((e.loaded / e.total) * 100);
                modal.progress.update(this.progressBar);
            }
        };

        this.xmlRequest.send(formData);

        this.xmlRequest.onreadystatechange = () => {
            if (this.xmlRequest.readyState === 4) {
                if (this.xmlRequest.status === 200) {
                    /* TODO: Добавить локальное обновление картинки". */
                }
                modal.progress.complete();
                if(modal.close){
                    modal.close();
                } else {
                    modal.screen.next();
                }
                this.progressBar = 0;
                this.tryNumber = 0;
            }
        }
    }
}