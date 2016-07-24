import {FeedEntity} from "./entity";

export class Stream<T>
{
    private entities: T[] = [];

    all(): T[] {
        return this.entities;
    }

    empty() {
        this.entities = [];
    }

    replace(entities: T[]) {
        this.entities = entities;
    }
    
    filter(callback) {
        this.entities = this.entities.filter(callback);
    }

    push(entities: T[]) {
        entities.forEach(entity => {
            this.entities.push(entity);
        })
    }

    insertBefore(entity: T) {
        this.entities.unshift(entity);
    }
    
    size(): number {
        return this.entities.length;
    }
}