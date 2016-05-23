export class ScreenControls<T>
{
    public current: T;
    private map = {};

    constructor(defaults: T, map?: { (sc: ScreenControls<T>) }) {
        this.current = defaults;

        if(map) {
            map(this);
        }
    }

    public add(rule: MapDefinition<T>): ScreenControls<T> {
        this.map[<any>rule.from] = <any>rule.to;

        return this;
    }

    next() {
        if(this.map.hasOwnProperty(<any>this.current)) {
            this.current = this.map[<any>this.current];
        }else{
            throw new Error('Nowhere to go.');
        }
    }

    previous() {
        throw new Error('NOT IMPLEMENTED');
    }

    isOn(stage: T) {
        return this.current === stage;
    }

    isIn(stages: Array<T>) {
        return ~stages.indexOf(this.current);
    }

    notIn(stages: Array<T>) {
        return !~stages.indexOf(this.current);
    }
}

interface MapDefinition<T>
{
    from: T;
    to: T;
}