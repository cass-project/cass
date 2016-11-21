import {FeedEntity} from "./entity";

export class Stream<T extends FeedEntity>
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

    deleteElement(id: number){
        for(let i = 0; i < this.entities.length; i++){
            if(id === this.entities[i].id){
                this.entities.splice(i, 1);
            }
        }
    }
    
    insertBefore(entity: T) {
        this.entities.unshift(entity);
    }
    
    size(): number {
        return this.entities.length;
    }
}