import {Response} from "@angular/http";

export interface Success200 extends Response {
    success: boolean;
}

export interface Error {
    success: boolean;
    error: string;
}

export interface AuthErrorResponse403 extends Error {}
export interface NotFound404 extends Error {}
export interface Conflict409 extends Error {}