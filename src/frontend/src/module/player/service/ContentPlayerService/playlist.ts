import {AttachmentEntity} from "../../../attachment/definitions/entity/AttachmentEntity";

export class Playlist
{
    private current: AttachmentEntity<any>;
    private playlist: AttachmentEntity<any>[] = [];

    public getPlaylist(): AttachmentEntity<any>[] {
        return this.playlist;
    }

    public setPlaylist(playlist: AttachmentEntity<any>[]) {
        this.playlist = playlist;
    }

    public push(attachment: AttachmentEntity<any>) {
        if(! this.has(attachment)) {
            this.playlist.push(attachment);
        }
    }

    public empty() {
        this.playlist = [];
    }

    public emptyExlcudeCurrent() {
        if(! this.isEmpty()) {
            this.playlist = this.playlist.filter(item => {
                return item === this.current;
            })
        }
    }

    public isEmpty(): boolean {
        return this.playlist.length === 0;
    }

    has(attachment: AttachmentEntity<any>): boolean {
        for(let compare of this.playlist) {
            if(compare.id === attachment.id) {
                return true;
            }
        }

        return false;
    }

    public setAsCurrent(attachment: AttachmentEntity<any>) {
        if(! this.has(attachment)) {
            throw new Error('Not in list');
        }

        this.current = attachment;
    }

    public getCurrent(): AttachmentEntity<any> {
        if(this.isEmpty()) {
            throw new Error('List is empty');
        }else{
            if(! this.current) {
                this.current = this.playlist[0];
            }
        }

        return this.current;
    }

    public next() {
        if(! this.isEmpty()) {
            let currentIndex = this.getOrderNum(this.current);

            if(this.getTotalEntries() === currentIndex) {
                this.current = this.playlist[0];
            }else{
                this.current = this.playlist[currentIndex + 1];
            }
        }
    }

    public prev() {
        if(! this.isEmpty()) {
            let currentIndex = this.getOrderNum(this.current);

            if(currentIndex === 0) {
                this.current = this.playlist[this.getTotalEntries() - 1];
            }else{
                this.current = this.playlist[currentIndex - 1];
            }
        }
    }

    public shuffle() {
        let counter = this.playlist.length;

        while (counter > 0) {
            let index = Math.floor(Math.random() * counter);

            counter--;

            // And swap the last element with it
            let temp = this.playlist[counter];
            this.playlist[counter] = this.playlist[index];
            this.playlist[index] = temp;
        }

        return this.playlist;
    }

    public getTotalEntries(): number {
        return this.playlist.length;
    }

    public getOrderNum(attachment: AttachmentEntity<any>): number {
        for(let index = 0; index < this.playlist.length; index++) {
            if(this.playlist.hasOwnProperty(index)) {
                if(this.playlist[index] === attachment) {
                    return index;
                }
            }
        }

        throw new Error('Not in list');
    }
}