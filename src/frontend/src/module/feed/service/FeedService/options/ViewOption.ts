export enum ViewOptionValue
{
    Feed = <any>"feed",
    Grid = <any>"grid",
    Table = <any>"table"
}

export class ViewOption
{
    current: ViewOptionValue;

    current() {
        return this.current;
    }
    
    setAsCurrent(value: ViewOptionValue) {
        this.current = value;
    }

    isOn(compare: ViewOptionValue) {
        return this.current === compare;
    }
}