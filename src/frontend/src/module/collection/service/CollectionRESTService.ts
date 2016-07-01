import {Injectable} from "angular2/core";
import {Http} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {Account} from "../../account/definitions/entity/Account";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthService} from "../../auth/service/AuthService";

@Injectable()
export class CollectionRESTService extends AbstractRESTService {
    constructor(
        protected http: Http,
        protected auth: AuthService,
        protected messages: MessageBusService
    ) { super(http, auth, messages) }

    private xmlRequest = new XMLHttpRequest();

    public tryNumber:number = 0;
    public progressBar:number = 0;

    createCollection(owner_sid: string, theme_ids: Array<number>, title: string, description: string)
    {
        return this.handle(this.http.post('/backend/api/protected/collection/create', JSON.stringify({
            owner_sid: owner_sid,
            theme_ids: theme_ids,
            title: title,
            description: description
        })));
    }

    deleteCollection(collectionId: number)
    {
        return this.handle(this.http.delete(`/backend/api/protected/collection/${collectionId}/delete`));
    }

    editCollection(collectionId: number, theme_ids: Array<number>, title: string, description: string)
    {
        return this.handle(this.http.post(`/backend/api/protected/collection/${collectionId}/edit`, JSON.stringify({
            theme_ids: theme_ids,
            title: title,
            description: description
        })));
    }

    deleteImageCollection(collectionId: number)
    {
        return this.handle(this.http.delete(`/backend/api/protected/collection/${collectionId}/image-delete`));
    }

    setPublicOptionsCollection(collectionId: number, is_private: boolean, public_enabled: boolean, moderation_enabled: boolean)
    {
        return this.handle(this.http.post(`/backend/api/protected/collection/${collectionId}/set-public-options`, JSON.stringify({
            is_private: is_private,
            public_enabled: public_enabled,
            moderation_enabled: moderation_enabled
        })));
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
            /* TODO: Сделать нормальный метод повтора загрузки с учетом "Отмены загрузки". */
        }
    }
}