import {Injectable} from "angular2/core";
import {Http} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {Account} from "../../account/definitions/entity/Account";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthService} from "../../auth/service/AuthService";

@Injectable()
export class PostAttachmentRESTService extends AbstractRESTService {
    private xmlRequest = new XMLHttpRequest();

    public tryNumber:number = 0;
    public progressBar:number = 0;

    constructor(
        protected http: Http,
        protected auth: AuthService,
        protected messages: MessageBusService
    ) { super(http, auth, messages) }

    attachFile(collectionId: number, file, modal)
    {
        this.tryNumber++;


        let url = `/backend/api/protected/post-attachment/upload`;
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
                    /* TODO: Добавить локальное обновление превью файла". */
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
