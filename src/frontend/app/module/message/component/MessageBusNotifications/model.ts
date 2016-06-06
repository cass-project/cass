export class MessageBusNotificationsModel {
    id:number;
    level:MessageBusNotificationsLevel;
    date:Date = new Date();
    message:string;
}

export enum MessageBusNotificationsLevel {
    Critical = <any>"critical",
    Warning = <any>"warning",
    Info = <any>"info",
    Debug = <any>"debug",
}