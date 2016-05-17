export class ComponentStages<T>
{
    current: T;

    constructor(defaults: T) {
        this.current = defaults;
    }

    isOn(stage) {
        return this.current == stage;
    }

    go(stage) {
        this.current = stage;
    }
}