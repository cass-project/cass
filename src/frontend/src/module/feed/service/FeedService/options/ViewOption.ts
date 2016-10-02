export enum ViewOptionValue
{
    Feed = <any>"feed",
    Grid = <any>"grid",
    Table = <any>"table",
    List = <any>"list"
}

export class ViewOption
{
    current: ViewOptionValue = ViewOptionValue.Grid;

    setAsCurrent(value: ViewOptionValue) {
        this.current = value;
    }

    isOn(compare: ViewOptionValue) {
        return this.current === compare;
    }
}