import {Injectable} from "@angular/core";

@Injectable()
export class UIPathService
{
    private path: UIPathItem[] = [];

    public setPath(path: UIPathItem[]) {
        this.path = path;
    }

    public pushPath(item: UIPathItem) {
        this.path.push(item);
    }

    hasPath(): boolean {
        return this.path.length > 0;
    }

    public getPath(): UIPathItem[] {
        return this.path;
    }
}

export interface UIPathItem
{
    name: string;
    route: Array<any>;
}