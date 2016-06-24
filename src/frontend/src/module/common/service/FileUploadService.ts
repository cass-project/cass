import { Component } from 'angular2/core';
import { Injectable } from 'angular2/core';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/share';

@Injectable()
export class FileUploadService {
    private progress$: Observable<number>;

    progress: number = 0;

    private progressObserver: any;

    constructor () {
        this.progress$ = new Observable(observer => {
            this.progressObserver = observer
        });
    }

    public getObserver (): Observable<number> {
        return this.progress$;
    }

    public upload (url: string, files: File[]): Promise<any> {
        return new Promise((resolve, reject) => {
            let formData: FormData = new FormData(),
                xhr: XMLHttpRequest = new XMLHttpRequest();

            for (let i = 0; i < files.length; i++) {
                formData.append("uploads[]", files[i], files[i].name);
            }

            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        resolve(JSON.parse(xhr.response));
                    } else {
                        reject(xhr.response);
                    }
                }
            };

            FileUploadService.setUploadUpdateInterval(100);

            xhr.upload.onprogress = (event) => {
                this.progress = Math.round(event.loaded / event.total * 100);

                this.progressObserver.next(this.progress);
            };

            xhr.open('POST', url, true);
            xhr.send(formData);
        });
    }

    private static setUploadUpdateInterval (interval: number): void {
        setInterval(() => {}, interval);
    }
}