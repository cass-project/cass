import {Criteria} from "../Criteria";

export class SeekCriteria implements Criteria
{
    static DEFAULT_PAGE_SIZE = 50;

    private offset: number = 0;
    private limit: number = SeekCriteria.DEFAULT_PAGE_SIZE;

    public getName(): string {
        return 'seek';
    }

    public setSeek(offset: number, limit: number) {
        this.offset = offset;
        this.limit = limit;
    }

    public getOffset(): number {
        return this.offset;
    }

    public getLimit(): number {
        return this.limit;
    }

    public isAvailable(): boolean {
        return true;
    }

    public getParams(): any {
        return {
            'offset': this.offset,
            'limit': this.limit
        }
    }
}