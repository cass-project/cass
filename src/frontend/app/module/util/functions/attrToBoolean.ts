export function attrToBoolean(attr: any, unknown: boolean = false): boolean {
    if(attr === "0" || attr === 0 || attr === "false" || attr === false || attr === "no") {
        return false;
    }else if(attr === "1" || attr === 1 || attr === "true" || attr === true || attr === "yes") {
        return true;
    }else{
        return unknown;
    }
}