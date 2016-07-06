export interface Criteria
{
    getName(): string;
    getParams(): any;
    isAvailable(): boolean;
}